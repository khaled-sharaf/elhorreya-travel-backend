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

        <tbody>
            <tr
                role="row"
                v-for="(travel_program, index) in dataTable"
                :key="travel_program.id"
                :data-id="travel_program.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >

                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{travel_program.id}}
                </td>


                <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                    {{travel_program.name | capitalize }}
                </td>


                <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                    <img class="avatar-table" :src="$domain + '/' + travel_program.image">
                </td>


                <td v-show="tableData.columns.indexOf('small_info') != -1" class="small_info">
                    {{travel_program.small_info}}
                </td>


                <td v-show="tableData.columns.indexOf('big_info') != -1" class="big_info">
                    {{travel_program.big_info}}
                </td>


                <td v-show="tableData.columns.indexOf('order') != -1" class="order">
                    {{travel_program.order}}
                </td>


                <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                    <created-by :model="travel_program"></created-by>
                </td>

                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="travel_program.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="travel_program.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                    <!-- btn edit row -->
                    <btn-edit :model="travel_program" modelName="travel_program"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="travel_program" modelName="travel_program" @destroyRow="destroyRow(travel_program.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="travel_program" modelName="travel_program" @restoreRow="restoreRow(travel_program.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="travel_program" modelName="travel_program" @forceDeleteRow="forceDeleteRow(travel_program.id)"></btn-force-delete>
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

import dataTable from "./../../components/dataTables/Index"
import MixinsDatatable from "./../../mixins/MixinsDatatable"

export default {
    mixins: [MixinsDatatable],
    components: {
        dataTable,
        CreatedBy,
        BtnEdit,
        BtnDelete,
        BtnRestore,
        BtnForceDelete,
    },
  data() {
    return {
      idPage: 'travel_programs',
      urlGetDataTable: '/travel_programs',
      routeCreate: 'create-travel_program',
      filters: ['trashed', 'created-between', 'search'],
      columns: [
        { label: "ID", name: "id" },
        { label: "Name", name: "name" },
        { label: "Image", name: "image" },
        { label: "Small info", name: "small_info" },
        { label: "Big info", name: "big_info" },
        { label: "Order", name: "order" },
        { label: "Created by", name: "user_id" },
        { label: "Updated at", name: "updated_at" },
        { label: "Created at", name: "created_at" }
      ],
      columnsExceptedSorting: ['small_info', 'big_info', 'user_id']
    };
  },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.travel_programs')
        })
    },
};
</script>
