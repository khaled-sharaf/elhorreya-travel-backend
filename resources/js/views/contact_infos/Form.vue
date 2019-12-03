
<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">


                <!-- branch_name -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.branch_name') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.branch_name"
                        type="text"
                        :placeholder="$t('contact_infos_table.branch_name')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('branch_name') }"
                    >
                    <has-error :form="form" field="branch_name"></has-error>
                </div>


                <!-- phone_1 -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.phone_1') }}</label>
                    <input
                        v-model="form.phone_1"
                        type="text"
                        :placeholder="$t('contact_infos_table.phone_1')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('phone_1') }"
                    >
                    <has-error :form="form" field="phone_1"></has-error>
                </div>


                <!-- phone_2 -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.phone_2') }}</label>
                    <input
                        v-model="form.phone_2"
                        type="text"
                        :placeholder="$t('contact_infos_table.phone_2')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('phone_2') }"
                    >
                    <has-error :form="form" field="phone_2"></has-error>
                </div>


                <!-- phone_3 -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.phone_3') }}</label>
                    <input
                        v-model="form.phone_3"
                        type="text"
                        :placeholder="$t('contact_infos_table.phone_3')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('phone_3') }"
                    >
                    <has-error :form="form" field="phone_3"></has-error>
                </div>


                <!-- phone_4 -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.phone_4') }}</label>
                    <input
                        v-model="form.phone_4"
                        type="text"
                        :placeholder="$t('contact_infos_table.phone_4')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('phone_4') }"
                    >
                    <has-error :form="form" field="phone_4"></has-error>
                </div>


                <!-- address -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.address') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.address"
                        type="text"
                        :placeholder="$t('contact_infos_table.address')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('address') }"
                    >
                    <has-error :form="form" field="address"></has-error>
                </div>


                <!-- email -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.email') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.email"
                        type="text"
                        :placeholder="$t('contact_infos_table.email')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                    >
                    <has-error :form="form" field="email"></has-error>
                </div>


                <!-- latitude -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.latitude') }}</label>
                    <input
                        type="text"
                        id="hotel_latitude"
                        :placeholder="$t('contact_infos_table.latitude')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('latitude') }"
                    >
                    <has-error :form="form" field="latitude"></has-error>
                </div>


                <!-- longitude -->
                <div class="form-group">
                    <label>{{ $t('contact_infos_table.longitude') }}</label>
                    <input
                        type="text"
                        id="hotel_longitude"
                        :placeholder="$t('contact_infos_table.longitude')"
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
                        <h5 class="info-map"> {{ $t('contact_infos_table.msg_location_map') }}</h5>
                        <div id="floating-panel">
                            <input class="form-control" id="address" type="text" value="مصر، القاهرة" :placeholder="$t('datatable.search')">
                            <span class="error-location"> {{ $t('hotels_table.error_location') }} </span>
                        </div>
                        <div id="map"></div>
                    </div>
                </div>



                <!-- dispaly contact_info -->
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


            </div><!-- ./col-md -->
        </div><!-- ./row -->
    </div>
</template>


<script>
  export default {
    props: ['form', 'typeForm'],
    data() {
      return {

      }
    },
    methods: {
        showGoogleMapHotel() {
            var scriptMap = document.createElement('script');
            document.body.appendChild(scriptMap);
            scriptMap.id = 'scriptMapHotel';
            scriptMap.setAttribute('async', true);
            scriptMap.setAttribute('defer', true);
            scriptMap.setAttribute('src', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyADsFcbM6g-A_nUwh41pFn9EgDdlRC6lGY&language=ar&region=EG&callback=initMapHotel');
        },
    },
    mounted() {
        if (this.typeForm == 'edit') {
            const getData = setInterval(() => {
                if (this.form.branch_name != '') {
                    this.showGoogleMapHotel()
                    clearInterval(getData)
                }
            }, 500)
        } else if (this.typeForm == 'create') {
            this.showGoogleMapHotel()
        }
    },
  }
</script>
