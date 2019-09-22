<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page v-if="this.$route.name == 'rooms'" :title="$t('global.show') + ' ' + $t('sidebar.all_rooms')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">
                <div class="dataTable" id="rooms">
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="dataTables_wrapper">
                                <div class="card">

                                    <!-- card-header -->
                                    <div class="card-header">

                                        <!-- dataTables_filters -->
                                        <div class="dataTables_filters">

                                            <hotels-select
                                                v-if="$route.name == 'rooms'"
                                                @getData="getData"
                                                :tableData="tableData"
                                                :hotels="hotelsSelect"
                                            ></hotels-select>

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
                                                    :to="{name: 'create-room'}"
                                                    type="button"
                                                    class="btn btn-outline-secondary"
                                                    v-if="this.$route.name == 'rooms'"
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
import hotelsSelect from "./../../components/dataTables/filters/hotelsSelect";
import Search from "./../../components/dataTables/filters/Search";
import TableContent from "./TableContent";

import MixinsDatatable from "./../../mixins/MixinsDatatable"

export default {
    mixins: [MixinsDatatable],
    components: {
        Trashed,
        Display,
        CreatedBetween,
        hotelsSelect,
        Search,
        TableContent
    },
  data() {
    return {
        idPage: 'rooms',
        urlGetDataTable: '/rooms',
        urlGetHotels: '/hotels/select',
        hotelsSelect: [],
        columns: [
            { label: "ID", name: "id" },
            { label: "Info", name: "info" },
            { label: "Options", name: "options" },
            { label: "Price night", name: "price_night" },
            { label: "Offer", name: "offer" },
            { label: "Display", name: "display" },
            { label: "Hotel", name: "hotel_id" },
            { label: "Created by", name: "user_id" },
            { label: "Updated at", name: "updated_at" },
            { label: "Created at", name: "created_at" }
        ],
      // viewFilterColumns
        viewColumnsResponsive: {
            default: {
                hide: ['index', 'display', 'user_id', 'update_at', 'created_at']
            },
            // 1200: {

            // },
            1000: {
                show: ["id", "info", "options", "price_night", "actions"]
            },
            800: {
                show: ["info", "options", "price_night", "actions"]
            },
            600: {
                show: ["info", "actions"]
            },
            400: {
                show: ["info"]
            }
        },
    };
  },
  methods: {
    setTableData() {
        this.tableData.hotel_id = ''
        this.tableData.filter.columnsExcept = ["index", "actions", "show_plus", 'offer', 'user_id', 'hotel_id']
    },
    getHotelsSelect() {
        axios.get(this.urlGetHotels).then(response => {
            if (response.status === 200) {
                if (typeof response.data === 'object') {
                    this.hotelsSelect = response.data.hotels
                } else {
                    setTimeout(() => {
                        this.getHotelsSelect()
                    }, 500)
                }
            }
        })
        .catch(errors => {
            setTimeout(() => {
                this.getHotelsSelect()
            }, 500)
        });
    },
    addHotelIdToRequest() {
        const hotel_id = this.$route.params.id;
        if (hotel_id != null) {
            this.tableData.hotel_id = hotel_id
        }
        this.viewColumnsResponsive.default.show = ['info', 'options', 'price_night', 'actions']
    },
  },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.rooms')
            vm.$nextTick(() => {
                vm.getHotelsSelect()
            })
        })
    },
    created() {
        this.setTableData()
        if (this.$route.name == 'hotel-profile') {
            this.addHotelIdToRequest()
        }
    },

};
</script>

