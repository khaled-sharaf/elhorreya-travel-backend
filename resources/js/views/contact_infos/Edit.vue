<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('global.edit') + ' ' + $t('sidebar.contact_infos')"></header-page>
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
                            <form @submit.prevent="updateContactInfo()">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-contact-info typeForm="edit" :form="form"></form-contact-info>
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
import FormContactInfo from './Form'
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'

import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormContactInfo,
        BtnUpdate
    },
    data() {
      return {
        urlModel: '/contact_infos',
        form: new Form({
            id: '',
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
        contactInfoEdit: {},
        idPage: 'contact_infos',
        typePage: 'edit'
      }
    },
    methods: {
        updateContactInfo() {
            this.form.latitude = window.parseFloat($('#hotel_latitude').val())
            this.form.longitude = window.parseFloat($('#hotel_longitude').val())

            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                if (response.status === 200) {
                    ToastReq.fire({
                        text: this.success_msg
                    })
                }
            }).catch(response => {
                ToastFailed.fire({
                    title: this.failed_title + "!",
                    text: this.failed_msg,
                })
                this.$Progress.fail()
            })
        },
        getContactInfoEdit(route) {
            axios.get(this.urlModel + '/' + route.params.id).then(response => {
                if (response.status === 200) {
                    const contact_info = response.data.contact_info
                    if (contact_info != null) {
                        this.form.reset()
                        $('#remove-location-hotel').click()

                        this.contactInfoEdit = contact_info
                        this.form.fill(this.contactInfoEdit)

                        if (this.form.latitude != null && this.form.longitude != null) {
                            $('.myMap #address').val('')
                        }
                        $('#hotel_latitude').val(this.form.latitude)
                        $('#hotel_longitude').val(this.form.longitude)

                    } else {
                        this.$router.push({name: 'contact_infos'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getContactInfoEdit(this.$route)
                }, 1000)
            })
        }
    },
    watch: {

    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_contact_info')
            vm.$nextTick(() => {
                if (to.params.contact_info) {
                    vm.form.reset()
                    $('#remove-location-hotel').click()

                    vm.contactInfoEdit = to.params.contact_info
                    vm.form.fill(vm.contactInfoEdit)

                    if (vm.form.latitude != null && vm.form.longitude != null) {
                        $('.myMap #address').val('')
                    }
                    $('#hotel_latitude').val(vm.form.latitude)
                    $('#hotel_longitude').val(vm.form.longitude)

                } else {
                    vm.getContactInfoEdit(to)
                }
            })
        })
    }
}
</script>
