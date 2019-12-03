<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title=" $t('global.create') + ' ' + $t('sidebar.new_contact_info') "></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <router-link class="btn btn-primary btn-sm" :to="{name: 'contact_infos'}">{{ $t('global.show') + ' ' + $t('sidebar.all_contact_infos') }}</router-link>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="createContactInfo()">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-contact-info :typeForm="typePage" :form="form"></form-contact-info>
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
import formContactInfo from './Form'
import BtnCreate from './../../components/form/BtnCreate'
import HeaderPage from './../../components/HeaderPage'

import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    name: 'create-contact_info',
    components: {
        HeaderPage,
        formContactInfo,
        BtnCreate
    },
    data() {
      return {
        urlModel: '/contact_infos',
        form: new Form({
            branch_name: '',
            phone_1: '',
            phone_2: '',
            phone_3: '',
            phone_4: '',
            address: '',
            email: '',
            latitude: '',
            longitude: '',
            display: 1,
        }),
        idPage: 'contact_infos',
        typePage: 'create'
      }
    },
    methods: {
        createContactInfo() {
            this.form.latitude = window.parseFloat($('#hotel_latitude').val())
            this.form.longitude = window.parseFloat($('#hotel_longitude').val())

            loadReq(this.$Progress);
            this.form.post(this.urlModel).then(response => {
                if (response.status === 200) {
                    console.log(response.data)
                    this.form.reset();
                    $('#remove-location-hotel').click()
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
    },
    beforeRouteEnter (to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('global.create') + ' ' + vm.$t('sidebar.new_contact_info')
        })
    }
}
</script>
