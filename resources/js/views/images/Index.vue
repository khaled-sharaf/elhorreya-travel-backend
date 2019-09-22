<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('global.show') + ' ' + $t('sidebar.all_images')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="dataTable" id="images">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="dataTables_wrapper">
                                <div class="card">

                                    <!-- card-header -->
                                    <div class="card-header">

                                        <!-- dataTables_filters -->
                                        <div class="dataTables_filters">

                                            <travel-categories-select
                                                @getData="getData"
                                                :tableData="tableData"
                                                :travelCategories="travelCategoriesSelect"
                                            ></travel-categories-select>

                                            <trashed
                                                @getData="getData"
                                                :tableData="tableData"
                                            ></trashed>

                                            <display
                                                @getData="getData"
                                                :tableData="tableData"
                                            ></display>

                                            <created-between
                                                @getData="getData"
                                                :tableData="tableData"
                                            ></created-between>

                                        </div><!-- ./dataTables_filters -->

                                        <!-- dataTables_header -->
                                        <div class="dataTables_header">

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
                                                <router-link :to="{name: 'create-image'}" tag="button"
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
import Display from "./../../components/dataTables/filters/Display";
import CreatedBetween from "./../../components/dataTables/filters/CreatedBetween";
import TravelCategoriesSelect from "./../../components/dataTables/filters/travelCategoriesSelect";
import TableContent from "./TableContent";

import MixinsDatatable from "./../../mixins/MixinsDatatable"

export default {
    mixins: [MixinsDatatable],
        components: {
        Trashed,
        Display,
        CreatedBetween,
        TravelCategoriesSelect,
        TableContent
    },
  data() {
    return {
        idPage: 'images',
        urlGetDataTable: '/images',
        urlGetTravelCategories: '/travel_categories/select',
        travelCategoriesSelect: [],
        columns: [
            { label: "ID", name: "id" },
            { label: "Image", name: "name" },
            { label: "Travel Category", name: "travel_category_id" },
            { label: "Display", name: "display" },
            { label: "Created by", name: "user_id" },
            { label: "Updated at", name: "updated_at" },
            { label: "Created at", name: "created_at" },
        ],
      // viewFilterColumns
      viewColumnsResponsive: {
        default: {
            show: 'all'
        //   show: ['id', 'name', 'travel_category_id', 'display', 'updated_at', 'actions']
        },
        1000: {
          show: ['name', 'travel_category_id', 'updated_at', 'actions']
        },
        800: {
          show: ['name', 'travel_category_id', 'actions']
        },
        600: {
          show: ['name', 'actions']
        },
        400: {
          show: ['name']
        }
      },
    };
  },
    methods: {
        setTableData() {
            this.tableData.travel_category_id = ''
            this.tableData.filter.columnsExcept = ['show_plus', 'index', 'actions', 'name', 'travel_category_id', 'user_id']
        },
        getTravelCategoriesSelect() {
            axios.get(this.urlGetTravelCategories).then(response => {
                if (response.status === 200) {
                    if (typeof response.data === 'object') {
                        this.travelCategoriesSelect = response.data.travel_categories
                    } else {
                        setTimeout(() => {
                            this.getTravelCategoriesSelect()
                        }, 500)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelCategoriesSelect()
                }, 500)
            });
        },
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.images')
            vm.setTableData()
            vm.$nextTick(() => {
                vm.getTravelCategoriesSelect()
            })
        })
    },
};
</script>
<style scoped lang="scss">

</style>
