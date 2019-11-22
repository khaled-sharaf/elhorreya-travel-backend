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

        <template v-slot:filters></template>

        <template v-slot:buttons></template>

        <template v-slot:after-container>
            <!-- modal location hotel -->

            <modal-location></modal-location>

            <!-- ./modal location hotel -->
        </template>

        <tbody>
            <tr
                role="row"
                v-for="(hotel, index) in dataTable"
                :key="hotel.id"
                :data-id="hotel.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{hotel.id}}
                </td>


                <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                    {{hotel.name | capitalize }}
                </td>


                <td v-show="tableData.columns.indexOf('address') != -1" class="address">
                    {{hotel.address}}
                </td>


                <!-- <td v-show="tableData.columns.indexOf('rating') != -1" class="rating">
                    <rates-stars :rates-count="hotel.rating">
                        <div class="text-center" style="font-size: 11px;">{{ hotel.rating }} %</div>
                    </rates-stars>
                </td> -->


                <td v-show="tableData.columns.indexOf('stars') != -1" class="stars">
                    {{hotel.stars}}
                </td>


                <td v-show="tableData.columns.indexOf('info') != -1" class="info">
                    <div class="view-text-editor" v-html="hotel.info"></div>
                </td>

                <td v-show="tableData.columns.indexOf('location') != -1" class="location">
                    <button
                        v-if="hotel.longitude != null && hotel.latitude != null"
                        class="btn btn-outline-secondary btn-sm"
                        id="show_map_location"
                        :data-long="hotel.longitude"
                        :data-lat="hotel.latitude"
                        :data-location-title="hotel.name"
                        v-text="$t('global.show_map')"
                        >
                    </button>
                    <span v-else>{{ $t('global.no_location') }}</span>
                </td>


                <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                    <img class="avatar-table" :src="$domain + '/' + hotel.image">
                </td>


                <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                    <show-display :model="hotel"></show-display>
                </td>


                <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                    <created-by :model="hotel"></created-by>
                </td>

                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="hotel.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="hotel.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">

                    <!-- show hotel profile -->
                    <btn-view-profile :model="hotel" modelName="hotel"></btn-view-profile>
                    <!-- ./show hotel profile -->

                    <!-- btn edit row -->
                    <btn-edit :model="hotel" modelName="hotel"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="hotel" modelName="hotel" @destroyRow="destroyRow(hotel.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="hotel" modelName="hotel" @restoreRow="restoreRow(hotel.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="hotel" modelName="hotel" @forceDeleteRow="forceDeleteRow(hotel.id)"></btn-force-delete>
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
import ModalLocation from "./ModalLocation"

export default {
    mixins: [MixinsDatatable],
    components: {
        ModalLocation,
        dataTable,
        CreatedBy,
        showDisplay,
        BtnViewProfile,
        BtnEdit,
        BtnDelete,
        BtnRestore,
        BtnForceDelete,
    },
    data() {
        return {
            idPage: 'hotels',
            urlGetDataTable: '/hotels',
            routeCreate: 'create-hotel',
            filters: ['display', 'trashed', 'created-between', 'search'],
            columns: [
                { label: "ID", name: "id" },
                { label: "Name", name: "name" },
                { label: "Address", name: "address" },
                // { label: "Rating", name: "rating" },
                { label: "Stars", name: "stars" },
                { label: "Info", name: "info" },
                { label: "Location", name: "location" },
                { label: "Image", name: "image" },
                { label: "Display", name: "display" },
                { label: "Created by", name: "user_id" },
                { label: "Updated at", name: "updated_at" },
                { label: "Created at", name: "created_at" }
            ],
            columnsExceptedSorting: ['location', 'user_id']
        };
    },
    methods: {
        showMap(lat, long) {
            if (lat != null && long != null) {
                const my_map_modal = $('#my_map_modal');
                my_map_modal.attr('data-lat', lat).attr('data-long', long);
                let scriptMap = document.createElement('script');
                const idMap = 'myScriptMap';
                document.body.appendChild(scriptMap);
                scriptMap.id = idMap;
                scriptMap.setAttribute('async', true);
                scriptMap.setAttribute('defer', true);
                scriptMap.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyADsFcbM6g-A_nUwh41pFn9EgDdlRC6lGY&language=ar&region=EG&callback=initMap');
            }
        },
        eventBtnsClickLocale() {
            let self = this;
            // show location in google map
            $(document).on("click", "#show_map_location", function(e) {
                e.preventDefault();
                let lat = $(this).attr('data-lat'),
                    long = $(this).attr('data-long'),
                    title = $(this).attr('data-location-title');
                if ( (typeof lat != 'undefined' && lat != '' && lat != null) &&
                    (typeof long != 'undefined' && long != '' && long != null) ) {
                    $('#locationTitle').html('Location: ' + title);
                    $('#myScriptMap').remove();
                    self.showMap(lat, long);
                    $('#modal_location_hotel').modal('show');
                }
            });
        },
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.hotels')
            vm.eventBtnsClickLocale()
        })
    },
};
</script>
