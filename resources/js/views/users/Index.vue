<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page v-if="this.$route.name == 'users'" :title="$t('global.show') + ' ' + $t('sidebar.all_users')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="dataTable" id="users">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="dataTables_wrapper">
                                <div class="card">

                                    <!-- card-header -->
                                    <div class="card-header">

                                        <!-- dataTables_filters -->
                                        <div class="dataTables_filters">

                                            <trashed
                                                @getData="getData"
                                                :tableData="tableData"
                                            ></trashed>

                                            <created-between
                                                @getData="getData"
                                                :tableData="tableData"
                                            ></created-between>

                                        </div><!-- ./dataTables_filters -->

                                        <!-- dataTables_header -->
                                        <div class="dataTables_header">

                                            <!-- Search -->
                                            <search
                                                @getData="getData"
                                                :tableData="tableData"
                                            ></search>

                                            <!-- Filter columns -->
                                            <filters-columns
                                                @getData="getData"
                                                :columns="columns"
                                                :viewTableClasses="viewTableClasses"
                                                :tableData="tableData"
                                                :perPage="perPage"
                                            ></filters-columns>

                                            <!-- dataTables_buttons -->
                                            <div class="dataTables_buttons">
                                                <router-link
                                                    tag="button"
                                                    :to="{name: 'create-user'}"
                                                    type="button"
                                                    class="btn btn-outline-secondary"
                                                    v-if="this.$route.name == 'users'"
                                                >
                                                    {{ $t('global.create') }}
                                                    <i class="fa fa-plus fa-fw"></i>
                                                </router-link>
                                            </div>
                                            <!-- ./dataTables_buttons -->

                                        </div><!-- ./dataTables_header -->

                                    </div>
                                    <!-- /.card-header -->

                                    <div class="card-body table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table-wrapper
                                                    :successResponse="successResponse"
                                                    :dataTable="dataTable"
                                                    :columns="columns"
                                                    :columnsView="tableData.columns"
                                                    :columnsExcepted="tableData.filter.columnsExcept"
                                                    :viewtableclasses="tableData.filter.viewTable"
                                                    :sortKey="sortKey"
                                                    :sortOrders="sortOrders"
                                                    @sort="sortBy"
                                                >
                                                    <table-content
                                                        :dataTable="dataTable"
                                                        :tableData="tableData"
                                                        @destroyRow="destroyRow"
                                                        @restoreRow="restoreRow"
                                                        @forceDeleteRow="forceDeleteRow"
                                                    ></table-content>

                                                </table-wrapper>
                                            </div> <!-- ./ col-sm-12 -->
                                        </div> <!-- ./ row -->
                                    </div> <!-- /.card-body -->

                                    <!-- card-footer -->
                                    <div class="card-footer">
                                        <div class="row-pagination">
                                            <pagination
                                                :pagination="pagination"
                                                :totalLink="Math.ceil(pagination.total / tableData.length)"
                                                @prev="getData(pagination.prevPageUrl)"
                                                @next="getData(pagination.nextPageUrl)"
                                                @gotopage="gotopage"
                                            ></pagination>
                                        </div>
                                    </div> <!-- /.card-footer -->
                                </div> <!-- /.card -->
                            </div> <!-- /.datatables wrapper -->
                        </div><!-- /.col-12 -->
                    </div> <!-- /.row -->
                </div> <!-- /.dataTable -->
            </div><!--/. container-fluid -->
        </section>
    </div>
</template>



<script>
import Trashed from "./../../components/dataTables/filters/Trashed";
import CreatedBetween from "./../../components/dataTables/filters/CreatedBetween";
import Search from "./../../components/dataTables/filters/Search";
import TableContent from "./TableContent";

import MixinsDatatable from "./../../mixins/MixinsDatatable"

export default {
    mixins: [MixinsDatatable],
    components: {
        Trashed,
        CreatedBetween,
        Search,
        TableContent
    },
  data() {
    let self = this;
    let sortOrders = {};
    let columns = [
        { label: "<i class='fa fa-plus'></i>", name: "show_plus" },
        { label: "#", name: "index" },
        { label: "ID", name: "id" },
        { label: "Name", name: "name" },
        { label: "Email", name: "email" },
        { label: "Avatar", name: "image" },
        { label: "Registered", name: "created_at" },
        { label: "Actions", name: "actions" }
    ];
    columns.forEach(column => {
        sortOrders[column.name] = -1;
    });
    return {
        idPage: 'users',
        urlGetDataTable: '/users',

        columns: columns,
        sortOrders: sortOrders,

        tableData: {
            draw: 0,
            length: 10,
            search: "",
            column: 0,
            trashed: 1,
            from_date: "",
            to_date: "",
            dir: "",
            // columns of filter sorting [in select menu]
            columns: [
                "index",
                "id",
                "name",
                "email",
                "image",
                "created_at",
                "actions"
            ],
            filter: {
                // columns excepted sorting
                columnsExcept: ["index", "actions", "show_plus", 'image'],
                viewTable: ["bordered", 'hover']
            }
        },
      // viewFilterColumns
        viewColumnsResponsive: {
            default: {
                show: "all",// or ['id', 'index']
            },
            // 1200: {

            // },
            1000: {
                show: ['id', "name", "email", 'actions']
            },
            800: {
                show: ["name", "email", "actions"]
            },
            600: {
                show: ["name", "actions"]
            },
            400: {
                show: ["name"]
            }
        },
    };
  },
  methods: {

  },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            if (to.name == 'users') {
                to.meta.title = vm.$t('sidebar.users')
                vm.setLocaleMessages()
                vm.sortOrders[vm.sortKey] = 1; // 1 = desc , -1 = asc
                vm.sortBy(vm.sortKey);
                vm.eventBtnsClick();
                vm.viewFilterColumns();
                window.onresize = () => {
                    vm.viewFilterColumns();
                };
            }
        })
    },
    mounted() {
        if (this.$route.name != 'users') {
            this.setLocaleMessages()
            this.sortOrders[this.sortKey] = 1; // 1 = desc , -1 = asc
            this.sortBy(this.sortKey);
            this.eventBtnsClick();
            this.viewFilterColumns();
            window.onresize = () => {
                this.viewFilterColumns();
            };
        }
    },

};
</script>

