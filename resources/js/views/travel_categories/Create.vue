<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title=" $t('global.create') + ' ' + $t('sidebar.new_travel_category') "></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <router-link class="btn btn-primary btn-sm" :to="{name: 'travel_categories'}">{{ $t('global.show') + ' ' + $t('sidebar.all_travel_categories') }}</router-link>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="createTravelCategory()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-travel-category typeForm="create" :form="form"></form-travel-category>
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
import FormTravelCategory from './Form'
import BtnCreate from './../../components/form/BtnCreate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    name: 'create-travel_category',
    components: {
        FormTravelCategory,
        HeaderPage,
        BtnCreate
    },
    data() {
      return {
        urlCreateTravelCategory: '/travel_categories',
        form: new Form({
            name: '',
            image: '',
            travel_program_id: '',
            order: '',
        }),
        idPage: 'travel_categories',
        typePage: 'create'
      }
    },
    methods: {
        createTravelCategory() {
            loadReq(this.$Progress);
            this.form.post(this.urlCreateTravelCategory).then(response => {
                if (response.status === 200) {
                    // reset form
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
            to.meta.title = vm.$t('global.create') + ' ' + vm.$t('sidebar.new_travel_category')
        })
    }
}
</script>
