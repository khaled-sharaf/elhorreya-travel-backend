
<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">

                <!-- info -->
                <div class="form-group">
                    <label>{{ $t('rooms_table.info') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.info"
                        type="text"
                        :placeholder="$t('rooms_table.info')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('info') }"
                    >
                    <has-error :form="form" field="info"></has-error>
                </div>


                <!-- room options -->
                <div class="form-group">
                    <label> {{ $t('rooms_table.options') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.options"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('options') }">

                        <option v-for="option in roomOptions" :value="option.value" :key="option.value" v-text="option.value"></option>
                    </select>
                    <has-error :form="form" field="options"></has-error>
                </div>

                <!-- price night -->
                <!-- <div class="form-group">
                    <label>{{$t('rooms_table.price_night')}} <span class="field-required"></span></label>
                    <input
                        v-model="form.price_night"
                        type="number"
                        :placeholder="$t('rooms_table.price_night')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('price_night') }"
                    >
                    <has-error :form="form" field="price_night"></has-error>
                </div> -->

                <!-- offer days -->
                <!-- <div class="form-group">
                    <label>{{$t('rooms_table.offer_days')}}</label>
                    <input
                        v-model="form.offer_days"
                        type="number"
                        :placeholder="$t('rooms_table.offer_days')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('offer_days') }"
                    >
                    <has-error :form="form" field="offer_days"></has-error>
                </div> -->

                <!-- offer price -->
                <!-- <div class="form-group">
                    <label>{{$t('rooms_table.offer_price')}}</label>
                    <input
                        v-model="form.offer_price"
                        type="number"
                        :placeholder="$t('rooms_table.offer_price')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('offer_price') }"
                    >
                    <has-error :form="form" field="offer_price"></has-error>
                </div> -->

                <!-- hotel -->
                <div class="form-group">
                    <label> {{ $t('global.the_hotel') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.hotel_id"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('hotel_id') }"
                        >
                        <option v-for="hotel in hotelsSelect" :value="hotel.id" :key="hotel.id" v-text="hotel.name"></option>
                    </select>
                    <has-error :form="form" field="hotel_id"></has-error>
                </div>



                <!-- dispaly room -->
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
          roomOptions: [
              {value: 'بدون إفطار'},
              {value: 'شامل إفطار'},
              {value: 'نصف إقامة'},
              {value: 'شامل جميع الوجبات والمشروبات'}
          ],
          urlGetHotels: '/hotels/select',
          hotelsSelect: [],
      }
    },
    methods: {
        getHotelsSelect() {
            axios.get(this.urlGetHotels).then(response => {
                if (response.status === 200) {
                    const data = response.data
                    if (typeof data === 'object') {
                        this.hotelsSelect = response.data.hotels
                    } else {
                        setTimeout(() => {
                            this.getHotelsSelect()
                        }, 1000)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getHotelsSelect()
                }, 1000)
            });
        },
    },
    mounted() {
        this.$nextTick(() => {
            this.getHotelsSelect()
        })
    },
  }
</script>
