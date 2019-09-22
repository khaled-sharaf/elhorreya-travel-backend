<style lang="scss">

</style>

<template>
    <tbody>
        <tr
            role="row"
            v-for="(travel_category, index) in dataTable"
            :key="travel_category.id"
            :data-id="travel_category.id"
            class="tr-general"
            :class="index % 2 == 0 ? 'even' : 'odd'"
        >


            <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                {{index + 1}}
            </td>


            <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                {{travel_category.id}}
            </td>


            <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                {{travel_category.name | capitalize }}
            </td>


            <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                <img class="avatar-table" :src="$domain + '/' + travel_category.image">
            </td>


            <td v-show="tableData.columns.indexOf('order') != -1" class="order">
                {{travel_category.order}}
            </td>


            <td v-show="tableData.columns.indexOf('travel_program_id') != -1" class="travel_program_id">
                <router-link
                    class="link-router-in-table"
                    v-if="travel_category.travel_program !== null"
                    :href="$domain_admin + '/travel_program/' + travel_category.travel_program_id + '/edit'"
                    :to="{name: 'edit-travel_program', params: {id: travel_category.travel_program_id, travel_program: travel_category.travel_program}}"
                    data-name="edit-travel_program"
                    :data-params='"{\"travel_program\":" + JSON.stringify(travel_category.travel_program) + ", \"id\":" + travel_category.travel_program_id + "}"'
                >
                    {{ travel_category.travel_program.name }}
                </router-link>
                <span class="badge badge-danger" v-else> {{ $t('global.travel_program_is_deleted') }} - id:{{travel_category.travel_program_id}}</span>
            </td>


            <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                <router-link
                    class="link-router-in-table"
                    v-if="travel_category.user !== null"
                    :href="$domain_admin + '/user/' + travel_category.user_id + '/edit'"
                    :to="{name: 'edit-user', params: {id: travel_category.user_id, user: travel_category.user}}"
                    data-name="edit-user"
                    :data-params='"{\"user\":" + JSON.stringify(travel_category.user) + ", \"id\":" + travel_category.user.id + "}"'
                >
                    {{ travel_category.user.name }}
                </router-link>
                <span class="badge badge-danger" v-else> {{ $t('global.user_is_deleted') }} - id:{{travel_category.user_id}}</span>
            </td>


            <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                <relative-date :date="travel_category.updated_at"></relative-date>
            </td>

            <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                <relative-date :date="travel_category.created_at"></relative-date>
            </td>


            <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                <!-- btn edit row -->
                <router-link
                    v-show="travel_category.deleted_at == null"
                    :to="{name: 'edit-travel_category', params: {travel_category: travel_category, id: travel_category.id}}"
                    :href="$domain_admin + '/travel_category/' + travel_category.id + '/edit'"
                    class="btn btn-success btn-edit-row btn-table-actions btn-sm link-router-in-table"
                    data-name="edit-travel_category"
                    :data-params='"{\"travel_category\":" + JSON.stringify(travel_category) + ", \"id\":" + travel_category.id + "}"'
                >
                    <i class="fa fa-edit"></i>
                </router-link>
                <!-- ./btn edit row -->

                <!-- btn delete row -->
                <a
                    v-show="travel_category.deleted_at == null"
                    :href="$domain_admin + '/travel_category/destroy'"
                    class="btn btn-danger btn-delete-row btn-table-actions btn-sm"
                    @click.prevent="$emit('destroyRow', travel_category.id)"
                >
                    <i class="fa fa-trash"></i>
                </a>
                <!-- ./ btn delete row -->


                <!-- btn restore row -->
                <a
                    v-show="travel_category.deleted_at != null"
                    :href="$domain_admin + '/travel_category/restore'"
                    class="btn btn-info btn-restore-row btn-table-actions btn-sm"
                    @click.prevent="$emit('restoreRow', travel_category.id)"
                >
                    <i class="fas fa-undo-alt"></i>
                </a>
                <!-- ./ btn restore row -->

                <!-- btn delete row -->
                <a
                    v-show="travel_category.deleted_at != null"
                    :href="$domain_admin + '/travel_category/force-delete'"
                    class="btn btn-danger btn-delete-row force-delete btn-table-actions btn-sm"
                    @click.prevent="$emit('forceDeleteRow', travel_category.id)"
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
