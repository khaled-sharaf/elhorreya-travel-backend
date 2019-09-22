<style lang="scss">

</style>

<template>
    <tbody>
        <tr
            role="row"
            v-for="(room, index) in dataTable"
            :key="room.id"
            :data-id="room.id"
            class="tr-general"
            :class="index % 2 == 0 ? 'even' : 'odd'"
        >


            <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                {{index + 1}}
            </td>


            <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                {{room.id}}
            </td>


            <td v-show="tableData.columns.indexOf('info') != -1" class="info">
                {{room.info}}
            </td>


            <td v-show="tableData.columns.indexOf('options') != -1" class="options">
                {{room.options}}
            </td>


            <td v-show="tableData.columns.indexOf('price_night') != -1" class="price_night">
                {{room.price_night}}
            </td>


            <td v-show="tableData.columns.indexOf('offer') != -1" class="offer">
                <span v-if="(room.offer_price != null && room.offer_price != 0) && (room.offer_days != null && room.offer_days != 0)">
                    <span class="badge badge-danger" v-text="room.offer_price"></span>
                    {{ $t('global.in') }}
                    <span class="badge badge-danger" v-text="room.offer_days"></span>
                    <span v-if="room.offer_days >= 2">
                        {{ $t('rooms_table.nights') }}
                    </span>
                    <span v-else>
                        {{ $t('rooms_table.night') }}
                    </span>
                </span>
                <span v-else>ــــ</span>
            </td>

            <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                <span class="icon-info" v-if="room.display == 1">
                    <i class="fas fa-eye"></i>
                </span>
                <span class="icon-warning" v-if="room.display == 0">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </td>



            <td v-show="tableData.columns.indexOf('hotel_id') != -1" class="hotel_id">
                <router-link
                    class="link-router-in-table"
                    v-if="room.hotel !== null"
                    :href="$domain_admin + '/hotel/profile/' + room.hotel_id"
                    :to="{name: 'hotel-profile', params: {id: room.hotel_id, hotel: room.hotel}}"
                    data-name="hotel-profile"
                    :data-params='"{\"hotel\":" + JSON.stringify(room.hotel) + ", \"id\":" + room.hotel_id + "}"'
                >
                    {{ room.hotel.name }}
                </router-link>
                <span class="badge badge-danger" v-else> {{ $t('global.hotel_is_deleted') }} - id:{{room.hotel_id}}</span>
            </td>


            <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                <router-link
                    class="link-router-in-table"
                    v-if="room.user !== null"
                    :href="$domain_admin + '/user/' + room.user_id + '/edit'"
                    :to="{name: 'edit-user', params: {id: room.user_id, user: room.user}}"
                    data-name="edit-user"
                    :data-params='"{\"user\":" + JSON.stringify(room.user) + ", \"id\":" + room.user_id + "}"'
                >
                    {{ room.user.name }}
                </router-link>
                <span class="badge badge-danger" v-else> {{ $t('global.user_is_deleted') }} - id:{{room.user_id}}</span>
            </td>


            <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                <relative-date :date="room.updated_at"></relative-date>
            </td>

            <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                <relative-date :date="room.created_at"></relative-date>
            </td>


            <td v-show="tableData.columns.indexOf('actions') != -1"
                class="actions"
                >
                <!-- btn edit row -->
                <router-link
                    v-show="room.deleted_at == null"
                    :to="{name: 'edit-room', params: {room: room, id: room.id}}"
                    :href="$domain_admin + '/room/' + room.id + '/edit'"
                    class="btn btn-success btn-edit-row btn-table-actions btn-sm link-router-in-table"
                    data-name="edit-room"
                    :data-params='"{\"room\":" + JSON.stringify(room) + ", \"id\":" + room.id + "}"'
                >
                    <i class="fa fa-edit"></i>
                </router-link>
                <!-- ./ btn edit row -->

                <!-- btn delete row -->
                <a
                    v-show="room.deleted_at == null"
                    :href="$domain_admin + '/rooms/destroy'"
                    class="btn btn-danger btn-delete-row btn-table-actions btn-sm"
                    @click.prevent="$emit('destroyRow', room.id)"
                >
                    <i class="fa fa-trash"></i>
                </a>
                <!-- ./ btn delete row -->


                <!-- btn restore row -->
                <a
                    v-show="room.deleted_at != null"
                    :href="$domain_admin + '/rooms/restore'"
                    class="btn btn-info btn-restore-row btn-table-actions btn-sm"
                    @click.prevent="$emit('restoreRow', room.id)"
                >
                    <i class="fas fa-undo-alt"></i>
                </a>
                <!-- ./ btn restore row -->

                <!-- btn force delete row -->
                <a
                    v-show="room.deleted_at != null"
                    :href="$domain_admin + '/rooms/force-delete'"
                    class="btn btn-danger btn-delete-row force-delete btn-table-actions btn-sm"
                    @click.prevent="$emit('forceDeleteRow', room.id)"
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
