<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('sidebar.edit_travel')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <!-- form -->
                            <form @submit.prevent="updateTravel()" class="form-product">

                                <div class="card-header">
                                    <h3 class="m-0 mb-2 text-dark float-right">
                                        <!-- show travel profile  -->
                                        <router-link
                                            :to="{name: 'travel-profile', params: {id: travelEdit.id, travel: travelEdit}}"
                                            :href="$domain_admin + '/travel/profile/' + travelEdit.id"
                                            class="btn btn-primary btn-sm"
                                            :class="{ disabled: form.busy }"
                                        >
                                            {{ $t('global.goto_travel_profile') }}
                                        </router-link>
                                    </h3>
                                    <div class="float-left">
                                        <btn-update :form="form"></btn-update>
                                    </div>
                                </div>
                                <!-- ./card-header -->


                                <!-- card-body -->
                                <div class="card-body">
                                    <form-travel typeForm="edit" :form="form"></form-travel>
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
import FormTravel from './Form'
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormTravel,
        BtnUpdate
    },
    data() {
        return {
            urlModel: '/travels',
            form: new Form({
                id: "",
                name: "",
                address_from: "",
                address_to: "",
                info: "",
                type: "",
                external_type: "",
                umrah_date: "",
                haram_distance: 0,
                itinerary_1: "",
                itinerary_2: "",
                itinerary_3: "",
                itinerary_4: "",
                itinerary_5: "",
                discount: "",
                favorite_company: 0,
                image: "",
                gallery: [],
                deletedGallery: [],
                hotel_id: "",
                hotel_2_id: "",
                travel_category_id: "",
                display: 1,
                deletedOffers: [],
                offers: [
                    {
                        name_offer: "",
                        info_offer: "",
                        date_from: "",
                        date_to: "",
                        hotel_days: "",
                        hotel_2_days: "",
                        stay_type: "بدون إفطار",
                        stay_type_2: "",
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
            travelEdit: {},
            idPage: 'travels',
            typePage: 'edit',
            offersForm: {
                name_offer: "",
                info_offer: "",
                date_from: "",
                date_to: "",
                hotel_days: "",
                hotel_2_days: "",
                stay_type: "بدون إفطار",
                stay_type_2: "",
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
        }
    },
    methods: {
        updateTravel() {
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                if (response.status === 200) {
                    this.travelEdit = response.data.data;
                    this.travelEdit.deletedGallery = []
                    this.travelEdit.deletedOffers = []
                    this.form.fill(this.travelEdit)
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
        getTravelEdit(route) {
            axios.get(this.urlModel + '/' +  route.params.id).then(response => {
                if (response.status === 200) {
                    const travel = response.data.travel
                    if (travel != null) {
                        this.travelEdit = travel
                        if (!travel.offers.length) {
                            this.travelEdit.offers.push({...this.offersForm})
                        }
                        this.travelEdit.deletedGallery = []
                        this.travelEdit.deletedOffers = []
                        this.form.fill(this.travelEdit)
                    } else {
                        this.$router.push({name: 'travels'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelEdit(this.$route)
                }, 500)
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_travel')
            vm.$nextTick(() => {
                if (to.params.travel) {
                    vm.travelEdit = to.params.travel
                    if (!vm.travelEdit.offers.length) {
                        vm.travelEdit.offers.push({...vm.offersForm})
                    }
                    vm.travelEdit.deletedGallery = []
                    vm.travelEdit.deletedOffers = []
                    vm.form.fill(vm.travelEdit)
                } else {
                    vm.getTravelEdit(to)
                }
            })
        })
    }
}
</script>
