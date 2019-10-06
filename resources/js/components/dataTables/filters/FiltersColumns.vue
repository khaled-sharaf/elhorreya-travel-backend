<template>
    <div class="dataTables_filter">

        <!-- dataTables_buttons_action -->
        <label class="dataTables_buttons_action no-selected">

            <button
                v-if="tableData.trashed != 0"
                class="btn btn-danger btn-sm btn-delete-all"
                @click.prevent="deleteMulti('delete')"
                >
                <i class="fa fa-trash"></i>
            </button>


            <button
                v-if="tableData.trashed != 1"
                class="btn btn-info btn-sm btn-restore-all"
                @click.prevent="deleteMulti('restore')"
                >
                <i class="fas fa-undo-alt"></i>
            </button>


            <button
                v-if="tableData.trashed == 0"
                class="btn btn-danger btn-sm btn-force-delete-all"
                @click.prevent="deleteMulti('force_delete')"
                >
                {{ $t('global.force_delete') }}
                <i class="far fa-trash-alt"></i>
            </button>
        </label>

        <!-- dataTables_length -->
        <label class="dataTables_length">
            <select class="custom-select" v-model="tableData.length" @change="$emit('getData')">
                <option
                    v-for="(records, index) in perPage"
                    :key="index"
                    :value="records"
                >{{records}}</option>
            </select>
        </label>
        <!-- ./dataTables_length -->

        <!-- dataTables_columns -->
        <label class="dataTables_columns custom-select" v-selectcolumnopen>
            <select
                class="custom-select view-columns-filter"
                v-model="tableData.columns"
                v-selectcolumn="tableData.columns"
                multiple="multiple"
            >
                <option
                    v-for="(column, index) in updatedColumns"
                    :key="index"
                    :value="column.name"
                    v-html="column.label"
                ></option>
            </select>
            <span class="icon">
                <i class="fas fa-eye"></i>
            </span>
        </label>
        <!-- ./dataTables_columns -->

        <!-- dataTables_viewtable -->
        <label class="dataTables_viewtable custom-select" v-selectcolumnopen>
            <select
                class="custom-select view-table-filter"
                v-model="tableData.filter.viewTable"
                v-selectviewtableclass="tableData.filter.viewTable"
                multiple="multiple"
            >
                <option
                    v-for="(viewclass, index) in themeTableClasses"
                    :key="index"
                    :value="viewclass"
                >{{viewclass}}</option>
            </select>
            <span class="icon">
                <i class="fas fa-table"></i>
            </span>
        </label>
        <!-- ./dataTables_viewtable -->

        <!-- dataTables_refresh -->
        <label class="dataTables_refresh">
            <button class="btn btn-outline-secondary" @click="$emit('getData')">
                <i class="fas fa-sync-alt"></i>
            </button>
        </label>
        <!-- ./dataTables_refresh -->

    </div>
</template>





<script>
export default {
    props: [
        "columns",
        "themeTableClasses",
        "tableData",
        "perPage",
        "actionMultiDelete"
    ],
    data() {
        return {
            updatedColumns: []
        }
    },
    methods: {
        updateColumns() {
            this.updatedColumns = this.columns.filter(column => {
                return column.name != 'show_plus' && column.name != 'select_row'
            })
        },
        deleteMulti(action) {
            this.actionMultiDelete.action = action
            this.$emit('deleteResotreMulti')
        }
    },
    watch: {
        "$i18n.locale"(val) {
            this.updatedColumns = []
            setTimeout(() => {
                this.updateColumns()
            })
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.updateColumns()
        })
    },
}
</script>

