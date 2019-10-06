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
            <travel-categories-select
                @getData="getData"
                :tableData="tableData"
                :travelCategories="travelCategoriesSelect"
            ></travel-categories-select>
        </template>

        <tbody>
            <tr
                role="row"
                v-for="(image, index) in dataTable"
                :key="image.id"
                :data-id="image.id"
                class="tr-general"
                :class="index % 2 == 0 ? 'even' : 'odd'"
            >


                <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                    {{index + 1}}
                </td>


                <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                    {{image.id}}
                </td>


                <td v-show="tableData.columns.indexOf('name') != -1" class="name" style="text-align:center;">
                    <img class="avatar-table" :src="$domain + '/' + image.name">
                </td>


                <td v-show="tableData.columns.indexOf('travel_category_id') != -1" class="travel_category_id">
                    <router-link
                        class="link-router-in-table"
                        v-if="image.travel_category !== null"
                        :href="$domain_admin + '/travel_category/' + image.travel_category_id + '/edit'"
                        :to="{name: 'edit-travel_category', params: {id: image.travel_category_id, travel_category: image.travel_category}}"
                        data-name="edit-travel_category"
                        :data-params='"{\"travel_category\":" + JSON.stringify(image.travel_category) + ", \"id\":" + image.travel_category_id + "}"'
                    >
                        {{ image.travel_category.name }}
                    </router-link>
                    <span class="badge badge-danger" v-else> {{ $t('global.travel_category_is_deleted') }} - id:{{image.travel_category_id}}</span>
                </td>


                <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                    <show-display :model="image"></show-display>
                </td>


                <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                    <created-by :model="image"></created-by>
                </td>

                <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                    <relative-date :date="image.updated_at"></relative-date>
                </td>

                <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                    <relative-date :date="image.created_at"></relative-date>
                </td>


                <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                    <!-- btn edit row -->
                    <btn-edit :model="image" modelName="image"></btn-edit>
                    <!-- ./btn edit row -->

                    <!-- btn delete row -->
                    <btn-delete :model="image" modelName="image" @destroyRow="destroyRow(image.id)"></btn-delete>
                    <!-- ./btn delete row -->

                    <!-- btn restore row -->
                    <btn-restore :model="image" modelName="image" @restoreRow="restoreRow(image.id)"></btn-restore>
                    <!-- ./btn restore row -->

                    <!-- btn force delete row -->
                    <btn-force-delete :model="image" modelName="image" @forceDeleteRow="forceDeleteRow(image.id)"></btn-force-delete>
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

import TravelCategoriesSelect from "./../../components/dataTables/filters/travelCategoriesSelect"

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
        TravelCategoriesSelect,
    },
  data() {
    return {
        idPage: 'images',
        urlGetDataTable: '/images',
        routeCreate: 'create-image',
        urlGetTravelCategories: '/travel_categories/select',
        travelCategoriesSelect: [],
        filters: ['display', 'trashed', 'created-between', 'search'],
        columns: [
            { label: "ID", name: "id" },
            { label: "Image", name: "name" },
            { label: "Travel Category", name: "travel_category_id" },
            { label: "Display", name: "display" },
            { label: "Created by", name: "user_id" },
            { label: "Updated at", name: "updated_at" },
            { label: "Created at", name: "created_at" },
        ],
        columnsExceptedSorting: ['name', 'travel_category_id', 'user_id']
    };
  },
    methods: {
        setTableData() {
            this.tableData.travel_category_id = ''
        },
        getTravelCategoriesSelect() {
            axios.get(this.urlGetTravelCategories).then(response => {
                if (response.status === 200) {
                    if (typeof response.data === 'object') {
                        this.travelCategoriesSelect = response.data.travel_categories
                    } else {
                        setTimeout(() => {
                            this.getTravelCategoriesSelect()
                        }, 500)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelCategoriesSelect()
                }, 500)
            });
        },
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.images')
            vm.setTableData()
            vm.$nextTick(() => {
                vm.getTravelCategoriesSelect()
            })
        })
    },
};
</script>
