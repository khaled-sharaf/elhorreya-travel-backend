<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">

                <!-- name -->
                <div class="form-group">
                    <label> {{ $t('travel_categories_table.name') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.name"
                        type="text"
                        :placeholder="$t('travel_categories_table.name')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                    >
                    <has-error :form="form" field="name"></has-error>
                </div>


                <!-- type -->
                <div class="form-group">
                    <label> {{ $t('travel_categories_table.type') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.type"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('type') }"
                    >
                        <option v-for="type in categoryTypes" :key="type.value" :value="type.value" v-text="type.label"></option>
                    </select>
                    <has-error :form="form" field="type"></has-error>
                </div>

                <!-- discount -->
                <div class="form-group">
                    <label> {{ $t('travel_categories_table.discount') }} </label>
                    <input
                        v-model="form.discount"
                        type="number"
                        max="100"
                        min="0"
                        :placeholder="$t('travel_categories_table.discount')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('discount') }"
                    >
                    <has-error :form="form" field="discount"></has-error>
                </div>


                <!-- order -->
                <div class="form-group">
                    <label> {{ $t('travel_categories_table.order')}} </label>
                    <input
                        v-model="form.order"
                        type="number"
                        :placeholder="$t('travel_categories_table.order')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('order') }"
                    >
                    <has-error :form="form" field="order"></has-error>
                </div>


                <!-- travel_program -->
                <div class="form-group">
                    <label> {{ $t('global.the_travel_program') }} <span class="field-required"></span></label>
                    <select
                        v-model="form.travel_program_id"
                        class="custom-select"
                        :class="{ 'is-invalid': form.errors.has('travel_program_id') }"
                        >
                        <option v-for="travel_program in travelProgramsSelect" :value="travel_program.id" :key="travel_program.id" v-text="travel_program.name"></option>
                    </select>
                    <has-error :form="form" field="travel_program_id"></has-error>
                </div>


                <!-- image -->
                <div class="form-group">
                    <label> {{ $t('travel_categories_table.image') }} <span class="field-required"></span></label>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <upload-image
                                propertyName="image"
                                :form="form"
                            ></upload-image>
                        </div>
                    </div>
                </div>

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
        urlGetTravelPrograms: '/travel_programs/select',
        travelProgramsSelect: [],
        categoryTypes: [
            {value: 1, label: 'حج'},
            {value: 2, label: 'عمرة'},
            {value: 3, label: 'سياحة داخلية'},
            {value: 4, label: 'سياحة خارجية'},
            {value: 5, label: 'شهر العسل'},
        ]
      }
    },
    methods: {
        getTravelProgramsSelect() {
            axios.get(this.urlGetTravelPrograms).then(response => {
                if (response.status === 200) {
                    this.travelProgramsSelect = response.data.travel_programs
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelProgramsSelect()
                }, 1000)
            });
        },
    },
    mounted() {
        this.getTravelProgramsSelect()
    }
  }
</script>
