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
                v-if="$route.name == 'travels'"
                :getData="getData"
                :tableData="tableData"
                :hotels="hotelsSelect"
            ></hotels-select>

            <travel-categories-select
                :getData="getData"
                :tableData="tableData"
                :travelCategories="travelCategoriesSelect"
            ></travel-categories-select>

        </template>

        <tbody>
            <tr
                role="row"
                v-for="(travel, index) in dataTable"
                :key="travel.id"
                :data-id="travel.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{travel.id}}
                </td>


                <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                    {{travel.name | capitalize }}
                </td>


                <td v-show="tableData.columns.indexOf('address_from') != -1" class="address_from">
                    {{travel.address_from}}
                </td>


                <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                    <img class="avatar-table" :src="$domain + '/' + travel.image">
                </td>


                <td v-show="tableData.columns.indexOf('type') != -1" class="type">
                    {{ travelTypes[travel.type] }}
                </td>


                <td v-show="tableData.columns.indexOf('umrah_date') != -1" class="umrah_date">
                    {{travel.umrah_date}}
                </td>


                <td v-show="tableData.columns.indexOf('haram_distance') != -1" class="haram_distance">
                    {{ haramDistance[travel.haram_distance] }}
                </td>


                <td v-show="tableData.columns.indexOf('discount') != -1" class="discount">
                    <span v-if="travel.discount">{{travel.discount}}%</span>
                </td>


                <td v-show="tableData.columns.indexOf('favorite_company') != -1" class="favorite_company">
                    {{travel.favorite_company}}
                </td>


                <td v-show="tableData.columns.indexOf('hotel_id') != -1" class="hotel_id">
                    <router-link
                        class="link-router-in-table"
                        v-if="travel.hotel !== null"
                        :href="$domain_admin + '/hotel/profile/' + travel.hotel_id"
                        :to="{name: 'hotel-profile', params: {id: travel.hotel_id, hotel: travel.hotel}}"
                        data-name="hotel-profile"
                        :data-params='"{\"hotel\":" + JSON.stringify(travel.hotel) + ", \"id\":" + travel.hotel_id + "}"'
                    >
                        {{ travel.hotel.name + ' --- ' + travel.hotel.address }}
                    </router-link>
                    <span class="badge badge-danger" v-else> {{ $t('global.hotel_is_deleted') }} - id:{{travel.hotel_id}}</span>
                </td>


                <td v-show="tableData.columns.indexOf('hotel_2_id') != -1" class="hotel_2_id">
                    <span v-if="travel.hotel_2_id !== null">
                        <router-link
                            class="link-router-in-table"
                            v-if="travel.hotel_2 !== null"
                            :href="$domain_admin + '/hotel/profile/' + travel.hotel_2_id"
                            :to="{name: 'hotel-profile', params: {id: travel.hotel_2_id, hotel: travel.hotel_2}}"
                            data-name="hotel-profile"
                            :data-params='"{\"hotel\":" + JSON.stringify(travel.hotel_2) + ", \"id\":" + travel.hotel_2_id + "}"'
                        >
                            {{ travel.hotel_2.name + ' --- ' + travel.hotel_2.address }}
                        </router-link>
                        <span class="badge badge-danger" v-else> {{ $t('global.hotel_is_deleted') }} - id:{{travel.hotel_2_id}}</span>
                    </span>
                    <span class="badge badge-info" v-else> لا يوجد فندق ثانى</span>
                </td>


                <td v-show="tableData.columns.indexOf('travel_category_id') != -1" class="travel_category_id">
                    <span v-if="travel.type === 'external'">عروض الطيران</span>
                    <span v-else>
                        <router-link
                            class="link-router-in-table"
                            v-if="travel.travel_category !== null"
                            :href="$domain_admin + '/travel_category/' + travel.travel_category_id + '/edit'"
                            :to="{name: 'edit-travel_category', params: {id: travel.travel_category_id, travel_category: travel.travel_category}}"
                            data-name="edit-travel_category"
                            :data-params='"{\"travel_category\":" + JSON.stringify(travel.travel_category) + ", \"id\":" + travel.travel_category_id + "}"'
                        >
                            {{ travel.travel_category.name }}
                        </router-link>
                        <span class="badge badge-danger" v-else> {{ $t('global.travel_category_is_deleted') }} - id:{{travel.travel_category_id}}</span>
                    </span>
                </td>


                <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                    <show-display :model="travel"></show-display>
                </td>


                <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                    <created-by :model="travel"></created-by>
                </td>


                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="travel.updated_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="travel.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">

                    <!-- show travel profile -->
                    <btn-view-profile :model="travel" modelName="travel"></btn-view-profile>
                    <!-- ./show travel profile -->

                    <!-- btn edit row -->
                    <btn-edit :model="travel" modelName="travel"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="travel" modelName="travel" @destroyRow="destroyRow(travel.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="travel" modelName="travel" @restoreRow="restoreRow(travel.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="travel" modelName="travel" @forceDeleteRow="forceDeleteRow(travel.id)"></btn-force-delete>
                    <!-- ./btn force delete row -->

                </td>
            </tr>
        </tbody>
    </data-table>
</template>


<script>
import CreatedBy from "./../../components/dataTables/buttons/CreatedBy"
import BtnViewProfile from "./../../components/dataTables/buttons/ViewProfile"
import BtnEdit from "./../../components/dataTables/buttons/EditRow"
import BtnDelete from "./../../components/dataTables/buttons/DeleteRow"
import BtnRestore from "./../../components/dataTables/buttons/RestoreRow"
import BtnForceDelete from "./../../components/dataTables/buttons/ForceDeleteRow"
import showDisplay from "./../../components/dataTables/tableContent/showDisplay"

import dataTable from "./../../components/dataTables/Index"
import MixinsDatatable from "./../../mixins/MixinsDatatable"

import TravelCategoriesSelect from "./../../components/dataTables/filters/travelCategoriesSelect"
import hotelsSelect from "./../../components/dataTables/filters/hotelsSelect"

export default {
    mixins: [MixinsDatatable],
    components: {
        dataTable,
        CreatedBy,
        showDisplay,
        BtnViewProfile,
        BtnEdit,
        BtnDelete,
        BtnRestore,
        BtnForceDelete,
        TravelCategoriesSelect,
        hotelsSelect,
    },
    data() {
        return {
            idPage: 'travels',
            urlGetDataTable: '/travels',
            routeCreate: 'create-travel',
            urlGetHotels: '/hotels/select',
            hotelsSelect: [],
            urlGetTravelCategories: '/travel_categories/select',
            travelCategoriesSelect: [],
            filters: ['display', 'trashed', 'created-between', 'search'],
            columns: [
                { label: "ID", name: "id" },
                { label: "Name", name: "name" },
                { label: "Address from", name: "address_from" },
                { label: "Image", name: "image" },
                { label: "Type", name: "type" },
                { label: "Umrah date", name: "umrah_date" },
                { label: "Haram distance", name: "haram_distance" },
                { label: "discount", name: "discount" },
                { label: "Favorite company", name: "favorite_company" },
                { label: "Hotel", name: "hotel_id" },
                { label: "Hotel 2", name: "hotel_2_id" },
                { label: "Travel category", name: "travel_category_id" },
                { label: "Display", name: "display" },
                { label: "Created by", name: "user_id" },
                { label: "Updated at", name: "updated_at" },
                { label: "Created at", name: "created_at" }
            ],
            columnsExceptedSorting: ['hotel_id', 'travel_category_id', 'user_id'],
            travelTypes: {
                internal: 'سياحة داخلية',
                external: 'عروض الطيران',
                pilgrimage: 'حج',
                umrah: 'عمرة',
            },
            haramDistance: {
                0: 'بعيد',
                1: 'قريب',
            }
        };
    },
    methods: {
        setTableData() {
            this.tableData.hotel_id = ''
            this.tableData.travel_category_id = ''
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
                        this.tableData.columns = ['name', 'address_from', 'type', 'travel_category_id']
                    }, 200)
                }
            }, 200)
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
            to.meta.title = vm.$t('sidebar.travels')
            vm.$nextTick(() => {
                vm.getHotelsSelect()
                vm.getTravelCategoriesSelect()
            })
        })
    },

    created() {
        this.setTableData()
        if (this.$route.name == 'hotel-profile') {
            this.addHotelIdToRequest()
            this.getTravelCategoriesSelect()
        }
    },
};
</script>
