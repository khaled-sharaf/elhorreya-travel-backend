<style lang="scss">

</style>

<template>
    <tbody>
        <tr
            role="row"
            v-for="(travel_program, index) in dataTable"
            :key="travel_program.id"
            :data-id="travel_program.id"
            class="tr-general"
            :class="index % 2 == 0 ? 'even' : 'odd'"
        >

            <td class="td-show-plus show_plus">
                <span class="btn btn-secondary btn-show-more-row">
                    <i class="fa fa-plus"></i>
                </span>
            </td>


            <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                {{index + 1}}
            </td>


            <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                {{travel_program.id}}
            </td>


            <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                {{travel_program.name | capitalize }}
            </td>


            <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                <img class="avatar-table" :src="$domain + '/' + travel_program.image">
            </td>


            <td v-show="tableData.columns.indexOf('small_info') != -1" class="small_info">
                {{travel_program.small_info}}
            </td>


            <td v-show="tableData.columns.indexOf('big_info') != -1" class="big_info">
                {{travel_program.big_info}}
            </td>


            <td v-show="tableData.columns.indexOf('order') != -1" class="order">
                {{travel_program.order}}
            </td>


            <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                <router-link
                    class="link-router-in-table"
                    v-if="travel_program.user !== null"
                    :href="$domain_admin + '/user/' + travel_program.user_id + '/edit'"
                    :to="{name: 'edit-user', params: {id: travel_program.user_id, user: travel_program.user}}"
                    data-name="edit-user"
                    :data-params='"{\"user\":" + JSON.stringify(travel_program.user) + ", \"id\":" + travel_program.user.id + "}"'
                >
                    {{ travel_program.user.name }}
                </router-link>
                <span class="badge badge-danger" v-else> {{ $t('global.user_is_deleted') }} - id:{{travel_program.user_id}}</span>
            </td>

            <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                <relative-date :date="travel_program.updated_at"></relative-date>
            </td>

            <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                <relative-date :date="travel_program.created_at"></relative-date>
            </td>


            <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                <!-- btn edit row -->
                <router-link
                    v-show="travel_program.deleted_at == null"
                    :to="{name: 'edit-travel_program', params: {travel_program: travel_program, id: travel_program.id}}"
                    :href="$domain_admin + '/travel_program/' + travel_program.id + '/edit'"
                    class="btn btn-success btn-edit-row btn-table-actions btn-sm link-router-in-table"
                    data-name="edit-travel_program"
                    :data-params='"{\"travel_program\":" + JSON.stringify(travel_program) + ", \"id\":" + travel_program.id + "}"'
                >
                    <i class="fa fa-edit"></i>
                </router-link>
                <!-- ./btn edit row -->

                <!-- btn delete row -->
                <a
                    v-show="travel_program.deleted_at == null"
                    :href="$domain_admin + '/travel_program/destroy'"
                    class="btn btn-danger btn-delete-row btn-table-actions btn-sm"
                    @click.prevent="$emit('destroyRow', travel_program.id)"
                >
                    <i class="fa fa-trash"></i>
                </a>
                <!-- ./ btn delete row -->


                <!-- btn restore row -->
                <a
                    v-show="travel_program.deleted_at != null"
                    :href="$domain_admin + '/travel_program/restore'"
                    class="btn btn-info btn-restore-row btn-table-actions btn-sm"
                    @click.prevent="$emit('restoreRow', travel_program.id)"
                >
                    <i class="fas fa-undo-alt"></i>
                </a>
                <!-- ./ btn restore row -->

                <!-- btn delete row -->
                <a
                    v-show="travel_program.deleted_at != null"
                    :href="$domain_admin + '/travel_program/force-delete'"
                    class="btn btn-danger btn-delete-row force-delete btn-table-actions btn-sm"
                    @click.prevent="$emit('forceDeleteRow', travel_program.id)"
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
