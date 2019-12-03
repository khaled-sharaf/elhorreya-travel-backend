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

        <template v-slot:after-container>
            <!-- modal location hotel -->

            <modal-location></modal-location>

            <!-- ./modal location hotel -->
        </template>

        <tbody>
            <tr
                role="row"
                v-for="(contact_info, index) in dataTable"
                :key="contact_info.id"
                :data-id="contact_info.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{contact_info.id}}
                </td>


                <td v-show="tableData.columns.indexOf('branch_name') != -1" class="branch_name">
                    {{contact_info.branch_name}}
                </td>


                <td v-show="tableData.columns.indexOf('phone_1') != -1" class="phone_1">
                    {{contact_info.phone_1}}
                </td>


                <td v-show="tableData.columns.indexOf('phone_2') != -1" class="phone_2">
                    {{contact_info.phone_2}}
                </td>


                <td v-show="tableData.columns.indexOf('phone_3') != -1" class="phone_3">
                    {{contact_info.phone_3}}
                </td>


                <td v-show="tableData.columns.indexOf('phone_4') != -1" class="phone_4">
                    {{contact_info.phone_4}}
                </td>


                <td v-show="tableData.columns.indexOf('address') != -1" class="address">
                    {{contact_info.address}}
                </td>


                <td v-show="tableData.columns.indexOf('email') != -1" class="email">
                    {{contact_info.email}}
                </td>


                <td v-show="tableData.columns.indexOf('location') != -1" class="location">
                    <button
                        v-if="contact_info.longitude != null && contact_info.latitude != null"
                        class="btn btn-outline-secondary btn-sm"
                        id="show_map_location"
                        :data-long="contact_info.longitude"
                        :data-lat="contact_info.latitude"
                        :data-location-title="contact_info.branch_name"
                        v-text="$t('global.show_map')"
                        >
                    </button>
                    <span v-else>{{ $t('global.no_location') }}</span>
                </td>


                <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                    <show-display :model="contact_info"></show-display>
                </td>


                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="contact_info.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="contact_info.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">

                    <!-- btn edit row -->
                    <btn-edit :model="contact_info" modelName="contact_info"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="contact_info" modelName="contact_info" @destroyRow="destroyRow(contact_info.id)"></btn-delete>
                    <!-- ./btn delete row -->
                </td>

            </tr>
        </tbody>

    </data-table>

</template>



<script>
import BtnEdit from "./../../components/dataTables/buttons/EditRow"
import BtnDelete from "./../../components/dataTables/buttons/DeleteRow"
import showDisplay from "./../../components/dataTables/tableContent/showDisplay"
import dataTable from './../../components/dataTables/Index'
import MixinsDatatable from "./../../mixins/MixinsDatatable"
import ModalLocation from "./ModalLocation"

export default {
    components: {
        dataTable,
        showDisplay,
        BtnEdit,
        BtnDelete,
        ModalLocation,
    },
    mixins: [MixinsDatatable],
    data() {
        return {
            idPage: 'contact_infos',
            routeCreate: 'create-contact_info',
            urlGetDataTable: '/contact_infos',
            filters: ['display', 'search'],
            columns: [
                { label: "ID", name: "id" },
                { label: "Branch name", name: "branch_name" },
                { label: "phone_1", name: "phone_1" },
                { label: "phone_2", name: "phone_2" },
                { label: "phone_3", name: "phone_3" },
                { label: "phone_4", name: "phone_4" },
                { label: "address", name: "address" },
                { label: "email", name: "email" },
                { label: "location", name: "location" },
                { label: "Display", name: "display" },
                { label: "Updated at", name: "updated_at" },
                { label: "Created at", name: "created_at" }
            ],
            columnsExceptedSorting: ['location']
        };
    },
    methods: {
        setTableData() {

        },
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
                    $('#locationTitle').html('خريطة: ' + title);
                    $('#myScriptMap').remove();
                    self.showMap(lat, long);
                    $('#modal_location_hotel').modal('show');
                }
            });
        },
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.contact_infos')
            vm.eventBtnsClickLocale()
        })
    },
    created() {
        // this.setTableData()
    },
};
</script>

