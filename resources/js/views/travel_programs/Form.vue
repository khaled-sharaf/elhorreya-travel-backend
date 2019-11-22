<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">

                <!-- name -->
                <div class="form-group">
                    <label> {{ $t('travel_programs_table.name') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.name"
                        type="text"
                        :placeholder="$t('travel_programs_table.name')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                    >
                    <has-error :form="form" field="name"></has-error>
                </div>

                <!-- discount -->
                <div class="form-group">
                    <label> {{ $t('travel_programs_table.discount') }} </label>
                    <input
                        v-model="form.discount"
                        type="number"
                        max="100"
                        min="0"
                        :placeholder="$t('travel_programs_table.discount')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('discount') }"
                    >
                    <has-error :form="form" field="discount"></has-error>
                </div>


                <!-- travel_program small_info -->
                <div class="form-group">
                    <label> {{ $t('travel_programs_table.small_info') }} </label>
                    <textarea
                        v-model="form.small_info"
                        type="text"
                        :placeholder="$t('travel_programs_table.small_info')"
                        class="form-control textarea-form"
                        :class="{ 'is-invalid': form.errors.has('small_info') }"
                    ></textarea>
                    <has-error :form="form" field="small_info"></has-error>
                </div>


                <!-- travel_program big_info -->
                <div class="form-group">
                    <label> {{ $t('travel_programs_table.big_info') }} </label>
                    <vue-editor
                        v-model="form.big_info"
                        :class="{ 'is-invalid': form.errors.has('big_info') }"
                    ></vue-editor>
                    <span class="help-error-form" v-if="form.errors.has('big_info')" v-text="form.errors.get('big_info')"></span>
                </div>


                <!-- order -->
                <div class="form-group">
                    <label> {{ $t('travel_programs_table.order')}} </label>
                    <input
                        v-model="form.order"
                        type="number"
                        :placeholder="$t('travel_programs_table.order')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('order') }"
                    >
                    <has-error :form="form" field="order"></has-error>
                </div>


                <!-- image -->
                <div class="form-group">
                    <label> {{ $t('travel_programs_table.image') }} <span class="field-required"></span></label>
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
    }
  }
</script>
