<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">

                <!-- title -->
                <div class="form-group">
                    <label> {{ $t('blogs_table.title') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.title"
                        type="text"
                        :placeholder="$t('blogs_table.title')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('title') }"
                    >
                    <has-error :form="form" field="title"></has-error>
                </div>


                <!-- blog content -->
                <div class="form-group">
                    <label> {{ $t('blogs_table.content') }} <span class="field-required"></span></label>
                    <textarea
                        v-model="form.content"
                        type="text"
                        :placeholder="$t('blogs_table.content')"
                        class="form-control textarea-form"
                        :class="{ 'is-invalid': form.errors.has('content') }"
                    ></textarea>
                    <has-error :form="form" field="content"></has-error>
                </div>


                <!-- dispaly blog -->
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
                    <label> {{ $t('blogs_table.image') }} <span class="field-required"></span></label>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <upload-image
                                :maxSize="2100000"
                                propertyName="image"
                                :form="form"
                            ></upload-image>
                        </div>
                    </div>
                </div>

                <!-- gallery -->
                <div class="form-group">
                    <label> {{ $t('blogs_table.gallery') }} </label>
                    <upload-image
                        type="multiple"
                        :maxSize="2100000"
                        :maxCount="50"
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
}
</script>
