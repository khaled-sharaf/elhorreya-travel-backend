<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title=" $t('global.create') + ' ' + $t('sidebar.new_hotel') "></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <router-link class="btn btn-primary btn-sm" :to="{name: 'hotels'}">{{ $t('global.show') + ' ' + $t('sidebar.all_hotels') }}</router-link>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="createHotel()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-hotel typeForm="create" :form="form"></form-hotel>
                                </div>
                                <!-- ./card-body -->


                                <!-- card-footer -->
                                <div class="card-footer">
                                    <button
                                        type="submit"
                                        :disabled="form.busy"
                                        class="btn btn-primary float-right"
                                    >{{ $t('global.create') }}</button>
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
import FormHotel from './Form'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    name: 'create-hotel',
    components: {
        FormHotel,
        HeaderPage
    },
    data() {
      return {
        urlCreateHotel: '/hotels',
        form: new Form({
            name: "",
            address: "",
            rating: 0,
            stars: 5,
            info: "",
            latitude: "",
            longitude: "",
            image: "",
            gallery: [],
            features: [
                {value: ''}
            ],
            display: 1,
        }),
        idPage: 'hotels',
        typePage: 'create'
      }
    },
    methods: {
        createHotel() {
            this.form.latitude = window.parseFloat($('#hotel_latitude').val())
            this.form.longitude = window.parseFloat($('#hotel_longitude').val())
            loadReq(this.$Progress);
            this.form.post(this.urlCreateHotel).then(response => {
                console.log(response.data)
                if (response.status === 200) {
                    // reset form
                    this.form.reset();
                    $('#remove-location-hotel').click()
                    ToastReq.fire({
                        text: this.success_msg
                    });
                    setTimeout(() => {
                        this.$router.push({name: 'hotel-profile', params: {id: response.data.data.id, hotel: response.data.data}})
                        setTimeout(() => {
                            $('html, body, .wrapper, .content-wrapper').scrollTop(0);
                        });
                    }, 2000);
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
            to.meta.title = vm.$t('global.create') + ' ' + vm.$t('sidebar.new_hotel')
        })
    }
}
</script>
