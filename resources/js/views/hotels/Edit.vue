<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('sidebar.edit_hotel')"></header-page>
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
                                        :to="{name: 'hotel-profile', params: {id: hotelEdit.id, hotel: hotelEdit}}"
                                        :href="$domain_admin + '/hotel/profile/' + hotelEdit.id"
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
                                    <button
                                        type="submit"
                                        :disabled="form.busy"
                                        class="btn btn-success float-right"
                                    > {{ $t('global.update') }} </button>
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
    components: {
        HeaderPage,
        FormHotel
    },
    data() {
      return {
        urlModel: '/hotels',
        form: new Form({
            id: 0,
            name: "",
            address: "",
            rating: 0,
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
        }),
        hotelEdit: {},
        idPage: 'hotels',
        typePage: 'edit'
      }
    },
    methods: {
        updateHotel() {
            this.form.latitude = window.parseFloat($('#hotel_latitude').val())
            this.form.longitude = window.parseFloat($('#hotel_longitude').val())
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                console.log(response.data)
                if (response.status === 200) {
                    this.hotelEdit = response.data.data;
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
                        this.hotelEdit.deletedGallery = []
                        this.hotelEdit.deletedFeatures = []

                        this.form.reset()
                        $('#remove-location-hotel').click()

                        this.form.fill(this.hotelEdit)
                        if (this.form.latitude != null && this.form.longitude != null) {
                            $('.myMap #address').val('')
                        }
                        $('#hotel_latitude').val(this.form.latitude)
                        $('#hotel_longitude').val(this.form.longitude)
                    } else {
                        this.$router.push({name: 'hotels'})
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
            to.meta.title = vm.$t('sidebar.edit_hotel')
            if (to.params.hotel) {
                vm.hotelEdit = to.params.hotel
                vm.hotelEdit.deletedGallery = []
                vm.hotelEdit.deletedFeatures = []

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
    }
}
</script>
