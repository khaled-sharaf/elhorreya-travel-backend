<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">

                <!-- name -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.name') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.name"
                        type="text"
                        :placeholder="$t('hotels_table.name')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                    >
                    <has-error :form="form" field="name"></has-error>
                </div>


                <!-- address -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.address') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.address"
                        type="text"
                        :placeholder="$t('hotels_table.address')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('address') }"
                    >
                    <has-error :form="form" field="address"></has-error>
                </div>

                <!-- <div class="row">
                    <div class="col-sm-8">
                    </div>
                    <div class="col-sm-4">
                        address suggested
                        <div class="form-group">
                            <label> {{ $t('hotels_table.address_suggested') }}</label>
                            <select v-model="currentAddressSuggested" class="custom-select">
                                <option value=""></option>
                                <option v-for="address in addressesSuggested" :key="address" :value="address" v-text="address"></option>
                            </select>
                        </div>
                    </div>
                </div> -->


                <!-- stars hotel -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.stars') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.stars"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('stars') }"
                        >
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="7">7</option>
                    </select>
                    <has-error :form="form" field="stars"></has-error>
                </div>


                <!-- latitude -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.latitude') }} </label>
                    <!-- v-model="form.latitude" -->
                    <input
                        type="text"
                        :placeholder="$t('hotels_table.latitude')"
                        id="hotel_latitude"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('latitude') }"
                    >
                    <has-error :form="form" field="latitude"></has-error>
                </div>

                <!-- longitude -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.longitude') }} </label>
                    <!-- v-model="form.longitude" -->
                    <input
                        type="text"
                        :placeholder="$t('hotels_table.longitude')"
                        id="hotel_longitude"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('longitude') }"
                    >
                    <has-error :form="form" field="longitude"></has-error>
                    <div class="">
                        <button type="button" class="btn btn-danger btn-sm mt-1" id="remove-location-hotel"> {{ $t('hotels_table.remove_location') }} </button>
                    </div>
                </div>


                <!-- show latitude and longitude in google map -->
                <div class="form-group">
                    <div class="myMap" :data-lat="typeForm == 'create' || form.latitude == null ? '30.0444196' : form.latitude" :data-long="typeForm == 'create' || form.longitude == null ? '31.23571160000006' : form.longitude">
                        <!-- <h5>ابحث عن مكان الشركة ثم حرك العلامة الحمراء إلى مكان الشركة بشكل دقيق</h5> -->
                        <h5 class="info-map"> {{ $t('hotels_table.msg_location_map') }}</h5>
                        <div id="floating-panel">
                            <input class="form-control" id="address" type="text" value="مصر، القاهرة" :placeholder="$t('datatable.search')">
                            <span class="error-location"> {{ $t('hotels_table.error_location') }} </span>
                        </div>
                        <div id="map"></div>
                    </div>
                </div>


                <!-- hotel info -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.info') }} <span class="field-required"></span></label>
                    <vue-editor
                        v-model="form.info"
                        :class="{ 'is-invalid': form.errors.has('info') }"
                    ></vue-editor>
                    <span class="help-error-form" v-if="form.errors.has('info')" v-text="form.errors.get('info')"></span>
                </div>


                <!-- dispaly hotel -->
                <div class="form-group">
                    <label> {{ $t('datatable.display') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.display"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('display') }"
                        >
                        <option value="1"> {{ $t('global.visible') }} </option>
                        <option value="0"> {{ $t('global.hidden') }} </option>
                    </select>
                    <has-error :form="form" field="display"></has-error>
                </div>


                <!-- image -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.image') }} <span class="field-required"></span></label>
                    <div class="row justify-content-center">
                        <div class="col-md-6">

                            <upload-image
                                propertyName="image"
                                :form="form"
                            ></upload-image>

                        </div>
                    </div>
                </div>

                <!-- gallery -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.gallery') }} </label>

                    <upload-image
                        type="multiple"
                        propertyName="gallery"
                        propertyDeletedName="deletedGallery"
                        :form="form"
                    ></upload-image>

                </div> <!-- ./gallery -->


                <!-- features -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.features') }} </label>
                    <div class="wrapper-details-product">

                        <div class="form-row align-items-center form-data" v-for="(item, index) in form.features" :key="index">
                            <div class="col-sm-11 col-md-11 col-details">
                                <input
                                    type="text"
                                    v-model="form.features[index].value"
                                    :placeholder="$t('hotels_table.feature_name')"
                                    class="form-control"
                                >
                            </div>
                            <div class="col-sm-1 col-md-1 col-details">
                                <div class="action">
                                    <span class="plus-more-details btn btn-danger" @click="removeFeature(index)" v-if="form.features.length > 1 && (index + 1) !== form.features.length">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    <span class="plus-more-details btn btn-success" @click="addNewFeature()" v-else>
                                        <i class="fa fa-plus"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!-- ./features -->



                <!-- rooms -->
                <div class="form-group">
                    <div class="wrapper-internal-form form-offers">
                        <label class="title-internal-form"> {{ $t('marketing_hotels_table.hotel_rooms') }} (<span> {{ $t('marketing_hotels_table.hotel_rooms_msg_form') }} </span>) </label>

                        <div
                            v-for="(offer, index) in form.rooms" :key="index"
                            class="form-row"
                            :class="{'is-invalid': inValidFormRoom(index)}"
                        >

                            <div class="form-group col-12">
                                <div class="offer-title">
                                    <h3 class="title">
                                        العرض
                                        {{ counterText[index] }}
                                    </h3>
                                </div>
                            </div>

                            <!-- description -->
                            <div class="form-group col-lg-12">
                                <textarea
                                    v-model="offer.description"
                                    type="text"
                                    :placeholder="$t('marketing_hotels_table.rooms.description')"
                                    class="form-control textarea-form"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.description`) }"
                                ></textarea>
                                <has-error :form="form" :field="`rooms.${index}.description`"></has-error>
                            </div>
                            <!-- ./description -->


                            <div class="form-group col-12">
                                <label class="internal-label"> {{ $t('marketing_hotels_table.rooms.date') }} </label>
                            </div>

                            <!-- date_from -->
                            <div class="form-group col-lg-6 required">
                                <date-picker
                                    v-model="offer.date_from"
                                    :placeholder="$t('marketing_hotels_table.rooms.date_from')"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.date_from`) }"
                                    class="offer-date date-from"
                                    width="100%"
                                    :lang="langDates"
                                    value-type="format"
                                ></date-picker>
                                <has-error :form="form" :field="`rooms.${index}.date_from`"></has-error>
                            </div>
                            <!-- ./date_from -->


                            <!-- date_to -->
                            <div class="form-group col-lg-6 required">
                                <date-picker
                                    v-model="offer.date_to"
                                    :placeholder="$t('marketing_hotels_table.rooms.date_to')"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.date_to`) }"
                                    class="offer-date date-to"
                                    width="100%"
                                    :lang="langDates"
                                    value-type="format"
                                ></date-picker>
                                <has-error :form="form" :field="`rooms.${index}.date_to`"></has-error>
                            </div>
                            <!-- ./date_to -->



                            <div class="form-group col-12">
                                <label class="internal-label">
                                    سعر
                                    weekday
                                </label>
                            </div>

                            <!-- single_price_wd -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="offer.single_price_wd"
                                    type="number"
                                    :placeholder="$t('marketing_hotels_table.rooms.single_price_wd')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.single_price_wd`) }"
                                >
                                <has-error :form="form" :field="`rooms.${index}.single_price_wd`"></has-error>
                            </div>
                            <!-- ./single_price_wd -->

                            <!-- dbl_price_wd -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="offer.dbl_price_wd"
                                    type="number"
                                    :placeholder="$t('marketing_hotels_table.rooms.dbl_price_wd')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.dbl_price_wd`) }"
                                >
                                <has-error :form="form" :field="`rooms.${index}.dbl_price_wd`"></has-error>
                            </div>
                            <!-- ./dbl_price_wd -->

                            <!-- triple_price_wd -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="offer.triple_price_wd"
                                    type="number"
                                    :placeholder="$t('marketing_hotels_table.rooms.triple_price_wd')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.triple_price_wd`) }"
                                >
                                <has-error :form="form" :field="`rooms.${index}.triple_price_wd`"></has-error>
                            </div>
                            <!-- ./triple_price_wd -->

                            <!-- quad_price_wd -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="offer.quad_price_wd"
                                    type="number"
                                    :placeholder="$t('marketing_hotels_table.rooms.quad_price_wd')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.quad_price_wd`) }"
                                >
                                <has-error :form="form" :field="`rooms.${index}.quad_price_wd`"></has-error>
                            </div>
                            <!-- ./quad_price_wd -->


                            <div class="form-group col-12">
                                <label class="internal-label">
                                    سعر
                                    weekend
                                </label>
                            </div>


                             <!-- single_price_we -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="offer.single_price_we"
                                    type="number"
                                    :placeholder="$t('marketing_hotels_table.rooms.single_price_we')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.single_price_we`) }"
                                >
                                <has-error :form="form" :field="`rooms.${index}.single_price_we`"></has-error>
                            </div>
                            <!-- ./single_price_we -->

                            <!-- dbl_price_we -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="offer.dbl_price_we"
                                    type="number"
                                    :placeholder="$t('marketing_hotels_table.rooms.dbl_price_we')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.dbl_price_we`) }"
                                >
                                <has-error :form="form" :field="`rooms.${index}.dbl_price_we`"></has-error>
                            </div>
                            <!-- ./dbl_price_we -->

                            <!-- triple_price_we -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="offer.triple_price_we"
                                    type="number"
                                    :placeholder="$t('marketing_hotels_table.rooms.triple_price_we')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.triple_price_we`) }"
                                >
                                <has-error :form="form" :field="`rooms.${index}.triple_price_we`"></has-error>
                            </div>
                            <!-- ./triple_price_we -->

                            <!-- quad_price_we -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="offer.quad_price_we"
                                    type="number"
                                    :placeholder="$t('marketing_hotels_table.rooms.quad_price_we')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.quad_price_we`) }"
                                >
                                <has-error :form="form" :field="`rooms.${index}.quad_price_we`"></has-error>
                            </div>
                            <!-- ./quad_price_we -->


                            <!-- options -->
                            <div class="form-group col-lg-6 required">
                                <select
                                    v-model="offer.options"
                                    class="custom-select"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.options`) }"
                                    >
                                    <option v-for="type in stayTypes" :key="type.value" :value="type.value" v-text="type.value"></option>
                                </select>
                                <has-error :form="form" :field="`rooms.${index}.options`"></has-error>
                            </div>
                            <!-- ./options -->


                            <!-- display -->
                            <div class="form-group col-lg-6 required">
                                <select
                                    v-model="offer.display"
                                    class="custom-select"
                                    :class="{ 'is-invalid': form.errors.has(`rooms.${index}.display`) }"
                                    >
                                    <option value="1"> {{ $t('global.visible') }} </option>
                                    <option value="0"> {{ $t('global.hidden') }} </option>
                                </select>
                                <has-error :form="form" :field="`rooms.${index}.display`"></has-error>
                            </div>
                            <!-- ./display -->

                            <!-- btn remove offer -->
                            <div class="form-group col-12">
                                <button
                                    type="button"
                                    class="btn btn-danger add-new-offer"
                                    @click="removeRoom(index)"
                                    v-if="form.rooms.length > 1"
                                >
                                    {{ $t('travels_table.offers.delete_offer') }}
                                </button>
                            </div>
                            <!-- ./btn remove offer -->
                        </div><!-- ./form-row -->

                    </div><!-- ./wrapper-internal-form -->

                    <!-- btn add room -->
                    <button
                        type="button"
                        class="btn btn-success add-new-offer float-left"
                        @click="addRoom()"
                    >
                        {{ $t('travels_table.offers.add_new_offer') }}
                    </button>

                    <!-- ./btn add room -->

                </div><!-- ./rooms -->

            </div><!-- ./col-md -->
        </div><!-- ./row -->
    </div>
</template>


<script>
import UploadImage from './../../components/form/UploadImage'

export default {
    props: ['form', 'typeForm'],
    components: {
        UploadImage
    },
    data() {
        return {
            stayTypes: [
                {value: 'بدون إفطار'},
                {value: 'شامل إفطار'},
                {value: 'نصف إقامة'},
                {value: 'شامل جميع الوجبات والمشروبات'}
            ],

            langDates: {
                days: ['حد', 'اثنين', 'ثلاثاء', 'أربعاء', 'خميس', 'جمعة', 'سبت'],
                months: ['يناير', 'فبراير', 'مارس', 'إبريل', 'مايو', 'يوينو', 'يوليو', 'أغسطس', 'سبتمبر', 'أكتوبر', 'نوفمبر', 'ديسمبر']
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
            ],
        }
    },


    methods: {
        addNewFeature() {
            this.form.features.push({value: ''})
        },
        removeFeature(index) {
            if (this.typeForm == 'edit') {
                if (this.form.features[index].id) {
                    this.form.deletedFeatures.push(this.form.features[index])
                }
            }
            this.form.features.splice(index, 1)
        },
        showGoogleMapHotel() {
            var scriptMap = document.createElement('script');
            document.body.appendChild(scriptMap);
            scriptMap.id = 'scriptMapHotel';
            scriptMap.setAttribute('async', true);
            scriptMap.setAttribute('defer', true);
            scriptMap.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyADsFcbM6g-A_nUwh41pFn9EgDdlRC6lGY&language=ar&region=EG&callback=initMapHotel');
        },

        inValidFormRoom(index) {
            const errors = {...this.form.errors.errors}
            const indexes = []
            for (let error in errors) {
                if (error.indexOf('rooms.') != -1) {
                    const indexNumber = error.indexOf('.')
                    if (indexNumber === 5) {
                        if (index < 10) {
                            if (parseInt(error[indexNumber + 1]) === index) {
                                indexes.push(index)
                            }
                        } else {
                            if (parseInt(error[indexNumber + 1] + error[indexNumber + 2]) === index) {
                                indexes.push(index)
                            }
                        }
                    }
                }
            }
            return indexes.indexOf(index) != -1
        },

        addRoom() {
            this.form.rooms.push(
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
            )
            setTimeout(() => {
                const lastForm = $('.form-offers .form-row:last-child')
                $('html').animate({
                    scrollTop: lastForm.offset().top - 70
                })
            }, 100)
        },

        removeRoom(index) {
            if (this.typeForm == 'edit') {
                if (this.form.rooms[index].id) {
                    this.form.deletedRooms.push(this.form.rooms[index].id)
                }
            }
            this.form.rooms.splice(index, 1)
        },

    },
    mounted() {
        // this.getHotelsSelect().then(() => {
        //     this.getTravelCategoriesSelect()
        // })
        if (this.typeForm == 'edit') {
            const getData = setInterval(() => {
                if (this.form.name != '') {
                    this.showGoogleMapHotel()
                    clearInterval(getData)
                }
            }, 500)
        } else if (this.typeForm == 'create') {
            this.showGoogleMapHotel()
        }
    }
}
</script>
