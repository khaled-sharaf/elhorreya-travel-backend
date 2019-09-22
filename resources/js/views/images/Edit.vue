<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('sidebar.edit_image')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <h3 class="m-0 mb-2 text-dark">
                                    <router-link class="btn btn-primary btn-sm" :to="{name: 'images'}">{{ $t('global.show') + ' ' + $t('sidebar.all_images') }}</router-link>
                                </h3>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="updateImage()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-image typeForm="edit" :form="form"></form-image>
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
import FormImage from './FormEdit'
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormImage,
        BtnUpdate
    },
    data() {
      return {
        urlModel: '/images',
        form: new Form({
            image: "",
            display: 1
        }),
        imageEdit: {},
        idPage: 'images',
        typePage: 'edit'
      }
    },
    methods: {
        updateImage() {
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.$route.params.id).then(response => {
                if (response.status === 200) {
                    const data = response.data.image
                    this.imageEdit = {
                        image: data.name,
                        display: data.display
                    }
                    this.form.fill(this.imageEdit)
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
        getImageEdit(route) {
            axios.get(this.urlModel + '/' +  route.params.id).then(response => {
                if (response.status === 200) {
                    const data = response.data.image
                    if (data != null) {
                        this.imageEdit = {
                            image: data.name,
                            display: data.display
                        }
                        this.form.fill(this.imageEdit)
                    } else {
                        this.$router.push({name: 'images'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getImageEdit(this.$route)
                }, 1000)
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_image')
            vm.$nextTick(() => {
                if (to.params.image) {
                    const data = to.params.image
                    vm.imageEdit = {
                        image: data.name,
                        display: data.display
                    }
                    vm.form.fill(vm.imageEdit)
                } else {
                    vm.getImageEdit(to)
                }
            })
        })
    }
}
</script>
