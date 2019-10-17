<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">

                <!-- travel_category -->
                <div class="form-group">
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


                <!-- display image -->
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


                <!-- gallery -->
                <div class="form-group">
                    <label> {{ $t('images_table.gallery') }} <span class="field-required"></span></label>

                    <upload-image
                        type="multiple"
                        propertyName="gallery"
                        propertyDeletedName="deletedGallery"
                        :form="form"
                    ></upload-image>

                </div> <!-- ./gallery -->

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
        urlGetTravelCategories: '/travel_categories/select',
        travelCategoriesSelect: [],
      }
    },
    methods: {
        getTravelCategoriesSelect() {
            axios.get(this.urlGetTravelCategories).then(response => {
                if (response.status === 200) {
                    this.travelCategoriesSelect = response.data.travel_categories
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelCategoriesSelect()
                }, 1000)
            });
        },
    },
    mounted() {
        this.getTravelCategoriesSelect()
    }
  }
</script>
