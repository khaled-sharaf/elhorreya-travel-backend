<template>
    <router-link
        v-show="model.deleted_at == null"
        :to="{name: `edit-${modelName}`, params: {id: model.id, [modelName]: model}}"
        :href="`${$domain_admin}/${modelName}/${model.id}/edit`"
        :class="['btn btn-success btn-edit-row btn-table-actions btn-sm', classes, {'link-router-in-table': inTable}]"
        :data-name='inTable ? `edit-${modelName}`: ""'
        :data-params='inTable ? `{"${[modelName]}": ${JSON.stringify(model)}, "id": ${model.id}}`: ""'
    >
        <slot></slot>
        <i class="fa fa-edit"></i>
    </router-link>
</template>

<script>
    export default {
        props: {
            model: Object,
            modelName: String,
            classes: String,
            inTable: {
                type: Boolean,
                default: true
            }
        }
    }
</script>
