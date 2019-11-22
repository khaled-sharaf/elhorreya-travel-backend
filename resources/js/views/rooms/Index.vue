<template>
    <data-table
        :routeCreate="routeCreate"
        :idPage="idPage"
        :showSettings="showSettings"
        :columns="columns"
        :themeTableClasses="viewTableClasses"
        :dataTable="dataTable"
        :tableData="tableData"
        :perPage="perPage"
        :successResponse="successResponse"
        :columnsView="tableData.columns"
        :columnsExcepted="tableData.filter.columnsExcept"
        :themeTableClassesFilter="tableData.filter.viewTable"
        :sortOrders="sortOrders"
        :pagination="pagination"
        :filters="filters"

        :toggleShowSettings="toggleShowSettings"
        :deleteResotreMulti="deleteResotreMulti"
        :getData="getData"
    >

        <template v-slot:filters>
            <hotels-select
                v-if="$route.name == 'rooms'"
                :getData="getData"
                :tableData="tableData"
                :hotels="hotelsSelect"
            ></hotels-select>
        </template>

        <tbody>
            <tr
                role="row"
                v-for="(room, index) in dataTable"
                :key="room.id"
                :data-id="room.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{room.id}}
                </td>


                <td v-show="tableData.columns.indexOf('info') != -1" class="info">
                    {{room.info}}
                </td>


                <td v-show="tableData.columns.indexOf('options') != -1" class="options">
                    {{room.options}}
                </td>


                <!-- <td v-show="tableData.columns.indexOf('price_night') != -1" class="price_night">
                    {{room.price_night}}
                </td> -->


                <!-- <td v-show="tableData.columns.indexOf('offer') != -1" class="offer">
                    <span v-if="(room.offer_price != null && room.offer_price != 0) && (room.offer_days != null && room.offer_days != 0)">
                        <span class="badge badge-danger" v-text="room.offer_price"></span>
                        {{ $t('global.in') }}
                        <span class="badge badge-danger" v-text="room.offer_days"></span>
                        <span v-if="room.offer_days >= 2">
                            {{ $t('rooms_table.nights') }}
                        </span>
                        <span v-else>
                            {{ $t('rooms_table.night') }}
                        </span>
                    </span>
                    <span v-else>ــــ</span>
                </td> -->

                <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                    <show-display :model="room"></show-display>
                </td>



                <td v-show="tableData.columns.indexOf('hotel_id') != -1" class="hotel_id">
                    <router-link
                        class="link-router-in-table"
                        v-if="room.hotel !== null"
                        :href="$domain_admin + '/hotel/profile/' + room.hotel_id"
                        :to="{name: 'hotel-profile', params: {id: room.hotel_id, hotel: room.hotel}}"
                        data-name="hotel-profile"
                        :data-params='"{\"hotel\":" + JSON.stringify(room.hotel) + ", \"id\":" + room.hotel_id + "}"'
                    >
                        {{ room.hotel.name }}
                    </router-link>
                    <span class="badge badge-danger" v-else> {{ $t('global.hotel_is_deleted') }} - id:{{room.hotel_id}}</span>
                </td>


                <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                    <created-by :model="room"></created-by>
                </td>


                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="room.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="room.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">

                    <!-- btn edit row -->
                    <btn-edit :model="room" modelName="room"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="room" modelName="room" @destroyRow="destroyRow(room.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="room" modelName="room" @restoreRow="restoreRow(room.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="room" modelName="room" @forceDeleteRow="forceDeleteRow(room.id)"></btn-force-delete>
                    <!-- ./btn force delete row -->
                </td>

            </tr>
        </tbody>

    </data-table>

</template>



<script>
import CreatedBy from "./../../components/dataTables/buttons/CreatedBy"
import BtnEdit from "./../../components/dataTables/buttons/EditRow"
import BtnDelete from "./../../components/dataTables/buttons/DeleteRow"
import BtnRestore from "./../../components/dataTables/buttons/RestoreRow"
import BtnForceDelete from "./../../components/dataTables/buttons/ForceDeleteRow"
import showDisplay from "./../../components/dataTables/tableContent/showDisplay"

import dataTable from './../../components/dataTables/Index'
import MixinsDatatable from "./../../mixins/MixinsDatatable"

import hotelsSelect from "./../../components/dataTables/filters/hotelsSelect"

export default {
    components: {
        hotelsSelect,
        dataTable,
        CreatedBy,
        showDisplay,
        BtnEdit,
        BtnDelete,
        BtnRestore,
        BtnForceDelete,
    },
    mixins: [MixinsDatatable],
    data() {
        return {
            idPage: 'rooms',
            routeCreate: 'create-room',
            urlGetDataTable: '/rooms',
            urlGetHotels: '/hotels/select',
            hotelsSelect: [],
            filters: ['display', 'trashed', 'created-between', 'search'],
            columns: [
                { label: "ID", name: "id" },
                { label: "Info", name: "info" },
                { label: "Options", name: "options" },
                // { label: "Price night", name: "price_night" },
                // { label: "Offer", name: "offer" },
                { label: "Display", name: "display" },
                { label: "Hotel", name: "hotel_id" },
                { label: "Created by", name: "user_id" },
                { label: "Updated at", name: "updated_at" },
                { label: "Created at", name: "created_at" }
            ],
            columnsExceptedSorting: ['offer', 'user_id', 'hotel_id']
        };
    },
    methods: {
        setTableData() {
            this.tableData.hotel_id = ''
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
            const getData = setInterval(() => {
                if (this.successResponse) {
                    clearInterval(getData)
                    setTimeout(() => {
                        this.tableData.columns = ['info', 'options', 'price_night']
                    }, 200)
                }
            }, 200)
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

