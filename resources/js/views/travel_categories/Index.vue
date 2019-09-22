<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('global.show') + ' ' + $t('sidebar.all_travel_categories')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="dataTable" id="travel_categories">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="dataTables_wrapper">
                                <div class="card">

                                    <!-- card-header -->
                                    <div class="card-header">

                                        <!-- dataTables_filters -->
                                        <div class="dataTables_filters">

                                            <travel-programs-select
                                                @getData="getData"
                                                :tableData="tableData"
                                                :travelPrograms="travelProgramsSelect"
                                            ></travel-programs-select>

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
                                                <router-link :to="{name: 'create-travel_category'}" tag="button"
                                                    type="button"
                                                    class="btn btn-outline-secondary"
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
import travelProgramsSelect from "./../../components/dataTables/filters/travelProgramsSelect";
import Search from "./../../components/dataTables/filters/Search";
import TableContent from "./TableContent";

import MixinsDatatable from "./../../mixins/MixinsDatatable"

export default {
    mixins: [MixinsDatatable],
    components: {
        Trashed,
        CreatedBetween,
        Search,
        TableContent,
        travelProgramsSelect
    },
  data() {
    return {
      idPage: 'travel_categories',
      urlGetDataTable: '/travel_categories',
      urlGetTravelPrograms: '/travel_programs/select',
      travelProgramsSelect: [],
      columns: [
        { label: "ID", name: "id" },
        { label: "Name", name: "name" },
        { label: "Image", name: "image" },
        { label: "Order", name: "order" },
        { label: "Travel program", name: "travel_program_id" },
        { label: "Created by", name: "user_id" },
        { label: "Updated at", name: "updated_at" },
        { label: "Created at", name: "created_at" }
      ],
      // viewFilterColumns
      viewColumnsResponsive: {
        default: {
          show: ['id', 'name', 'image', 'travel_program_id', 'updated_at', 'actions']
        },
        1000: {
          show: ['id', 'name', 'image', 'travel_program_id', 'updated_at', 'actions']
        },
        800: {
          show: ['id', 'name', 'travel_program_id', 'actions']
        },
        600: {
          show: ['name', 'travel_program_id', 'actions']
        },
        400: {
          show: ["name"]
        }
      },
    };
  },
    methods: {
        setTableData() {
            this.tableData.travel_program_id = ''
            this.tableData.filter.columnsExcept = ['show_plus', 'index', 'actions', 'travel_program_id', 'image', 'user_id']
        },
        getTravelProgramsSelect() {
            axios.get(this.urlGetTravelPrograms).then(response => {
                if (response.status === 200) {
                    if (typeof response.data === 'object') {
                        this.travelProgramsSelect = response.data.travel_programs
                    } else {
                        setTimeout(() => {
                            this.getTravelProgramsSelect()
                        }, 500)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelProgramsSelect()
                }, 500)
            });
        },
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.travel_categories')
            vm.setTableData()
            vm.$nextTick(() => {
                vm.getTravelProgramsSelect()
            })
        })
    },
};
</script>
<style scoped lang="scss">

</style>
