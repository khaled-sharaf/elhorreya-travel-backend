<template>
    <data-table
        :idPage="idPage"
        :showSettings="showSettings"
        :hideButtons="hideButtons"
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
            <travels-select
                v-if="$route.name == 'bookings'"
                :getData="getData"
                :tableData="tableData"
                :travels="travelsSelect"
            ></travels-select>
        </template>


        <tbody>
            <tr
                role="row"
                v-for="(booking, index) in dataTable"
                :key="booking.id"
                :data-id="booking.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{booking.id}}
                </td>


                <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                    {{booking.name}}
                </td>


                <td v-show="tableData.columns.indexOf('email') != -1" class="email">
                    <a :href="'mailto:' + booking.email">{{booking.email}}</a>
                </td>


                <td v-show="tableData.columns.indexOf('phone') != -1" class="phone">
                    {{booking.phone}}
                </td>


                <td v-show="tableData.columns.indexOf('message') != -1" class="message">
                    {{booking.message}}
                </td>

                <td v-show="tableData.columns.indexOf('adults') != -1" class="adults">
                    {{booking.adults}}
                </td>

                <td v-show="tableData.columns.indexOf('children') != -1" class="children">
                    {{booking.children}}
                </td>



                <td v-show="tableData.columns.indexOf('offer') != -1" class="offer">
                    <router-link
                        class="link-router-in-table"
                        :class="{'btn-goto-offer': $route.name === 'travel-profile'}"
                        v-if="booking.travel !== null"
                        :href="$domain_admin + '/travel/profile/' + booking.travel_id"
                        :to="{name: 'travel-profile', params: {id: booking.travel_id, travel: booking.travel, offer_id: booking.travel_detail_id}}"
                        data-name="travel-profile"
                        :data-params='`{"travel": ${JSON.stringify(booking.travel)}, "id": ${booking.travel_id}, "offer_id": ${booking.travel_detail_id}}`'
                    >
                        {{ booking.travel.name }}
                        <span class="badge badge-success" style="font-size: 12px !important">
                            رقم
                            {{ booking.offer.id }}
                        </span>
                    </router-link>
                    <span class="badge badge-danger" v-else> {{ $t('global.travel_is_deleted') }} - id:{{booking.travel_id}}</span>
                </td>


                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="booking.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="booking.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">

                    <!-- btn delete row -->
                    <btn-delete :model="booking" modelName="booking" @destroyRow="destroyRow(booking.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="booking" modelName="booking" @restoreRow="restoreRow(booking.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="booking" modelName="booking" @forceDeleteRow="forceDeleteRow(booking.id)"></btn-force-delete>
                    <!-- ./btn force delete row -->
                </td>

            </tr>
        </tbody>

    </data-table>

</template>



<script>
import BtnDelete from "./../../components/dataTables/buttons/DeleteRow"
import BtnRestore from "./../../components/dataTables/buttons/RestoreRow"
import BtnForceDelete from "./../../components/dataTables/buttons/ForceDeleteRow"

import dataTable from './../../components/dataTables/Index'
import MixinsDatatable from "./../../mixins/MixinsDatatable"

import travelsSelect from "./../../components/dataTables/filters/travelsSelect"

export default {
    components: {
        travelsSelect,
        dataTable,
        BtnDelete,
        BtnRestore,
        BtnForceDelete,
    },
    mixins: [MixinsDatatable],
    data() {
        return {
            idPage: 'bookings',
            urlGetDataTable: '/bookings',
            urlGetTravels: '/travels/select',
            travelsSelect: [],
            filters: ['trashed', 'created-between', 'search'],
            hideButtons: true,
            columns: [
                { label: "ID", name: "id" },
                { label: "name", name: "name" },
                { label: "email", name: "email" },
                { label: "phone", name: "phone" },
                { label: "message", name: "message" },
                { label: "adults", name: "adults" },
                { label: "children", name: "children" },
                { label: "Offer", name: "offer" },
                { label: "Updated at", name: "updated_at" },
                { label: "Created at", name: "created_at" }
            ],
            columnsExceptedSorting: ['offer', 'message']
        };
    },
    methods: {
        setTableData() {
            this.tableData.travel_id = ''
        },
        getTravelsSelect() {
            axios.get(this.urlGetTravels).then(response => {
                if (response.status === 200) {
                    if (typeof response.data === 'object') {
                        this.travelsSelect = response.data.travels
                    } else {
                        setTimeout(() => {
                            this.getTravelsSelect()
                        }, 500)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelsSelect()
                }, 500)
            });
        },
        addTravelIdToRequest() {
            const travel_id = this.$route.params.id;
            if (travel_id != null) {
                this.tableData.travel_id = travel_id
            }
            const getData = setInterval(() => {
                if (this.successResponse) {
                    clearInterval(getData)
                    setTimeout(() => {
                        this.tableData.columns = ['name', 'email', 'actions']
                    }, 200)
                }
            }, 200)
        },
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.bookings')
            vm.$nextTick(() => {
                vm.getTravelsSelect()
            })
        })
    },
    created() {
        this.setTableData()
        if (this.$route.name == 'travel-profile') {
            this.addTravelIdToRequest()
        }
    },
};
</script>

