<template>
    <data-table
        :idPage="idPage"
        :showSettings="showSettings"
        :hideButtons="true"
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
        <tbody>
            <tr
                role="row"
                v-for="(model, index) in dataTable"
                :key="model.id"
                :data-id="model.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >

                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>

                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{model.id}}
                </td>

                <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                    {{ model.name }}
                </td>

                <td v-show="tableData.columns.indexOf('email') != -1" class="email">
                    <a :href="'mailto:' + model.email">{{model.email}}</a>
                </td>

                <td v-show="tableData.columns.indexOf('phone') != -1" class="phone">
                    {{ model.phone }}
                </td>

                <td v-show="tableData.columns.indexOf('message') != -1" class="message">
                    {{ model.message }}
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="model.created_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                    <!-- btn delete row -->
                    <btn-delete :model="model" modelName="contact_us" @destroyRow="destroyRow(model.id)"></btn-delete>
                    <!-- ./btn delete row -->
                </td>

            </tr>
        </tbody>
    </data-table>
</template>



<script>
import BtnDelete from "./../../components/dataTables/buttons/DeleteRow"
import dataTable from './../../components/dataTables/Index'
import MixinsDatatable from "./../../mixins/MixinsDatatable"

export default {
    components: {
        dataTable,
        BtnDelete
    },
    mixins: [MixinsDatatable],
    data() {
        return {
            idPage: 'contact_us',
            urlGetDataTable: '/contact_us',
            filters: ['created-between', 'search'],
            columns: [
                { label: "ID", name: "id" },
                { label: "name", name: "name" },
                { label: "email", name: "email" },
                { label: "phone", name: "phone" },
                { label: "message", name: "message" },
                { label: "Created at", name: "created_at" }
            ],
            columnsExceptedSorting: []
        };
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.contact_us')
        })
    },
};
</script>

