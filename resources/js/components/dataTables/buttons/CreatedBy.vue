<template>
    <span>
        <router-link
            class="link-router-in-table"
            v-if="model.user !== null"
            :href="$domain_admin + '/user/' + model.user_id + '/edit'"
            :to="{name: 'edit-user', params: {id: model.user_id, user: model.user}}"
            data-name="edit-user"
            :data-params='"{\"user\":" + JSON.stringify(model.user) + ", \"id\":" + model.user.id + "}"'
        >
            {{ model.user.name }}
        </router-link>
        <span class="badge badge-danger" v-else> {{ $t('global.user_is_deleted') }} - id:{{model.user_id}}</span>
    </span>
</template>

<script>
    export default {
        props: ['model']
    }
</script>
