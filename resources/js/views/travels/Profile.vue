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
        <header-page :title="$t('sidebar.travel_profile')"></header-page>
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
                                    :src="$domain + '/' + travelProfile.image"
                                    alt="Travel profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ travelProfile.name }}</h3>

                                <p class="text-muted text-center" v-if="travelProfile.type === 'external_fly' || travelProfile.type === 'external_visa'">{{ travelProfile.address_from }} - {{ travelProfile.address_to }}</p>



                                <ul class="list-group mb-3">
                                    <li class="list-group-item" v-if="travelProfile.type !== 'external_fly' && travelProfile.type !== 'external_visa'">
                                        <b> {{ $t('travels_table.offers_count') }} </b> <a class="float-right">{{ travelProfile.offers_count == null ? 0 : travelProfile.offers_count }}</a>
                                    </li>

                                    <li class="list-group-item">
                                        <b> {{ $t('travels_table.bookings_count') }} </b> <a class="float-right">{{ travelProfile.bookings_count == null ? 0 : travelProfile.bookings_count }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        <b> {{ $t('travels_table.type') }} </b> <a class="float-right"> {{ travelTypes[travelProfile.type] }} </a>
                                    </li>
                                </ul>

                                <!-- btn delete travel -->
                                <btn-delete classes="mt-1" :model="travelProfile" modelName="travel" @destroyRow="destroyRow(travelProfile.id)">
                                    {{ $t('travels_table.delete_travel') }}
                                </btn-delete>
                                <!-- ./btn delete travel -->


                                <!-- btn edit travel -->
                                <btn-edit classes="mr-2 mt-1" :inTable="false" :model="travelProfile" modelName="travel">
                                    {{ $t('travels_table.edit_travel') }}
                                </btn-edit>
                                <!-- ./btn edit travel -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="m-0 card-title"> {{ $t('travels_table.travel_info') }} </h3>
                            </div>
                            <!-- /.card-header -->

                            <div class="card-body box-profile">

                                <!-- show travel details in table travel -->
                                <ul class="list-group mb-3">

                                    <!-- info -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('travels_table.info') }}
                                        </b>
                                        <a class="float-right">
                                            <div class="view-text-editor" v-html="travelProfile.info" v-read-more:toggle="{limit: 100, textBtnRead: 'إقرأ المزيد', textBtnUnread: 'إقرأ أقل'}"></div>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- umrah_date -->
                                    <li class="list-group-item" v-if="travelProfile.type === 'umrah'">
                                        <b>
                                            {{ $t('travels_table.umrah_date') }}
                                        </b>
                                        <a class="float-right">
                                            {{ travelProfile.umrah_date }}
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- haram_distance -->
                                    <li class="list-group-item" v-if="travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage'">
                                        <b>
                                            {{ $t('travels_table.haram_distance') }}
                                        </b>
                                        <a class="float-right">
                                            {{ haramDistance[travelProfile.haram_distance] }}
                                        </a>
                                    </li>
                                    <!-- =========================================== -->

                                    <!-- haram_distance -->
                                    <li class="list-group-item" v-if="travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage'">
                                        <b>
                                            {{ $t('travels_table.itinerary') }}
                                        </b>
                                        <a class="float-right">
                                            {{ travelProfile.itinerary_1 }} -
                                            {{ travelProfile.itinerary_2 }} -
                                            {{ travelProfile.itinerary_3 }} -
                                            {{ travelProfile.itinerary_4 }}
                                            {{ travelProfile.itinerary_5 !== null ? ' - ' + travelProfile.itinerary_5 : '' }}
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- discount -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('travels_table.discount') }}
                                        </b>
                                        <a class="float-right">
                                            <span v-if="travelProfile.discount">{{ travelProfile.discount }}%</span>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->



                                     <!-- hotel -->
                                    <li class="list-group-item" v-if="travelProfile.type !== 'external_fly' && travelProfile.type !== 'external_visa'">
                                        <b>
                                            {{ $t('travels_table.hotel_id') }}
                                        </b>
                                        <a class="float-right">
                                            <router-link
                                                v-if="travelProfile.hotel !== null"
                                                :href="$domain_admin + '/hotel/profile/' + travelProfile.hotel_id"
                                                :to="{name: 'hotel-profile', params: {id: travelProfile.hotel_id, hotel: travelProfile.hotel}}"
                                            >
                                                {{ travelProfile.hotel.name + ' --- ' + travelProfile.hotel.address }}
                                            </router-link>
                                            <span class="badge badge-danger" v-else> {{ $t('global.hotel_is_deleted') }} - id:{{travelProfile.hotel_id}}</span>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->



                                     <!-- hotel 2 -->
                                    <li class="list-group-item" v-if="travelProfile.type !== 'external_fly' && travelProfile.type !== 'external_visa'">
                                        <b>
                                            {{ $t('travels_table.hotel_2_id') }}
                                        </b>
                                        <a class="float-right">
                                            <span v-if="travelProfile.hotel_2_id !== null">
                                                <router-link
                                                    v-if="travelProfile.hotel_2 !== null"
                                                    :href="$domain_admin + '/hotel/profile/' + travelProfile.hotel_2_id"
                                                    :to="{name: 'hotel-profile', params: {id: travelProfile.hotel_2_id, hotel: travelProfile.hotel_2}}"
                                                >
                                                    {{ travelProfile.hotel_2.name + ' --- ' + travelProfile.hotel_2.address }}
                                                </router-link>
                                                <span class="badge badge-danger" v-else> {{ $t('global.hotel_is_deleted') }} - id:{{travelProfile.hotel_2_id}}</span>
                                            </span>
                                            <span class="badge badge-info" v-else> لا يوجد فندق ثانى</span>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- travel_category -->
                                    <li class="list-group-item" v-if="travelProfile.type !== 'external_fly' && travelProfile.type !== 'external_visa'">
                                        <b>
                                            {{ $t('travels_table.travel_category_id') }}
                                        </b>
                                        <a class="float-right">
                                            <router-link
                                                v-if="travelProfile.travel_category !== null"
                                                :href="$domain_admin + '/travel_category/' + travelProfile.travel_category_id + '/edit'"
                                                :to="{name: 'edit-travel_category', params: {id: travelProfile.travel_category_id, travel_category: travelProfile.travel_category}}"
                                            >
                                                {{ travelProfile.travel_category.name }}
                                            </router-link>
                                            <span class="badge badge-danger" v-else> {{ $t('global.travel_category_is_deleted') }} - id:{{travelProfile.travel_category_id}}</span>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- favorite_company -->
                                    <li class="list-group-item" v-if="travelProfile.type !== 'external_fly' && travelProfile.type !== 'external_visa'">
                                        <b>
                                            {{ $t('travels_table.favorite_company') }}
                                        </b>
                                        <a class="float-right">
                                            {{travelProfile.favorite_company == 1 ? $t('travels_table.favorite_company_yes') : $t('travels_table.favorite_company_no')}}
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- display -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('datatable.display') }}
                                        </b>
                                        <a class="float-right">
                                            {{ travelProfile.display == 1 ? $t('global.visible') : $t('global.hidden') }}
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- Created by -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('travels_table.user_id') }}
                                        </b>
                                        <a class="float-right">
                                            <created-by :model="travelProfile"></created-by>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->


                                    <!-- Last modified -->
                                    <li class="list-group-item">
                                        <b>
                                            {{ $t('travels_table.updated_at') }}
                                        </b>
                                        <a class="float-right">
                                            <relative-date :date="travelProfile.updated_at"></relative-date>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->

                                    <!-- Created at -->
                                    <li class="list-group-item">
                                        <b> {{ $t('travels_table.created_at') }}</b> <a class="float-right">
                                            <relative-date :date="travelProfile.created_at"></relative-date>
                                        </a>
                                    </li>
                                    <!-- =========================================== -->

                                </ul> <!-- ./ list-group travel details -->

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
                                <li
                                    class="nav-item"
                                    v-if="travelProfile.type !== 'external_fly' && travelProfile.type !== 'external_visa'"
                                >
                                    <a
                                        @click="currentChildTable = 'gallery'"
                                        class="nav-link"
                                        :class="{'active': currentChildTable == 'gallery'}"
                                        href="#gallery" data-toggle="tab">
                                        {{ $t('travels_table.gallery') }}
                                    </a>
                                </li>
                                <li
                                    class="nav-item"
                                    v-if="travelProfile.type !== 'external_fly' && travelProfile.type !== 'external_visa'"
                                >
                                    <a
                                        @click="currentChildTable = 'offers'"
                                        class="nav-link"
                                        :class="{'active': currentChildTable == 'offers'}"
                                        href="#offers"
                                        data-toggle="tab">
                                        {{ $t('travels_table.travel_offers') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        @click="currentChildTable = 'bookings'"
                                        class="nav-link"
                                        :class="{'active': currentChildTable == 'bookings'}"
                                        href="#bookings"
                                        data-toggle="tab">
                                        {{ $t('sidebar.bookings') }}
                                    </a>
                                </li>

                            </ul>
                            <button class="btn btn-outline-secondary maximize-table d-none d-xl-block" @click="maximizeTable = !maximizeTable"><i class="fas" :class="maximizeTable == true ? 'fa-compress-arrows-alt' : 'fa-compress'"></i></button>
                        </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane" :class="{'active': currentChildTable == 'gallery'}" id="gallery">
                                        <div class="gallery-in-profile" v-if="(travelProfile.gallery != null && travelProfile.gallery.length > 0) && currentChildTable === 'gallery'">
                                            <div class="image" v-for="image in travelProfile.gallery" :key="image.id">
                                                <img :src="$domain + '/' + image.value">
                                            </div>
                                        </div>
                                        <div v-else class="alert alert-info alert-dismissible">
                                            <h5><i class="icon fas fa-info"></i>  {{ $t('global.no_gallery') }} !</h5>
                                            {{ $t('travels_table.empty_gallery_msg') }}
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" :class="{'active': currentChildTable == 'offers'}" id="offers">
                                        <div class="offers-in-profile" v-if="(travelProfile.offers_count != null && travelProfile.offers_count != 0) && currentChildTable === 'offers'">
                                            <div class="offer-wrapper" :data-id="offer.id" v-for="(offer, index) in travelProfile.offers" :key="offer.id">
                                                <div class="offer-title">
                                                    <h3 class="title">
                                                        {{ offer.name_offer }}
                                                    </h3>
                                                </div>
                                                <div class="offer">
                                                    <!-- list-group -->
                                                    <ul class="list-group mb-3">


                                                        <!-- id -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.offers.id') }}
                                                            </b>
                                                            <a class="float-right">
                                                                <span class="badge badge-success" style="font-size: 16px !important">
                                                                    {{ offer.id }}
                                                                </span>
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- info_offer -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.offers.info_offer') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.info_offer }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->


                                                        <!-- date_from -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.offers.date_from') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ formatDate(offer.date_from) }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- date_to -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.offers.date_to') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ formatDate(offer.date_to) }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- time_period -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.offers.time_period') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.time_period }}
                                                                {{ 11 > offer.time_period && offer.time_period > 2 ? $t('global.days') : $t('global.day') }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- hotel_days -->
                                                        <li class="list-group-item" v-if="travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage'">
                                                            <b>
                                                                {{ $t('travels_table.offers.hotel_days') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.hotel_days }}
                                                                {{ 11 > offer.hotel_days && offer.hotel_days > 2 ? $t('global.days') : $t('global.day') }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- hotel_2_days -->
                                                        <li class="list-group-item" v-if="travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage'">
                                                            <b>
                                                                {{ $t('travels_table.offers.hotel_2_days') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.hotel_2_days }}
                                                                {{ 11 > offer.hotel_2_days && offer.hotel_2_days > 2 ? $t('global.days') : $t('global.day') }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- stay_type -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ travelProfile.hotel_2_id != null ? $t('travels_table.offers.stay_type_if_2') : $t('travels_table.offers.stay_type') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.stay_type }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- stay_type_2 -->
                                                        <li class="list-group-item" v-if="travelProfile.hotel_2_id != null">
                                                            <b>
                                                                {{ $t('travels_table.offers.stay_type_2') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.stay_type_2 }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- transport -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.offers.transport') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ transports[offer.transport] }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- adults -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.offers.adults') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.adults }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- children -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.offers.children') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.children }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- child_price -->
                                                        <li class="list-group-item" v-if="travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage'">
                                                            <b>
                                                                {{ $t('travels_table.offers.child_price') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.child_price }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- baby_price -->
                                                        <li class="list-group-item" v-if="travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage'">
                                                            <b>
                                                                {{ $t('travels_table.offers.baby_price') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.baby_price }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- single_price -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage' ? $t('travels_table.offers.twin_price') : $t('travels_table.offers.single_price') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.single_price }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- twin_price -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage' ? $t('travels_table.offers.triple_price') : $t('travels_table.offers.twin_price') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.twin_price }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- triple_price -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ travelProfile.type === 'umrah' || travelProfile.type === 'pilgrimage' ? $t('travels_table.offers.forth_price') : $t('travels_table.offers.triple_price') }}
                                                            </b>
                                                            <a class="float-right">
                                                                {{ offer.triple_price }}
                                                            </a>
                                                        </li>
                                                        <!-- =========================================== -->

                                                        <!-- display -->
                                                        <li class="list-group-item">
                                                            <b>
                                                                {{ $t('travels_table.display') }}
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
                                            <h5><i class="icon fas fa-info"></i>  {{ $t('global.no_offers') }} !</h5>
                                            {{ $t('travels_table.empty_offers_msg') }}
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->
                                    <div class="tab-pane" :class="{'active': currentChildTable == 'bookings'}" id="bookings">
                                        <bookings :class="{'in-profile': !maximizeTable}" v-if="(travelProfile.bookings_count != null && travelProfile.bookings_count != 0) && currentChildTable === 'bookings'"></bookings>

                                        <div v-else class="alert alert-info alert-dismissible">
                                            <h5><i class="icon fas fa-info"></i>  {{ $t('global.no_bookings') }} !</h5>
                                            {{ $t('travels_table.empty_bookings_msg') }}
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
    </div>
</template>


<script>
import CreatedBy from "./../../components/dataTables/buttons/CreatedBy"
import BtnEdit from "./../../components/dataTables/buttons/EditRow"
import BtnDelete from "./../../components/dataTables/buttons/DeleteRow"

import Bookings from './../bookings/Index'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessagesProfiles from "./../../mixins/MixinChangeLocaleMessagesProfiles"
import mixinDeleteRow from "./../../mixins/mixinDeleteRow"

export default {
    mixins: [
        MixinChangeLocaleMessagesProfiles,
        mixinDeleteRow
    ],
    components: {
        Bookings,
        HeaderPage,
        CreatedBy,
        BtnDelete,
        BtnEdit,
    },
    name: 'travel-profile',
    data() {
        return {
            urlGetDataTable: '/travels',
            idPage: 'travels',
            maximizeTable: false,
            currentChildTable: 'gallery', // gallery, offers, bookings
            travelProfile: {
                id: "",
                name: "",
                address_from: "",
                info: "",
                type: "other",
                umrah_date: "",
                haram_distance: 0,
                discount: "",
                favorite_company: 0,
                image: "",
                gallery: [],
                hotel_id: "",
                hotel_2_id: "",
                travel_category_id: "",
                display: 1,
                offers_count: 0,
                offers: [],
                hotel: {
                    name: '',
                    address: ''
                },
                hotel_2: {
                    name: '',
                    address: ''
                },
                user: {
                    name: ''
                },
                travel_category: {
                    name: ''
                },
            },
            travelTypes: {
                internal: 'سياحة داخلية',
                external_fly: 'عروض الطيران',
                external_visa: 'عروض التأشيرات',
                pilgrimage: 'حج',
                umrah: 'عمرة',
            },
            haramDistance: {
                0: 'بعيد',
                1: 'قريب',
            },
            transports: {
                0: 'بدون انتقالات',
                1: 'شامل الانتقالات'
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
        getTravelProfile(route) {
            axios.get(this.urlGetDataTable + '/' + route.params.id).then(response => {
                if (response.status === 200) {
                    const travel = response.data.travel
                    if (travel != null) {
                        this.travelProfile = travel
                        if (travel.type === 'external_fly' || travel.type === 'external_visa') {
                            this.currentChildTable = 'bookings'
                        }
                    } else {
                        this.$router.push({name: 'travels'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelProfile(this.$route)
                }, 500)
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


        goToOffer(id) {
            this.currentChildTable = 'offers'
            setTimeout(() => {
                const offer = $('.offers-in-profile .offer-wrapper').filter(`[data-id="${id}"]`)
                offer.addClass('mark-offer')
                setTimeout(() => {
                    offer.removeClass('mark-offer')
                }, 2000)
                $('html').animate({
                    scrollTop: offer.offset().top - 70
                }, 400)
            }, 100)
        },


        eventsQuery() {
            const self = this
            $(document).on('click', '.btn-goto-offer', function () {
                const offerId = JSON.parse($(this).attr('data-params')).offer_id
                self.goToOffer(offerId)
            });
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.travel_profile')
            vm.$nextTick(() => {
                if (to.params.travel) {
                    let travel = to.params.travel
                    if (travel.type === 'external_fly' || travel.type === 'external_visa') {
                        vm.currentChildTable = 'bookings'
                    }
                    if (typeof travel.gallery == 'string') {
                        if (travel.gallery !== null && travel.gallery != '') {
                            let gallery = travel.gallery.split(',')
                            let galleryArr = []
                            gallery.forEach(image => {
                                galleryArr.push({id:  Math.floor(Math.random() * 10000), value: image})
                            })
                            travel.gallery = galleryArr
                        } else {
                            travel.gallery = []
                        }
                    }
                    vm.travelProfile = travel
                } else {
                    vm.getTravelProfile(to)
                }

                if (to.params.offer_id) {
                    vm.goToOffer(to.params.offer_id)
                }
            })



            vm.eventsQuery()
        })
    },
}
</script>
