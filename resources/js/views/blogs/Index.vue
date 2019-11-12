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
        <tbody>
            <tr
                role="row"
                v-for="(blog, index) in dataTable"
                :key="blog.id"
                :data-id="blog.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{blog.id}}
                </td>


                <td v-show="tableData.columns.indexOf('title') != -1" class="title">
                    {{blog.title | capitalize }}
                </td>


                <td v-show="tableData.columns.indexOf('content') != -1" class="content" v-html="blog.content.replace(/(?:\r\n|\r|\n)/g, '<br>')"></td>


                <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                    <img class="avatar-table" :src="$domain + '/' + blog.image">
                </td>


                <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                    <show-display :model="blog"></show-display>
                </td>


                <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                    <created-by :model="blog"></created-by>
                </td>

                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="blog.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="blog.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                    <!-- btn edit row -->
                    <btn-edit :model="blog" modelName="blog"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="blog" modelName="blog" @destroyRow="destroyRow(blog.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="blog" modelName="blog" @restoreRow="restoreRow(blog.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="blog" modelName="blog" @forceDeleteRow="forceDeleteRow(blog.id)"></btn-force-delete>
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
import showDisplay from "./../../components/dataTables/tableContent/showDisplay"

import dataTable from "./../../components/dataTables/Index"
import MixinsDatatable from "./../../mixins/MixinsDatatable"

export default {
    mixins: [MixinsDatatable],
    components: {
        dataTable,
        CreatedBy,
        showDisplay,
        BtnEdit,
        BtnDelete,
        BtnRestore,
        BtnForceDelete,
    },
  data() {
    return {
      idPage: 'blogs',
      routeCreate: 'create-blog',
      urlGetDataTable: '/blogs',
      filters: ['display', 'trashed', 'created-between', 'search'],
      columns: [
        { label: "ID", name: "id" },
        { label: "Title", name: "title" },
        { label: "Content", name: "content" },
        { label: "Image", name: "image" },
        { label: "Display", name: "display" },
        { label: "Created by", name: "user_id" },
        { label: "Updated at", name: "updated_at" },
        { label: "Created at", name: "created_at" }
      ],
      columnsExceptedSorting: ['content', 'user_id']
    };
  },
    methods: {

    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.blogs')
        })
    },
};
</script>
