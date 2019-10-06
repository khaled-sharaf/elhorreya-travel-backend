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
                v-for="(setting, index) in dataTable"
                :key="setting.id"
                :data-id="setting.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >

                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>

                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{setting.id}}
                </td>

                <td v-show="tableData.columns.indexOf('slug') != -1" class="slug">
                    {{setting.slug}}
                </td>

                <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                    {{setting.name}}
                </td>

                <td v-show="tableData.columns.indexOf('value') != -1" class="value">
                    <img class="avatar-table" v-if="setting.value.indexOf('images/settings/') === 0" :src="$domain + '/' + setting.value">

                    <span v-else>
                        {{setting.value}}
                    </span>
                </td>

                <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                    <created-by :model="setting"></created-by>
                </td>


                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="setting.updated_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="setting.created_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                    <!-- btn edit row -->
                    <btn-edit :model="setting" modelName="setting"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="setting" modelName="setting" @destroyRow="destroyRow(setting.id)"></btn-delete>
                    <!-- ./btn delete row -->
                </td>
            </tr>
        </tbody>
    </data-table>
</template>


<script>
import CreatedBy from "./../../components/dataTables/buttons/CreatedBy"
import BtnEdit from "./../../components/dataTables/buttons/EditRow"
import BtnDelete from "./../../components/dataTables/buttons/DeleteRow"

import dataTable from './../../components/dataTables/Index'
import MixinsDatatable from "./../../mixins/MixinsDatatable"

export default {
    mixins: [MixinsDatatable],
    components: {
        dataTable,
        CreatedBy,
        BtnEdit,
        BtnDelete,
    },
    data() {
        return {
            idPage: 'settings',
            urlGetDataTable: '/settings',
            routeCreate: 'create-setting',
            filters: ['search'],
            columns: [
                { label: "ID", name: "id" },
                { label: "Slug", name: "slug" },
                { label: "Name", name: "name" },
                { label: "Value", name: "value" },
                { label: "created by", name: "user_id" },
                { label: "Updated at", name: "updated_at" },
                { label: "Created at", name: "created_at" }
            ],
            columnsExceptedSorting: ['user_id', 'value']
        };
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.settings')
        })
    },
};
</script>
