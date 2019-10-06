<template>
    <router-link
        v-show="model.deleted_at == null"
        :to="{name: `${modelName}-profile`, params: {[modelName]: model, id: model.id}}"
        :href="`${$domain_admin}/${modelName}/profile/${model.id}`"
        class="btn btn-info btn-show-profile btn-table-actions btn-sm link-router-in-table"
        :data-name="`${modelName}-profile`"
        :data-params='`{"${[modelName]}": ${JSON.stringify(model)}, "id": ${model.id}}`'
    >
        <i class="fas fa-eye"></i>
    </router-link>
</template>

<script>
    export default {
        props: ['model', 'modelName']
    }
</script>
