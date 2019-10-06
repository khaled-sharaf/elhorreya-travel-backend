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
        :totalLink="Math.ceil(pagination.total / tableData.length)"
        :filters="filters"
        :actionMultiDelete="actionMultiDelete"

        @prev="getData(pagination.prevPageUrl)"
        @next="getData(pagination.nextPageUrl)"
        @gotopage="gotopage"
        @toggleShowSettings="toggleShowSettings"
        @deleteResotreMulti="deleteResotreMulti"
        @getData="getData"
    >
        <template v-slot:filters>
            <travel-programs-select
                @getData="getData"
                :tableData="tableData"
                :travelPrograms="travelProgramsSelect"
            ></travel-programs-select>
        </template>


        <tbody>
            <tr
                role="row"
                v-for="(travel_category, index) in dataTable"
                :key="travel_category.id"
                :data-id="travel_category.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{travel_category.id}}
                </td>


                <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                    {{travel_category.name | capitalize }}
                </td>


                <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                    <img class="avatar-table" :src="$domain + '/' + travel_category.image">
                </td>


                <td v-show="tableData.columns.indexOf('order') != -1" class="order">
                    {{travel_category.order}}
                </td>


                <td v-show="tableData.columns.indexOf('travel_program_id') != -1" class="travel_program_id">
                    <router-link
                        class="link-router-in-table"
                        v-if="travel_category.travel_program !== null"
                        :href="$domain_admin + '/travel_program/' + travel_category.travel_program_id + '/edit'"
                        :to="{name: 'edit-travel_program', params: {id: travel_category.travel_program_id, travel_program: travel_category.travel_program}}"
                        data-name="edit-travel_program"
                        :data-params='"{\"travel_program\":" + JSON.stringify(travel_category.travel_program) + ", \"id\":" + travel_category.travel_program_id + "}"'
                    >
                        {{ travel_category.travel_program.name }}
                    </router-link>
                    <span class="badge badge-danger" v-else> {{ $t('global.travel_program_is_deleted') }} - id:{{travel_category.travel_program_id}}</span>
                </td>


                <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                    <created-by :model="travel_category"></created-by>
                </td>


                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="travel_category.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="travel_category.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                    <!-- btn edit row -->
                    <btn-edit :model="travel_category" modelName="travel_category"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="travel_category" modelName="travel_category" @destroyRow="destroyRow(travel_category.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="travel_category" modelName="travel_category" @restoreRow="restoreRow(travel_category.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="travel_category" modelName="travel_category" @forceDeleteRow="forceDeleteRow(travel_category.id)"></btn-force-delete>
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

import dataTable from './../../components/dataTables/Index'
import MixinsDatatable from "./../../mixins/MixinsDatatable"
import travelProgramsSelect from "./../../components/dataTables/filters/travelProgramsSelect"

export default {
    mixins: [MixinsDatatable],
    components: {
        travelProgramsSelect,
        dataTable,
        CreatedBy,
        BtnEdit,
        BtnDelete,
        BtnRestore,
        BtnForceDelete,
    },
  data() {
    return {
      idPage: 'travel_categories',
      routeCreate: 'create-travel_category',
      urlGetDataTable: '/travel_categories',
      urlGetTravelPrograms: '/travel_programs/select',
      travelProgramsSelect: [],
      filters: ['trashed', 'created-between', 'search'],
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
      columnsExceptedSorting: ['travel_program_id', 'user_id']
    };
  },
    methods: {
        setTableData() {
            this.tableData.travel_program_id = ''
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
