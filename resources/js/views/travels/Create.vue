<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title=" $t('global.create') + ' ' + $t('sidebar.new_travel') "></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <router-link class="btn btn-primary btn-sm" :to="{name: 'travels'}">{{ $t('global.show') + ' ' + $t('sidebar.all_travels') }}</router-link>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="createTravel()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-travel typeForm="create" :form="form"></form-travel>
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
import FormTravel from './Form'
import BtnCreate from './../../components/form/BtnCreate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    name: 'create-travel',
    components: {
        FormTravel,
        HeaderPage,
        BtnCreate
    },
    data() {
      return {
        urlCreateTravel: '/travels',
        form: new Form({
            name: "",
            address_from: "",
            info: "",
            type: "other",
            umrah_date: "",
            haram_distance: 0,
            itinerary_1: "",
            itinerary_2: "",
            itinerary_3: "",
            itinerary_4: "",
            itinerary_5: "",
            discount: '',
            favorite_company: 0,
            image: "",
            gallery: [],
            hotel_id: "",
            hotel_2_id: "",
            travel_category_id: "",
            display: 1,
            offers: [
                {
                    info_offer: "",
                    go_and_back: 0,
                    date_from: "",
                    date_to: "",
                    hotel_days: "",
                    hotel_2_days: "",
                    stay_type: "بدون إفطار",
                    transport: 0,
                    adults: "",
                    children: "",
                    child_price: "",
                    baby_price: "",
                    single_price: "",
                    twin_price: "",
                    triple_price: "",
                    display: 1
                }
            ],
        }),
        idPage: 'travels',
        typePage: 'create'
      }
    },
    methods: {
        createTravel() {
            loadReq(this.$Progress);
            this.form.post(this.urlCreateTravel).then(response => {
                if (response.status === 200) {
                    // console.log(response.data)
                    // reset form
                    this.form.reset();
                    ToastReq.fire({
                        text: this.success_msg
                    });
                    setTimeout(() => {
                        this.$router.push({name: 'travel-profile', params: {id: response.data.data.id, travel: response.data.data}})
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
            to.meta.title = vm.$t('global.create') + ' ' + vm.$t('sidebar.new_travel')
        })
    }
}
</script>
