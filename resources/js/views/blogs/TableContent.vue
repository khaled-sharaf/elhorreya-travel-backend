<style lang="scss">

</style>

<template>
    <tbody>
        <tr
            role="row"
            v-for="(blog, index) in dataTable"
            :key="blog.id"
            :data-id="blog.id"
            class="tr-general"
            :class="index % 2 == 0 ? 'even' : 'odd'"
        >


            <td v-show="tableData.columns.indexOf('index') != -1" class="index">
                {{index + 1}}
            </td>


            <td v-show="tableData.columns.indexOf('id') != -1" class="id">
                {{blog.id}}
            </td>


            <td v-show="tableData.columns.indexOf('title') != -1" class="title">
                {{blog.title | capitalize }}
            </td>


            <td v-show="tableData.columns.indexOf('content') != -1" class="content">
                {{blog.content}}
            </td>


            <td v-show="tableData.columns.indexOf('image') != -1" class="image" style="text-align:center;">
                <img class="avatar-table" :src="$domain + '/' + blog.image">
            </td>


            <td v-show="tableData.columns.indexOf('display') != -1" class="display">
                <span class="icon-info" v-if="blog.display == 1">
                    <i class="fas fa-eye"></i>
                </span>
                <span class="icon-warning" v-if="blog.display == 0">
                    <i class="fas fa-eye-slash"></i>
                </span>
            </td>


            <td v-show="tableData.columns.indexOf('user_id') != -1" class="user_id">
                <router-link
                    class="link-router-in-table"
                    v-if="blog.user !== null"
                    :href="$domain_admin + '/user/' + blog.user_id + '/edit'"
                    :to="{name: 'edit-user', params: {id: blog.user_id, user: blog.user}}"
                    data-name="edit-user"
                    :data-params='"{\"user\":" + JSON.stringify(blog.user) + ", \"id\":" + blog.user.id + "}"'
                >
                    {{ blog.user.name }}
                </router-link>
                <span class="badge badge-danger" v-else> {{ $t('global.user_is_deleted') }} - id:{{blog.user_id}}</span>
            </td>

            <td v-show="tableData.columns.indexOf('updated_at') != -1" class="updated_at">
                <relative-date :date="blog.updated_at"></relative-date>
            </td>

            <td v-show="tableData.columns.indexOf('created_at') != -1" class="created_at">
                <relative-date :date="blog.created_at"></relative-date>
            </td>


            <td v-show="tableData.columns.indexOf('actions') != -1" class="actions">
                <!-- btn edit row -->
                <router-link
                    v-show="blog.deleted_at == null"
                    :to="{name: 'edit-blog', params: {blog: blog, id: blog.id}}"
                    :href="$domain_admin + '/blog/' + blog.id + '/edit'"
                    class="btn btn-success btn-edit-row btn-table-actions btn-sm link-router-in-table"
                    data-name="edit-blog"
                    :data-params='"{\"blog\":" + JSON.stringify(blog) + ", \"id\":" + blog.id + "}"'
                >
                    <i class="fa fa-edit"></i>
                </router-link>
                <!-- ./btn edit row -->

                <!-- btn delete row -->
                <a
                    v-show="blog.deleted_at == null"
                    :href="$domain_admin + '/blog/destroy'"
                    class="btn btn-danger btn-delete-row btn-table-actions btn-sm"
                    @click.prevent="$emit('destroyRow', blog.id)"
                >
                    <i class="fa fa-trash"></i>
                </a>
                <!-- ./ btn delete row -->


                <!-- btn restore row -->
                <a
                    v-show="blog.deleted_at != null"
                    :href="$domain_admin + '/blog/restore'"
                    class="btn btn-info btn-restore-row btn-table-actions btn-sm"
                    @click.prevent="$emit('restoreRow', blog.id)"
                >
                    <i class="fas fa-undo-alt"></i>
                </a>
                <!-- ./ btn restore row -->

                <!-- btn delete row -->
                <a
                    v-show="blog.deleted_at != null"
                    :href="$domain_admin + '/blog/force-delete'"
                    class="btn btn-danger btn-delete-row force-delete btn-table-actions btn-sm"
                    @click.prevent="$emit('forceDeleteRow', blog.id)"
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
