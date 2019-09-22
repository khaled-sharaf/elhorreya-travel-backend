<style lang="scss">

</style>

<template>
    <tbody>
        <tr
            role="row"
            v-for="(user, index) in dataTable"
            :key="user.id"
            :data-id="user.id"
            class="tr-general"
            :class="index % 2 == 0 ? 'even' : 'odd'"
        >


            <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                {{index + 1}}
            </td>


            <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                {{user.id}}
            </td>


            <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                {{user.name | capitalize }}
            </td>


            <td v-show="tableData.columns.indexOf('email') != -1" class="email">
                <a :href="'mailto:' + user.email">{{user.email}}</a>
            </td>


            <td v-show="tableData.columns.indexOf('image') != -1" class="image">
                <img class="avatar-table" :src="user.image.indexOf('http') === 0 ? user.image : $domain + '/' + user.image">
            </td>

            <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                <relative-date :date="user.updated_at"></relative-date>
            </td>

            <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                <relative-date :date="user.created_at"></relative-date>
            </td>


            <td v-show="tableData.columns.indexOf('actions') != -1"
                class="actions"
                >
                <!-- btn edit row -->
                <router-link
                    v-show="user.deleted_at == null"
                    :to="{name: 'edit-user', params: {user: user, id: user.id}}"
                    :href="$domain_admin + '/user/' + user.id + '/edit'"
                    class="btn btn-success btn-edit-row btn-table-actions btn-sm link-router-in-table"
                    data-name="edit-user"
                    :data-params='"{\"user\":" + JSON.stringify(user) + ", \"id\":" + user.id + "}"'
                >
                    <i class="fa fa-edit"></i>
                </router-link>
                <!-- ./ btn edit row -->

                <!-- btn delete row -->
                <a
                    v-show="user.deleted_at == null && user.id != 1"
                    :href="$domain_admin + '/users/destroy'"
                    class="btn btn-danger btn-delete-row btn-table-actions btn-sm"
                    @click.prevent="$emit('destroyRow', user.id)"
                >
                    <i class="fa fa-trash"></i>
                </a>
                <!-- ./ btn delete row -->


                <!-- btn restore row -->
                <a
                    v-show="user.deleted_at != null && user.id != 1"
                    :href="$domain_admin + '/users/restore'"
                    class="btn btn-info btn-restore-row btn-table-actions btn-sm"
                    @click.prevent="$emit('restoreRow', user.id)"
                >
                    <i class="fas fa-undo-alt"></i>
                </a>
                <!-- ./ btn restore row -->

                <!-- btn force delete row -->
                <a
                    v-show="user.deleted_at != null && user.id != 1"
                    :href="$domain_admin + '/users/force-delete'"
                    class="btn btn-danger btn-delete-row force-delete btn-table-actions btn-sm"
                    @click.prevent="$emit('forceDeleteRow', user.id)"
                >
                    <i class="far fa-trash-alt"></i>
                </a>
                <!-- ./ btn delete row -->

            </td>
        </tr>
    </tbody>
</template>




<script>
export default {
    props: [
        'dataTable',
        'tableData',
    ]
}
</script>
