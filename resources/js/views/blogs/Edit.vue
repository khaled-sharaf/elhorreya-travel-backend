<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('sidebar.edit_blog')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <h3 class="m-0 mb-2 text-dark">
                                    <router-link class="btn btn-primary btn-sm" :to="{name: 'blogs'}">{{ $t('global.show') + ' ' + $t('sidebar.all_blogs') }}</router-link>
                                </h3>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="updateBlog()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-blog typeForm="edit" :form="form"></form-blog>
                                </div>
                                <!-- ./card-body -->


                                <!-- card-footer -->
                                <div class="card-footer">
                                    <btn-update :form="form"></btn-update>
                                </div> <!-- ./card-footer -->

                            </form><!-- form -->
                        </div>
                    </div><!-- /.col-12 -->

                </div><!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    </div>
</template>


<script>
import FormBlog from './Form'
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormBlog,
        BtnUpdate
    },
    data() {
      return {
        urlModel: '/blogs',
        form: new Form({
            id: 0,
            title: "",
            content: "",
            image: "",
            gallery: [],
            deletedGallery: [],
            display: 1,
        }),
        blogEdit: {},
        idPage: 'blogs',
        typePage: 'edit'
      }
    },
    methods: {
        updateBlog() {
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                if (response.status === 200) {
                    this.blogEdit = response.data.blog;
                    this.blogEdit.deletedGallery = []
                    this.form.fill(this.blogEdit)
                    ToastReq.fire({
                        text: this.success_msg
                    });
                }
            }).catch(response => {
                ToastFailed.fire({
                    title: this.failed_title + "!",
                    text: this.failed_msg,
                })
                this.$Progress.fail();
            });
        },
        getBlogEdit(route) {
            axios.get(this.urlModel + '/' +  route.params.id).then(response => {
                if (response.status === 200) {
                    const blog = response.data.blog
                    if (blog != null) {
                        this.blogEdit = blog
                        this.blogEdit.deletedGallery = []
                        this.form.fill(this.blogEdit)
                    } else {
                        this.$router.push({name: 'blogs'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getBlogEdit(this.$route)
                }, 1000)
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_blog')
            vm.$nextTick(() => {
                if (to.params.blog) {
                    vm.blogEdit = to.params.blog
                    vm.blogEdit.deletedGallery = []
                    vm.form.fill(vm.blogEdit)
                } else {
                    vm.getBlogEdit(to)
                }
            })
        })
    }
}
</script>
