<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title=" $t('global.create') + ' ' + $t('sidebar.new_image') "></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <router-link class="btn btn-primary btn-sm" :to="{name: 'images'}">{{ $t('global.show') + ' ' + $t('sidebar.all_images') }}</router-link>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="createImage()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-image typeForm="create" :form="form"></form-image>
                                </div>
                                <!-- ./card-body -->


                                <!-- card-footer -->
                                <div class="card-footer">
                                    <btn-create :form="form"></btn-create>
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
import FormImage from './FormCreate'
import BtnCreate from './../../components/form/BtnCreate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    name: 'create-image',
    components: {
        FormImage,
        HeaderPage,
        BtnCreate
    },
    data() {
      return {
        urlCreateImage: '/images',
        form: new Form({
            travel_category_id: "",
            display: 1,
            gallery: [],
            deletedGallery: [],
        }),
        idPage: 'images',
        typePage: 'create'
      }
    },
    methods: {
        createImage() {
            loadReq(this.$Progress);
            this.form.post(this.urlCreateImage).then(response => {
                if (response.status === 200) {
                    // reset form
                    console.log(response.data)
                    this.form.reset();
                    ToastReq.fire({
                        text: this.success_msg
                    });
                }
            }).catch(errors => {
                ToastFailed.fire({
                    title: this.failed_title + "!",
                    text: this.failed_msg,
                })
                this.$Progress.fail();
            });
        },
    },
    beforeRouteEnter (to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('global.create') + ' ' + vm.$t('sidebar.new_image')
        })
    }
}
</script>
