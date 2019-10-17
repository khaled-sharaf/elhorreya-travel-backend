<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title=" $t('global.create') + ' ' + $t('sidebar.new_travel_program') "></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <router-link class="btn btn-primary btn-sm" :to="{name: 'travel_programs'}">{{ $t('global.show') + ' ' + $t('sidebar.all_travel_programs') }}</router-link>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="createTravelProgram()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-travel-program typeForm="create" :form="form"></form-travel-program>
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
import FormTravelProgram from './Form'
import BtnCreate from './../../components/form/BtnCreate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    name: 'create-travel_program',
    components: {
        FormTravelProgram,
        HeaderPage,
        BtnCreate
    },
    data() {
      return {
        urlCreateTravelProgram: '/travel_programs',
        form: new Form({
            name: '',
            discount: '',
            image: '',
            small_info: '',
            big_info: '',
            order: '',
        }),
        idPage: 'travel_programs',
        typePage: 'create'
      }
    },
    methods: {
        createTravelProgram() {
            loadReq(this.$Progress);
            this.form.post(this.urlCreateTravelProgram).then(response => {
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
            to.meta.title = vm.$t('global.create') + ' ' + vm.$t('sidebar.new_travel_program')
        })
    }
}
</script>
