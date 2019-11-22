<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">

                <!-- name -->
                <div class="form-group">
                    <label> {{ $t('travels_table.name') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.name"
                        type="text"
                        :placeholder="$t('travels_table.name')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                    >
                    <has-error :form="form" field="name"></has-error>
                </div>


                <!-- type travel -->
                <div class="form-group">
                    <label> {{ $t('travels_table.type') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.type"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('type') }"
                        :disabled="typeForm === 'edit'"
                    >
                        <option v-for="type in travelTypes" :key="type.value" :value="type.value" v-text="type.label"></option>
                    </select>
                    <has-error :form="form" field="type"></has-error>
                </div>


                <!-- umrah date -->
                <div class="form-group" v-if="form.type === 'umrah'">
                    <label> {{ $t('travels_table.umrah_date') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.umrah_date"
                        type="text"
                        :placeholder="$t('travels_table.umrah_date')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('umrah_date') }"
                    >
                    <has-error :form="form" field="umrah_date"></has-error>
                </div>


                <!-- haram distance -->
                <div class="form-group" v-if="form.type === 'umrah' || form.type === 'pilgrimage'">
                    <label> {{ $t('travels_table.haram_distance') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.haram_distance"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('haram_distance') }"
                        >
                        <option v-for="distance in haramDistance" :key="distance.value" :value="distance.value" v-text="distance.label"></option>
                    </select>
                    <has-error :form="form" field="haram_distance"></has-error>
                </div>


                <!-- address_from -->
                <div class="form-group" v-if="form.type !== 'umrah' && form.type !== 'pilgrimage'">
                    <label> {{ $t('travels_table.address_from') }}</label>
                    <input
                        v-model="form.address_from"
                        type="text"
                        :placeholder="$t('travels_table.address_from')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('address_from') }"
                    >
                    <has-error :form="form" field="address_from"></has-error>
                </div>

                <div class="form-group itinerary" v-else>
                    <label> {{ $t('travels_table.itinerary') }}</label>
                    <div class="row">

                        <div class="form-group col-12 col-sm-4">
                            <input
                                v-model="form.itinerary_1"
                                type="text"
                                :placeholder="$t('travels_table.city')"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('itinerary_1') }"
                            >
                            <has-error :form="form" field="itinerary_1"></has-error>
                        </div>

                        <div class="form-group col-12 col-sm-4">
                            <input
                                v-model="form.itinerary_2"
                                type="text"
                                :placeholder="$t('travels_table.city')"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('itinerary_2') }"
                            >
                            <has-error :form="form" field="itinerary_2"></has-error>
                        </div>

                        <div class="form-group col-12 col-sm-4">
                            <input
                                v-model="form.itinerary_3"
                                type="text"
                                :placeholder="$t('travels_table.city')"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('itinerary_3') }"
                            >
                            <has-error :form="form" field="itinerary_3"></has-error>
                        </div>

                        <div class="form-group col-12 col-sm-4">
                            <input
                                v-model="form.itinerary_4"
                                type="text"
                                :placeholder="$t('travels_table.city')"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('itinerary_4') }"
                            >
                            <has-error :form="form" field="itinerary_4"></has-error>
                        </div>

                        <div class="form-group col-12 col-sm-4">
                            <input
                                v-model="form.itinerary_5"
                                type="text"
                                :placeholder="$t('travels_table.city')"
                                class="form-control"
                                :class="{ 'is-invalid': form.errors.has('itinerary_5') }"
                            >
                            <has-error :form="form" field="itinerary_5"></has-error>
                        </div>

                    </div>
                </div>


                <!-- travel info -->
                <div class="form-group">
                    <label> {{ $t('travels_table.info') }}</label>
                    <vue-editor
                        v-model="form.info"
                        :class="{ 'is-invalid': form.errors.has('info') }"
                    ></vue-editor>
                    <span class="help-error-form" v-if="form.errors.has('info')" v-text="form.errors.get('info')"></span>
                </div>


                <!-- discount -->
                <div class="form-group">
                    <label> {{ $t('travels_table.discount') }} </label>
                    <input
                        v-model="form.discount"
                        type="number"
                        max="100"
                        min="0"
                        :placeholder="$t('travels_table.discount')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('discount') }"
                    >
                    <has-error :form="form" field="discount"></has-error>
                </div>


                <!-- favorite company -->
                <div class="form-group">
                    <label> {{ $t('travels_table.favorite_company') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.favorite_company"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('favorite_company') }"
                        >
                        <option :value="0" v-text="$t('travels_table.favorite_company_no')"></option>
                        <option :value="1" v-text="$t('travels_table.favorite_company_yes')"></option>
                    </select>
                    <has-error :form="form" field="favorite_company"></has-error>
                </div>


                <!-- hotel -->
                <div class="form-group">
                    <label> {{ $t('travels_table.hotel_id') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.hotel_id"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('hotel_id') }"
                    >
                        <option v-for="hotel in hotelsSelect" :value="hotel.id" :key="hotel.id" v-text="hotel.name + ' --- ' + hotel.address"></option>
                    </select>
                    <has-error :form="form" field="hotel_id"></has-error>
                </div>


                <!-- hotel 2 -->
                <div class="form-group">
                    <label> {{ $t('travels_table.hotel_2_id') }}</label>
                    <select
                        v-model="form.hotel_2_id"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('hotel_2_id') }"
                    >
                        <option v-for="hotel in hotelsSelect" :value="hotel.id" :key="hotel.id" v-text="hotel.name + ' --- ' + hotel.address"></option>
                    </select>
                    <has-error :form="form" field="hotel_2_id"></has-error>
                </div>


                <!-- travel_category -->
                <div class="form-group" v-if="form.type !== 'external'">
                    <label> {{ $t('global.the_travel_category') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.travel_category_id"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('travel_category_id') }"
                    >
                        <option v-for="travel_category in travelCategoriesSelect" :value="travel_category.id" :key="travel_category.id" v-text="travel_category.name"></option>
                    </select>
                    <has-error :form="form" field="travel_category_id"></has-error>
                </div>


                <!-- display travel -->
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
                    <label> {{ $t('travels_table.image') }} <span class="field-required"></span></label>
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
                <div class="form-group" v-if="form.type === 'umrah' || form.type === 'pilgrimage'">
                    <label> {{ $t('travels_table.gallery') }} </label>

                    <upload-image
                        type="multiple"
                        propertyName="gallery"
                        propertyDeletedName="deletedGallery"
                        :form="form"
                    ></upload-image>

                </div> <!-- ./gallery -->


                <!-- travel details -->
                <div class="form-group">
                    <div class="wrapper-internal-form form-offers">
                        <label class="title-internal-form"> {{ $t('travels_table.travel_offers') }} (<span> {{ $t('travels_table.travel_offers_msg_form') }} </span>) </label>

                        <div
                            v-for="(offer, index) in form.offers" :key="index"
                            class="form-row"
                            :class="{'is-invalid': inValidFormOffer(index)}"
                        >

                            <div class="form-group col-12">
                                <div class="offer-title">
                                    <h3 class="title">
                                        {{ $t('travels_table.offers.offer') }}
                                        {{ counterText[index] }}
                                    </h3>
                                </div>
                            </div>

                            <!-- info_offer -->
                            <div class="form-group col-lg-12">
                                <input
                                    v-model="form.offers[index].info_offer"
                                    type="text"
                                    :placeholder="$t('travels_table.offers.info_offer')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.info_offer`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.info_offer`"></has-error>
                            </div>
                            <!-- ./info_offer -->


                            <!-- go_and_back -->
                            <!-- <div class="form-group col-lg-6 required" v-if="form.type === 'umrah' || form.type === 'pilgrimage'">
                                <select
                                    v-model="form.offers[index].go_and_back"
                                    class="custom-select"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.go_and_back`) }"
                                    >
                                    <option :value="0" v-text="$t('travels_table.offers.only_go')"></option>
                                    <option :value="1" v-text="$t('travels_table.offers.go_and_back')"></option>
                                </select>
                                <has-error :form="form" :field="`offers.${index}.go_and_back`"></has-error>
                            </div> -->
                            <!-- ./go_and_back -->

                            <div class="form-group col-12">
                                <label class="internal-label"> {{ $t('travels_table.offers.time_period') }} </label>
                            </div>

                            <!-- date_from -->
                            <div class="form-group col-lg-6 required">
                                <date-picker
                                    v-model="form.offers[index].date_from"
                                    :placeholder="$t('travels_table.offers.date_from')"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.date_from`) }"
                                    class="offer-date date-from"
                                    width="100%"
                                    :lang="langDates"
                                    value-type="format"
                                ></date-picker>
                                <has-error :form="form" :field="`offers.${index}.date_from`"></has-error>
                            </div>
                            <!-- ./date_from -->


                            <!-- date_to -->
                            <div class="form-group col-lg-6 required">
                                <date-picker
                                    v-model="form.offers[index].date_to"
                                    :placeholder="$t('travels_table.offers.date_to')"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.date_to`) }"
                                    class="offer-date date-to"
                                    width="100%"
                                    :lang="langDates"
                                    value-type="format"
                                ></date-picker>
                                <has-error :form="form" :field="`offers.${index}.date_to`"></has-error>
                            </div>
                            <!-- ./date_to -->


                            <!-- hotel_days -->
                            <div class="form-group col-lg-6 required" v-if="form.type === 'umrah' || form.type === 'pilgrimage'">
                                <input
                                    v-model="form.offers[index].hotel_days"
                                    type="number"
                                    max="100"
                                    :placeholder="$t('travels_table.offers.hotel_days')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.hotel_days`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.hotel_days`"></has-error>
                            </div>
                            <!-- ./hotel_days -->


                            <!-- hotel_2_days -->
                            <div class="form-group col-lg-6 required" v-if="form.type === 'umrah' || form.type === 'pilgrimage'">
                                <input
                                    v-model="form.offers[index].hotel_2_days"
                                    type="number"
                                    max="100"
                                    :placeholder="$t('travels_table.offers.hotel_2_days')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.hotel_2_days`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.hotel_2_days`"></has-error>
                            </div>
                            <!-- ./hotel_2_days -->


                            <!-- stay_type -->
                            <div class="form-group col-lg-6 required">
                                <select
                                    v-model="form.offers[index].stay_type"
                                    class="custom-select"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.stay_type`) }"
                                    >
                                    <option v-for="type in stayTypes" :key="type.value" :value="type.value" v-text="type.value"></option>
                                </select>
                                <has-error :form="form" :field="`offers.${index}.stay_type`"></has-error>
                            </div>
                            <!-- ./stay_type -->


                            <!-- transport -->
                            <div class="form-group col-lg-6 required">
                                <select
                                    v-model="form.offers[index].transport"
                                    class="custom-select"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.transport`) }"
                                    >
                                    <option v-for="transport in transports" :key="transport.value" :value="transport.value" v-text="transport.label"></option>
                                </select>
                                <has-error :form="form" :field="`offers.${index}.transport`"></has-error>
                            </div>
                            <!-- ./transport -->


                            <!-- adults -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="form.offers[index].adults"
                                    type="number"
                                    :placeholder="$t('travels_table.offers.adults')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.adults`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.adults`"></has-error>
                            </div>
                            <!-- ./adults -->


                            <!-- children -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="form.offers[index].children"
                                    type="number"
                                    :placeholder="$t('travels_table.offers.children')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.children`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.children`"></has-error>
                            </div>
                            <!-- ./children -->


                            <div class="form-group col-12">
                                <label class="internal-label"> {{ $t('global.the_price') }} </label>
                            </div>


                            <!-- child_price -->
                            <div class="form-group col-lg-6 required" v-if="form.type === 'umrah' || form.type === 'pilgrimage'">
                                <input
                                    v-model="form.offers[index].child_price"
                                    type="number"
                                    :placeholder="$t('travels_table.offers.child_price')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.child_price`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.child_price`"></has-error>
                            </div>
                            <!-- ./child_price -->


                            <!-- baby_price -->
                            <div class="form-group col-lg-6 required" v-if="form.type === 'umrah' || form.type === 'pilgrimage'">
                                <input
                                    v-model="form.offers[index].baby_price"
                                    type="number"
                                    :placeholder="$t('travels_table.offers.baby_price')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.baby_price`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.baby_price`"></has-error>
                            </div>
                            <!-- ./baby_price -->


                            <!-- single_price -->
                            <div class="form-group col-lg-6 required">
                                <input
                                    v-model="form.offers[index].single_price"
                                    type="number"
                                    :placeholder="form.type === 'umrah' || form.type === 'pilgrimage' ? $t('travels_table.offers.twin_price') : $t('travels_table.offers.single_price')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.single_price`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.single_price`"></has-error>
                            </div>
                            <!-- ./single_price -->


                            <!-- twin_price -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="form.offers[index].twin_price"
                                    type="number"
                                    :placeholder="form.type === 'umrah' || form.type === 'pilgrimage' ? $t('travels_table.offers.triple_price') : $t('travels_table.offers.twin_price')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.twin_price`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.twin_price`"></has-error>
                            </div>
                            <!-- ./twin_price -->


                            <!-- triple_price -->
                            <div class="form-group col-lg-6">
                                <input
                                    v-model="form.offers[index].triple_price"
                                    type="number"
                                    :placeholder="form.type === 'umrah' || form.type === 'pilgrimage' ? $t('travels_table.offers.forth_price') : $t('travels_table.offers.triple_price')"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.triple_price`) }"
                                >
                                <has-error :form="form" :field="`offers.${index}.triple_price`"></has-error>
                            </div>
                            <!-- ./triple_price -->


                            <!-- display -->
                            <div class="form-group col-lg-6 required">
                                <select
                                    v-model="form.offers[index].display"
                                    class="custom-select"
                                    :class="{ 'is-invalid': form.errors.has(`offers.${index}.display`) }"
                                    >
                                    <option value="1"> {{ $t('global.visible') }} </option>
                                    <option value="0"> {{ $t('global.hidden') }} </option>
                                </select>
                                <has-error :form="form" :field="`offers.${index}.display`"></has-error>
                            </div>
                            <!-- ./display -->

                            <!-- btn remove offer -->
                            <div class="form-group col-12">
                                <button
                                    type="button"
                                    class="btn btn-danger add-new-offer"
                                    @click="removeOffer(index)"
                                    v-if="form.offers.length > 1"
                                >
                                    {{ $t('travels_table.offers.delete_offer') }}
                                </button>
                            </div>
                            <!-- ./btn remove offer -->
                        </div><!-- ./form-row -->

                    </div><!-- ./wrapper-internal-form -->
                    <!-- btn add offer -->
                    <button
                        type="button"
                        class="btn btn-success add-new-offer float-left"
                        @click="addOffer()"
                    >
                        {{ $t('travels_table.offers.add_new_offer') }}
                    </button>
                    <!-- ./btn add offer -->

                </div><!-- ./travel details -->

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
            urlGetHotels: '/hotels/select',
            hotelsSelect: [],
            urlGetTravelCategories: '/travel_categories/select',
            travelCategoriesSelect: [],
            travelTypes: [
                {value: 'pilgrimage', label: 'حج'},
                {value: 'umrah', label: 'عمرة'},
                {value: 'internal', label: 'سياحة داخلية'},
                {value: 'external', label: 'عروض الطيران'},
            ],
            haramDistance: [
                {value: 0, label: 'بعيد'},
                {value: 1, label: 'قريب'}
            ],
            stayTypes: [
                {value: 'بدون إفطار'},
                {value: 'شامل إفطار'},
                {value: 'نصف إقامة'},
                {value: 'شامل جميع الوجبات والمشروبات'}
            ],
            transports: [
                {value: 0, label: 'بدون انتقالات'},
                {value: 1, label: 'شامل الانتقالات'},
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
        getHotelsSelect() {
            axios.get(this.urlGetHotels).then(response => {
                if (response.status === 200) {
                    if (typeof response.data === 'object') {
                        this.hotelsSelect = response.data.hotels
                    } else {
                        setTimeout(() => {
                            this.getHotelsSelect()
                        }, 500)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getHotelsSelect()
                }, 500)
            });
        },
        getTravelCategoriesSelect() {
            axios.get(this.urlGetTravelCategories).then(response => {
                if (response.status === 200) {
                    if (typeof response.data === 'object') {
                        this.travelCategoriesSelect = response.data.travel_categories
                    } else {
                        setTimeout(() => {
                            this.getTravelCategoriesSelect()
                        }, 500)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelCategoriesSelect()
                }, 500)
            });
        },

        inValidFormOffer(index) {
            const errors = {...this.form.errors.errors}
            const indexes = []
            for (let error in errors) {
                if (error.indexOf('offers.') != -1) {
                    const indexNumber = error.indexOf('.')
                    if (indexNumber === 6) {
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

        addOffer() {
            this.form.offers.push(
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
            )
            setTimeout(() => {
                const lastForm = $('.form-offers .form-row:last-child')
                $('html').animate({
                    scrollTop: lastForm.offset().top - 70
                })
            }, 100)
        },

        removeOffer(index) {
            if (this.typeForm == 'edit') {
                if (this.form.offers[index].id) {
                    this.form.deletedOffers.push(this.form.offers[index].id)
                }
            }
            this.form.offers.splice(index, 1)
        },
    },

    mounted() {
        this.$nextTick(() => {
            this.getHotelsSelect()
            this.getTravelCategoriesSelect()
        })
    }
}

</script>
