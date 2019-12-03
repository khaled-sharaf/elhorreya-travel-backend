<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('sidebar.edit_marketing_hotel')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <h3 class="m-0 mb-2 text-dark">
                                    <!-- show hotel profile  -->
                                    <router-link
                                        :to="{name: 'marketing_hotel-profile', params: {id: hotelEdit.id, hotel: hotelEdit}}"
                                        :href="$domain_admin + '/marketing_hotel/profile/' + hotelEdit.id"
                                        class="btn btn-primary btn-sm"
                                        :class="{ disabled: form.busy }"
                                    >
                                        {{ $t('global.goto_hotel_profile') }}
                                    </router-link>
                                </h3>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="updateHotel()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-hotel typeForm="edit" :form="form"></form-hotel>
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
import FormHotel from './Form'
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormHotel,
        BtnUpdate
    },
    data() {
      return {
        urlModel: '/marketing_hotels',
        form: new Form({
            id: 0,
            name: "",
            address: "",
            stars: 0,
            info: "",
            latitude: "",
            longitude: "",
            image: "",
            gallery: [],
            deletedGallery: [],
            features: [
                {value: ''}
            ],
            deletedFeatures: [],
            display: 1,
            deletedRooms: [],
            rooms: [
                {
                    description: "",
                    options: "بدون إفطار",
                    date_from: "",
                    date_to: "",
                    single_price_wd: "",
                    single_price_we: "",
                    dbl_price_wd: "",
                    dbl_price_we: "",
                    triple_price_wd: "",
                    triple_price_we: "",
                    quad_price_we: "",
                    quad_price_we: "",
                    display: 1
                }
            ],
        }),
        roomForm: {
            description: "",
            options: "بدون إفطار",
            date_from: "",
            date_to: "",
            single_price_wd: "",
            single_price_we: "",
            dbl_price_wd: "",
            dbl_price_we: "",
            triple_price_wd: "",
            triple_price_we: "",
            quad_price_we: "",
            quad_price_we: "",
            display: 1
        },
        hotelEdit: {},
        idPage: 'marketing_hotels',
        typePage: 'edit'
      }
    },
    methods: {
        updateHotel() {
            this.form.latitude = window.parseFloat($('#hotel_latitude').val())
            this.form.longitude = window.parseFloat($('#hotel_longitude').val())
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                if (response.status === 200) {
                    this.hotelEdit = response.data.data;
                    if (!this.hotelEdit.features.length) {
                        this.hotelEdit.features.push({value: ''})
                    }
                    this.hotelEdit.deletedGallery = []
                    this.hotelEdit.deletedFeatures = []
                    this.hotelEdit.deletedRooms = []

                    this.form.fill(this.hotelEdit)
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
        getHotelEdit(route) {
            axios.get(this.urlModel + '/' +  route.params.id).then(response => {
                if (response.status === 200) {
                    const hotel = response.data.hotel
                    if (hotel != null) {
                        this.hotelEdit = hotel
                        if (!hotel.features.length) {
                            this.hotelEdit.features.push({value: ''})
                        }
                        this.hotelEdit.deletedGallery = []
                        this.hotelEdit.deletedFeatures = []
                        this.hotelEdit.deletedRooms = []

                        this.form.reset()
                        $('#remove-location-hotel').click()

                        this.form.fill(this.hotelEdit)
                        if (this.form.latitude != null && this.form.longitude != null) {
                            $('.myMap #address').val('')
                        }
                        $('#hotel_latitude').val(this.form.latitude)
                        $('#hotel_longitude').val(this.form.longitude)
                    } else {
                        this.$router.push({name: 'marketing_hotels'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getHotelEdit(this.$route)
                }, 1000)
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_marketing_hotel')
            vm.$nextTick(() => {
                if (to.params.hotel) {
                    vm.hotelEdit = to.params.hotel
                    if (!vm.hotelEdit.features.length) {
                        vm.hotelEdit.features.push({value: ''})
                    }
                    vm.hotelEdit.deletedGallery = []
                    vm.hotelEdit.deletedFeatures = []
                    vm.hotelEdit.deletedRooms = []

                    vm.form.reset()
                    $('#remove-location-hotel').click()

                    vm.form.fill(vm.hotelEdit)
                    if (vm.form.latitude != null && vm.form.longitude != null) {
                        $('.myMap #address').val('')
                    }
                    $('#hotel_latitude').val(vm.form.latitude)
                    $('#hotel_longitude').val(vm.form.longitude)
                } else {
                    vm.getHotelEdit(to)
                }
            })
        })
    }
}
</script>
