<template>
    <a
        v-show="model.deleted_at != null"
        :href="`${$domain_admin}/${modelName}/restore`"
        class="btn btn-info btn-restore-row btn-table-actions btn-sm"
        @click.prevent="$emit('restoreRow')"
    >
        <i class="fa fa-undo-alt"></i>
    </a>
</template>

<script>
    export default {
        props: ['model', 'modelName']
    }
</script>
