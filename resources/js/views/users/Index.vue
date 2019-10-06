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
        @deleteResotreMulti="deleteResotreMulti(actionMultiDelete)"
        @getData="getData"
    >
        <tbody>
            <tr
                role="row"
                v-for="(user, index) in dataTable"
                :key="user.id"
                :data-id="user.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{user.id}}
                </td>


                <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                    {{user.name | capitalize }}
                </td>


                <td v-show="tableData.columns.indexOf('email') != -1" class="email">
                    <a :href="'mailto:' + user.email">{{user.email}}</a>
                </td>


                <td v-show="tableData.columns.indexOf('image') != -1" class="image">
                    <img class="avatar-table" :src="user.image.indexOf('http') === 0 ? user.image : $domain + '/' + user.image">
                </td>

                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="user.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="user.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                    <!-- btn edit row -->
                    <btn-edit :model="user" modelName="user"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="user" modelName="user" @destroyRow="destroyRow(user.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="user" modelName="user" @restoreRow="restoreRow(user.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="user" modelName="user" @forceDeleteRow="forceDeleteRow(user.id)"></btn-force-delete>
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
        idPage: 'users',
        routeCreate: 'create-user',
        urlGetDataTable: '/users',
        filters: ['trashed', 'created-between', 'search'],
        columns: [
            { label: "ID", name: "id" },
            { label: "Name", name: "name" },
            { label: "Email", name: "email" },
            { label: "Avatar", name: "image" },
            { label: "Updated at", name: "updated_at" },
            { label: "Registered", name: "created_at" }
        ],
        columnsExceptedSorting: []
    };
  },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.users')
        })
    }
};
</script>

