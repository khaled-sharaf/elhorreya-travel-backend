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
        <tbody>
            <tr
                role="row"
                v-for="(mail, index) in dataTable"
                :key="mail.id"
                :data-id="mail.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >

                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>

                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{mail.id}}
                </td>

                <td v-show="tableData.columns.indexOf('email') != -1" class="email">
                    <a :href="'mailto:' + mail.email">{{mail.email}}</a>
                </td>


                <td v-show="tableData.columns.indexOf('phone') != -1" class="phone">
                    {{mail.phone}}
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="mail.created_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                    <!-- btn delete row -->
                    <btn-delete :model="mail" modelName="mail" @destroyRow="destroyRow(mail.id)"></btn-delete>
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
            idPage: 'mailing_list',
            urlGetDataTable: '/mailing_list',
            filters: ['created-between', 'search'],
            hideButtons: true,
            columns: [
                { label: "ID", name: "id" },
                { label: "email", name: "email" },
                { label: "phone", name: "phone" },
                { label: "Created at", name: "created_at" }
            ],
            columnsExceptedSorting: []
        };
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.mailing_list')
        })
    },
};
</script>

