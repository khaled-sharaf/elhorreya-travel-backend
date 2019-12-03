<style lang="scss">

    .col-table-maximize {
        order: 1;
        margin-bottom: 50px;
    }
    .col-sidebar {
        order: 2;
    }

</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('sidebar.marketing_hotel_profile')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid profile-wrapper">
                <div class="row mt-3 justify-content-lg-center">
                    <div :class="maximizeTable == true ? 'col-sidebar col-lg-8' : 'col-md-12 col-xl-4'">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                <img class="profile-user-img full-image-profile"
                                    :src="$domain + '/' + hotelProfile.image"
                                    alt="Hotel profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ hotelProfile.name }}</h3>

                                <p class="text-muted text-center">{{ hotelProfile.address }}</p>

                                <ul class="list-group mb-3">
                                    <!-- <li class="list-group-item">
                                        <b> {{ $t('hotels_table.rooms_count') }} </b> <a class="float-right">{{ hotelProfile.rooms_count == null ? 0 : hotelProfile.rooms_count }}</a>
                                    </li> -->
                                </ul>

                                <!-- btn delete hotel -->
                                <btn-delete classes="mt-1" :model="hotelProfile" modelName="marketing_hotel" @destroyRow="destroyRow(hotelProfile.id)">
                                    {{ $t('hotels_table.delete_hotel') }}
                                </btn-delete>
                                <!-- ./btn delete hotel -->


                                <!-- btn edit hotel -->
                                <btn-edit classes="mr-2 mt-1" :inTable="false" :model="hotelProfile" modelName="marketing_hotel">
                                    {{ $t('hotels_table.edit_hotel') }}
                                </btn-edit>
                                <!-- ./btn edit hotel -->


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="m-0 card-title"> {{ $t('hotels_table.hotel_info') }} </h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body box-profile">

                                <!-- show hotel details in table hotel -->
                                <ul class="list-group mb-3">

                                    <!-- stars -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('hotels_table.stars') }}
                                        </b>
                                        <a class="float-right">
                                            {{hotelProfile.stars}}
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- Location -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('hotels_table.location_map') }}
                                        </b>
                                        <a class="float-right">
                                            <button
                                                v-if="hotelProfile.longitude != null && hotelProfile.latitude != null"
                                                class="btn btn-outline-secondary btn-sm"
                                                id="show_map_location"
                                                :data-long="hotelProfile.longitude"
                                                :data-lat="hotelProfile.latitude"
                                                :data-location-title="hotelProfile.name">

                                            {{ $t('global.show_map') }}
                                            </button>
                                            <span v-else>{{ $t('global.no_location') }}</span>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- info -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('hotels_table.info') }}
                                        </b>
                                        <a class="float-right">
                                            <div class="view-text-editor" v-html="hotelProfile.info" v-read-more:toggle="{limit: 100, textBtnRead: 'إقرأ المزيد', textBtnUnread: 'إقرأ أقل'}"></div>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->

                                    <!-- display -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('datatable.display') }}
                                        </b>
                                        <a class="float-right">
                                            {{hotelProfile.display == 1 ? $t('global.visible') : $t('global.hidden')}}
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- Created by -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('hotels_table.user_id') }}
                                        </b>
                                        <a class="float-right">
                                            <created-by :model="hotelProfile"></created-by>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- Last modified -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('hotels_table.updated_at') }}
                                        </b>
                                        <a class="float-right">
                                            <relative-date :date="hotelProfile.updated_at"></relative-date>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->

                                    <!-- Created at -->
                                    <li class="list-group-item">
                                        <b> {{ $t('hotels_table.created_at') }}</b> <a class="float-right">
                                            <relative-date :date="hotelProfile.created_at"></relative-date>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->

                                </ul> <!-- ./ list-group hotel details -->

                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                         <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="m-0 card-title"> {{ $t('hotels_table.features') }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">

                                <!-- show hotel features -->

                                <table class="table table-striped table-bordered table-show-details" v-if="hotelProfile.features.length > 0">
                                    <tbody>
                                        <tr v-for="feature in hotelProfile.features" :key="feature.id">
                                            <td>{{ feature.value }}</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div v-else class="alert alert-info alert-dismissible">
                                    <h5><i class="icon fas fa-info"></i> {{ $t('global.no_hotel_features') }} !</h5>
                                    {{ $t('hotels_table.empty_features_msg') }}
                                </div>


                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                    <div :class="maximizeTable == true ? 'col-table-maximize col-12' : 'col-md-12 col-xl-8'">
                        <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills" style="display: inline-flex;">
                                <li class="nav-item"><a @click="currentChildTable = 'gallery'" class="nav-link active" href="#gallery" data-toggle="tab"> {{ $t('hotels_table.gallery') }} </a></li>
                                <li class="nav-item"><a @click="currentChildTable = 'rooms'" class="nav-link" href="#rooms" data-toggle="tab"> {{ $t('global.the_offers') }} </a></li>
                            </ul>
                            <button class="btn btn-outline-secondary maximize-table d-none d-xl-block" @click="maximizeTable = !maximizeTable"><i class="fas" :class="maximizeTable == true ? 'fa-compress-arrows-alt' : 'fa-compress'"></i></button>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                            <div class="tab-pane active" id="gallery">
                                <div class="gallery-in-profile" v-if="(hotelProfile.gallery != null && hotelProfile.gallery.length > 0) && currentChildTable === 'gallery'">
                                    <div class="image" v-for="image in hotelProfile.gallery" :key="image.id">
                                        <img :src="$domain + '/' + image.value">
                                    </div>
                                </div>
                                <div v-else class="alert alert-info alert-dismissible">
                                    <h5><i class="icon fas fa-info"></i>  {{ $t('global.no_gallery') }} !</h5>
                                     {{ $t('hotels_table.empty_gallery_msg') }}
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="rooms">
                               <div class="offers-in-profile" v-if="(hotelProfile.rooms !== null) && currentChildTable === 'rooms'">
                                   <div class="offer-wrapper" :data-id="offer.id" v-for="(offer, index) in hotelProfile.rooms" :key="offer.id">
                                        <div class="offer-title">
                                            <h3 class="title">
                                                العرض
                                                {{ counterText[index] }}
                                            </h3>
                                        </div>
                                        <div class="offer">
                                            <!-- list-group -->
                                            <ul class="list-group mb-3">

                                                <!-- description -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.description') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.description }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->


                                                <!-- options -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.options') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.options }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->


                                                <!-- date_from -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.date_from') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ formatDate(offer.date_from) }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <!-- date_to -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.date_to') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ formatDate(offer.date_to) }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <h3 class="title-side">
                                                    سعر
                                                    weekday
                                                </h3>


                                                <!-- single_price_wd -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.single_price_wd') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.single_price_wd }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <!-- dbl_price_wd -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.dbl_price_wd') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.dbl_price_wd }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <!-- triple_price_wd -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.triple_price_wd') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.triple_price_wd }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <!-- quad_price_wd -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.quad_price_wd') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.quad_price_wd }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->


                                                <h3 class="title-side">
                                                    سعر
                                                    weekend
                                                </h3>

                                                <!-- single_price_we -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.single_price_we') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.single_price_we }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <!-- dbl_price_we -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.dbl_price_we') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.dbl_price_we }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <!-- triple_price_we -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.triple_price_we') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.triple_price_we }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <!-- quad_price_we -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.rooms.quad_price_we') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.quad_price_we }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->

                                                <br>


                                                <!-- display -->
                                                <li class="list-group-item">
                                                    <b>
                                                        {{ $t('marketing_hotels_table.display') }}
                                                    </b>
                                                    <a class="float-right">
                                                        {{ offer.display == 1 ? $t('global.visible') : $t('global.hidden') }}
                                                    </a>
                                                </li>
                                                <!-- =========================================== -->


                                            </ul><!-- ./list-group -->
                                        </div><!-- ./offer -->
                                    </div><!-- ./offer-wrapper -->

                               </div><!-- ./offer-in-profile -->

                                <div v-else class="alert alert-info alert-dismissible">
                                    <h5><i class="icon fas fa-info"></i>  {{ $t('marketing_hotels_table.no_offers') }} !</h5>
                                     {{ $t('marketing_hotels_table.empty_offers_msg') }}
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                        </div>
                        <!-- /.nav-tabs-custom -->
                    </div>
                    <!-- /.col -->
                    </div>
                    <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>

        <modal-location></modal-location>
    </div>
</template>


<script>
import CreatedBy from "./../../components/dataTables/buttons/CreatedBy"
import BtnEdit from "./../../components/dataTables/buttons/EditRow"
import BtnDelete from "./../../components/dataTables/buttons/DeleteRow"

import ModalLocation from './ModalLocation'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessagesProfiles from "./../../mixins/MixinChangeLocaleMessagesProfiles"
import mixinDeleteRow from "./../../mixins/mixinDeleteRow"

export default {
    mixins: [
        MixinChangeLocaleMessagesProfiles,
        mixinDeleteRow
    ],
    components: {
        HeaderPage,
        ModalLocation,
        CreatedBy,
        BtnEdit,
        BtnDelete,
    },
    name: 'marketing_hotel-profile',
    data() {
      return {
          urlGetDataTable: '/marketing_hotels',
          idPage: 'marketing_hotels',
          maximizeTable: false,
          currentChildTable: 'gallery',
          hotelProfile: {
            id: 0,
            name: "",
            address: "",
            stars: 0,
            info: "",
            latitude: "",
            longitude: "",
            image: "images/hotels/hotel-default-avatar.jpg",
            gallery: [],
            features: [
                {value: ''}
            ],
            display: 1,
            user_id: 1,
            updated_at: null,
            created_at: null,
            user: {
                name: ''
            }
          },

          counterText: [
            'الأول',
            'الثانى',
            'الثالث',
            'الرابع',
            'الخامس',
            'السادس',
            'السابع',
            'الثامن',
            'التاسع',
            'العاشر',
            'الحادى عشر',
            'الثانى عشر',
            'الثالث عشر',
            'الرابع عشر',
            'الخامس عشر',
        ]
      }
    },
    methods: {
        showMap(lat, long) {
            if (lat != null && long != null) {
                var my_map_modal = $('#my_map_modal');
                my_map_modal.attr('data-lat', lat).attr('data-long', long);
                var scriptMap = document.createElement('script');
                document.body.appendChild(scriptMap);
                scriptMap.id = 'myScriptMap';
                scriptMap.setAttribute('async', true);
                scriptMap.setAttribute('defer', true);
                scriptMap.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyADsFcbM6g-A_nUwh41pFn9EgDdlRC6lGY&language=ar&region=EG&callback=initMap');
            }
        },
        eventBtnsClick() {
            let self = this;
            let oldText = $('#locationTitle').text()
        // show location in google map
            $(document).on("click", "#show_map_location", function(e) {
                e.preventDefault();
                let lat = $(this).attr('data-lat'),
                    long = $(this).attr('data-long'),
                    title = $(this).attr('data-location-title');
                if ( (typeof lat != 'undefined' && lat != '' && lat != null) &&
                    (typeof long != 'undefined' && long != '' && long != null) ) {
                    $('#locationTitle').html(oldText + ' ' + `<span style="color: #3498db">${title}</span>`);
                    $('#myScriptMap').remove();
                    self.showMap(lat, long);
                    $('#modal_location_hotel').modal('show');
                }
            });
        },
        getHotelProfile(route) {
            axios.get(this.urlGetDataTable + '/' + route.params.id).then(response => {
                if (response.status === 200) {
                    const hotel = response.data.hotel
                    if (hotel != null) {
                        this.hotelProfile = hotel
                    } else {
                        this.$router.push({name: 'hotels'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getHotelProfile(this.$route)
                }, 1000)
            })
        },

        formatDate(date) {
            date = new Date(date)
            const monthNames = this.$i18n.locale == 'ar' ?
                ["يناير", "فبراير", "مارس", "إبريل", "مايو", "يونيو", "يوليو", "أغسطس", "سبتمبر", "أكتوبر", "نوفمبر", "ديسمبر"] :
                ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]
            const day = date.getDate();
            const monthIndex = date.getMonth();
            const year = date.getFullYear();
            return day + ' ' + monthNames[monthIndex] + ' ' + year;
        },

    },

    mounted() {
        this.eventBtnsClick()
    },

    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.marketing_hotel_profile')
            vm.$nextTick(() => {
                if (to.params.hotel) {
                    let hotel = to.params.hotel
                    if (typeof hotel.gallery == 'string') {
                        if (hotel.gallery !== null && hotel.gallery != '') {
                            let gallery = hotel.gallery.split(',')
                            let galleryArr = []
                            gallery.forEach(image => {
                                galleryArr.push({id:  Math.floor(Math.random() * 10000), value: image})
                            })
                            hotel.gallery = galleryArr
                        } else {
                            hotel.gallery = []
                        }
                    }

                    if (typeof hotel.features == 'string') {
                        if (hotel.features !== null && hotel.features != '') {
                            let features = hotel.features.split(',')
                            let featuresArr = []
                            features.forEach(feature => {
                                featuresArr.push({id:  Math.floor(Math.random() * 10000), value: feature})
                            })
                            hotel.features = featuresArr
                        } else {
                            hotel.features = []
                        }
                    }

                    vm.hotelProfile = hotel
                } else {
                    vm.getHotelProfile(to)
                }
            })
        })
    }
}
</script>
