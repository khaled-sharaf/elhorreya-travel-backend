<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page v-if="this.$route.name == idPage" :title="$t('global.show') + ' ' + $t('sidebar.all_' + idPage)"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="dataTable" :id="idPage">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="dataTables_wrapper">
                                <div class="card">

                                    <!-- card-header -->
                                    <div class="card-header">

                                        <table-settings
                                            :toggleShowSettings="toggleShowSettings"
                                            :showSettings="showSettings"
                                            :idPage="idPage"
                                            :columns="columns"
                                            v-if="$route.name == idPage"
                                        ></table-settings>

                                        <!-- dataTables_filters -->
                                        <div class="dataTables_filters">

                                            <slot name="filters"></slot>


                                            <activation
                                                v-if="filters.indexOf('activation') != -1"
                                                :getData="getData"
                                                :tableData="tableData"
                                            ></activation>

                                            <trashed
                                                v-if="filters.indexOf('trashed') != -1"
                                                :getData="getData"
                                                :tableData="tableData"
                                            ></trashed>

                                            <display
                                                v-if="filters.indexOf('display') != -1"
                                                :getData="getData"
                                                :tableData="tableData"
                                            ></display>

                                            <created-between
                                                v-if="filters.indexOf('created-between') != -1"
                                                :getData="getData"
                                                :tableData="tableData"
                                            ></created-between>

                                        </div><!-- ./dataTables_filters -->

                                        <!-- dataTables_header -->
                                        <div class="dataTables_header">

                                            <!-- Search -->
                                            <search
                                                v-if="filters.indexOf('search') != -1"
                                                :getData="getData"
                                                :tableData="tableData"
                                            ></search>

                                            <!-- Filter columns -->
                                            <filters-columns
                                                :getData="getData"
                                                :deleteResotreMulti="deleteResotreMulti"
                                                :columns="columns"
                                                :themeTableClasses="themeTableClasses"
                                                :tableData="tableData"
                                                :perPage="perPage"
                                            ></filters-columns>

                                            <!-- dataTables_buttons -->
                                            <div class="dataTables_buttons">
                                                <slot name="buttons"></slot>
                                                <div v-if="!hideButtons">
                                                    <router-link
                                                        tag="button"
                                                        :to="{name: routeCreate}"
                                                        type="button"
                                                        class="btn btn-outline-secondary"
                                                        v-if="this.$route.name == idPage"
                                                    >
                                                        {{ $t('global.create') }}
                                                        <i class="fa fa-plus fa-fw"></i>
                                                    </router-link>
                                                </div>
                                            </div>
                                            <!-- ./dataTables_buttons -->

                                        </div><!-- ./dataTables_header -->

                                    </div>
                                    <!-- /.card-header -->


                                    <!-- card-body -->
                                    <div class="card-body table-responsive">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table-wrapper
                                                    :successResponse="successResponse"
                                                    :dataTable="dataTable"
                                                    :columns="columns"
                                                    :columnsView="columnsView"
                                                    :columnsExcepted="columnsExcepted"
                                                    :themeTableClassesFilter="themeTableClassesFilter"
                                                    :sortOrders="sortOrders"
                                                    :tableData="tableData"
                                                    :getData="getData"
                                                >
                                                    <slot></slot>
                                                </table-wrapper>
                                            </div> <!-- ./ col-sm-12 -->
                                        </div> <!-- ./ row -->
                                    </div> <!-- /.card-body -->

                                    <!-- card-footer -->
                                    <div class="card-footer">
                                        <div class="row-pagination">
                                            <pagination
                                                :pagination="pagination"
                                                :getData="getData"
                                            ></pagination>
                                        </div>
                                    </div> <!-- /.card-footer -->


                                </div> <!-- /.card -->
                            </div> <!-- /.datatables wrapper -->
                        </div><!-- /.col-12 -->
                    </div> <!-- /.row -->
                </div> <!-- /.dataTable -->
            </div><!--/. container-fluid -->

            <slot name="after-container"></slot>
        </section>
    </div>
</template>



<script>
// global components
import TableWrapper from "./TableWrapper";
import HeaderPage from './../HeaderPage'
import FiltersColumns from "./filters/FiltersColumns";
import Pagination from "./Pagination";
import TableSettings from "./TableSettings"

// filters
import Activation from "./filters/Activation"
import Trashed from "./filters/Trashed"
import Display from "./filters/Display"
import CreatedBetween from "./filters/CreatedBetween"
import Search from "./filters/Search"


export default {
    props: [
        'idPage',
        'routeCreate',
        'showSettings',
        'hideButtons',
        'columns',
        'themeTableClasses',
        'dataTable',
        'tableData',
        'perPage',
        'successResponse',
        'columnsView',
        'columnsExcepted',
        'themeTableClassesFilter',
        'sortOrders',
        'pagination',
        'filters',

        // functions
        'toggleShowSettings',
        'deleteResotreMulti',
        'getData'
    ],
    components: {
        // global
        TableWrapper,
        HeaderPage,
        FiltersColumns,
        Pagination,
        TableSettings,

        // filters
        Activation,
        Trashed,
        Display,
        CreatedBetween,
        Search,
    },
    methods: {
    },
}
</script>
