<style lang="scss">

</style>

<template>
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
                <span class="icon-info" v-if="image.display == 1">
                    <i class="fas fa-eye"></i>
                </span>
                <span class="icon-warning" v-if="image.display == 0">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </td>


            <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                <router-link
                    class="link-router-in-table"
                    v-if="image.user !== null"
                    :href="$domain_admin + '/user/' + image.user_id + '/edit'"
                    :to="{name: 'edit-user', params: {id: image.user_id, user: image.user}}"
                    data-name="edit-user"
                    :data-params='"{\"user\":" + JSON.stringify(image.user) + ", \"id\":" + image.user.id + "}"'
                >
                    {{ image.user.name }}
                </router-link>
                <span class="badge badge-danger" v-else> {{ $t('global.user_is_deleted') }} - id:{{image.user_id}}</span>
            </td>

            <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                <relative-date :date="image.updated_at"></relative-date>
            </td>

            <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                <relative-date :date="image.created_at"></relative-date>
            </td>


            <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                <!-- btn edit row -->
                <router-link
                    v-show="image.deleted_at == null"
                    :to="{name: 'edit-image', params: {image: image, id: image.id}}"
                    :href="$domain_admin + '/image/' + image.id + '/edit'"
                    class="btn btn-success btn-edit-row btn-table-actions btn-sm link-router-in-table"
                    data-name="edit-image"
                    :data-params='"{\"image\":" + JSON.stringify(image) + ", \"id\":" + image.id + "}"'
                >
                    <i class="fa fa-edit"></i>
                </router-link>
                <!-- ./btn edit row -->

                <!-- btn delete row -->
                <a
                    v-show="image.deleted_at == null"
                    :href="$domain_admin + '/image/destroy'"
                    class="btn btn-danger btn-delete-row btn-table-actions btn-sm"
                    @click.prevent="$emit('destroyRow', image.id)"
                >
                    <i class="fa fa-trash"></i>
                </a>
                <!-- ./ btn delete row -->


                <!-- btn restore row -->
                <a
                    v-show="image.deleted_at != null"
                    :href="$domain_admin + '/image/restore'"
                    class="btn btn-info btn-restore-row btn-table-actions btn-sm"
                    @click.prevent="$emit('restoreRow', image.id)"
                >
                    <i class="fas fa-undo-alt"></i>
                </a>
                <!-- ./ btn restore row -->

                <!-- btn delete row -->
                <a
                    v-show="image.deleted_at != null"
                    :href="$domain_admin + '/image/force-delete'"
                    class="btn btn-danger btn-delete-row force-delete btn-table-actions btn-sm"
                    @click.prevent="$emit('forceDeleteRow', image.id)"
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
