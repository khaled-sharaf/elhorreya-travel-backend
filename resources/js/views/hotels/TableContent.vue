<style lang="scss">

</style>

<template>
    <tbody>
        <tr
            role="row"
            v-for="(hotel, index) in dataTable"
            :key="hotel.id"
            :data-id="hotel.id"
            class="tr-general"
            :class="index % 2 == 0 ? 'even' : 'odd'"
        >


            <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                {{index + 1}}
            </td>


            <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                {{hotel.id}}
            </td>


            <td v-show="tableData.columns.indexOf('name') != -1" class="name">
                {{hotel.name | capitalize }}
            </td>


            <td v-show="tableData.columns.indexOf('address') != -1" class="address">
                {{hotel.address}}
            </td>


            <td v-show="tableData.columns.indexOf('rating') != -1" class="rating">
                <rates-stars :rates-count="hotel.rating"></rates-stars>
                <div class="text-center" style="font-size: 11px;">{{ hotel.rating }} %</div>
            </td>


            <td v-show="tableData.columns.indexOf('stars') != -1" class="stars">
                {{hotel.stars}}
            </td>


            <td v-show="tableData.columns.indexOf('info') != -1" class="info">
                {{hotel.info}}
            </td>


            <td v-show="tableData.columns.indexOf('location') != -1" class="location">
                <button
                    v-if="hotel.longitude != null && hotel.latitude != null"
                    class="btn btn-outline-secondary btn-sm"
                    id="show_map_location"
                    :data-long="hotel.longitude"
                    :data-lat="hotel.latitude"
                    :data-location-title="hotel.name">
                    Show map
                </button>
                <span v-else>{{ $t('global.no_location') }}</span>
            </td>


            <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                <img class="avatar-table" :src="$domain + '/' + hotel.image">
            </td>


            <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                <span class="icon-info" v-if="hotel.display == 1">
                    <i class="fas fa-eye"></i>
                </span>
                <span class="icon-warning" v-if="hotel.display == 0">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </td>


            <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                <router-link
                    class="link-router-in-table"
                    v-if="hotel.user !== null"
                    :href="$domain_admin + '/user/' + hotel.user_id + '/edit'"
                    :to="{name: 'edit-user', params: {id: hotel.user_id, user: hotel.user}}"
                    data-name="edit-user"
                    :data-params='"{\"user\":" + JSON.stringify(hotel.user) + ", \"id\":" + hotel.user.id + "}"'
                >
                    {{ hotel.user.name }}
                </router-link>
                <span class="badge badge-danger" v-else> {{ $t('global.user_is_deleted') }} - id:{{hotel.user_id}}</span>
            </td>

            <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                <relative-date :date="hotel.updated_at"></relative-date>
            </td>

            <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                <relative-date :date="hotel.created_at"></relative-date>
            </td>


            <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                <!-- show hotel profile -->
                <router-link
                    v-show="hotel.deleted_at == null"
                    :to="{name: 'hotel-profile', params: {hotel: hotel, id: hotel.id}}"
                    :href="$domain_admin + '/hotel/profile/' + hotel.id"
                    class="btn btn-info btn-show-profile btn-table-actions btn-sm link-router-in-table"
                    data-name="hotel-profile"
                    :data-params='"{\"hotel\":" + JSON.stringify(hotel) + ", \"id\":" + hotel.id + "}"'
                >
                    <i class="fas fa-eye"></i>
                </router-link>

                <!-- btn edit row -->
                <router-link
                    v-show="hotel.deleted_at == null"
                    :to="{name: 'edit-hotel', params: {hotel: hotel, id: hotel.id}}"
                    :href="$domain_admin + '/hotel/' + hotel.id + '/edit'"
                    class="btn btn-success btn-edit-row btn-table-actions btn-sm link-router-in-table"
                    data-name="edit-hotel"
                    :data-params='"{\"hotel\":" + JSON.stringify(hotel) + ", \"id\":" + hotel.id + "}"'
                >
                    <i class="fa fa-edit"></i>
                </router-link>
                <!-- ./btn edit row -->

                <!-- btn delete row -->
                <a
                    v-show="hotel.deleted_at == null"
                    :href="$domain_admin + '/hotel/destroy'"
                    class="btn btn-danger btn-delete-row btn-table-actions btn-sm"
                    @click.prevent="$emit('destroyRow', hotel.id)"
                >
                    <i class="fa fa-trash"></i>
                </a>
                <!-- ./ btn delete row -->


                <!-- btn restore row -->
                <a
                    v-show="hotel.deleted_at != null"
                    :href="$domain_admin + '/hotel/restore'"
                    class="btn btn-info btn-restore-row btn-table-actions btn-sm"
                    @click.prevent="$emit('restoreRow', hotel.id)"
                >
                    <i class="fas fa-undo-alt"></i>
                </a>
                <!-- ./ btn restore row -->

                <!-- btn delete row -->
                <a
                    v-show="hotel.deleted_at != null"
                    :href="$domain_admin + '/hotel/force-delete'"
                    class="btn btn-danger btn-delete-row force-delete btn-table-actions btn-sm"
                    @click.prevent="$emit('forceDeleteRow', hotel.id)"
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
