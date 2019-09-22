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

                    <div class="wrapper-drop-image"  :class="{'contains-image': form.gallery !== null && form.gallery.length > 0, 'is-invalid': form.errors.has('gallery')}" id="image-multi-image"> <!-- contains-image -->
                        <div class="overlay-drop-image" for="image_images">
                            <div class="view-images">
                                <div class="image elevation-5" v-for="(image, index) in form.gallery" :key="index">
                                    <div class="img">
                                        <img :src="addDomainToImage(image.value)">
                                        <div class="remove-image" @click="removeImage(index)"><i class="fas fa-times"></i></div>
                                    </div>
                                </div>
                            </div>
                            <label class="view-overlay" for="image_images">
                                <div class="content-overlay">
                                    <i class="icon far fa-image"></i>
                                    <span class="title"> {{ $t('global.drag_msg') }} </span>
                                </div>
                            </label>
                        </div>
                        <input
                            type="file"
                            class="custom-file-drop custom-file-input"
                            id="image_images"
                            accept="image/*"
                            @change="showFiles($event.target.files, $event.target.id)"
                            :class="{ 'is-invalid': form.errors.has('gallery') }"
                            multiple
                        >
                        <has-error :form="form" field="gallery"></has-error>
                    </div>
                </div> <!-- ./gallery -->

            </div><!-- ./col-md -->
        </div><!-- ./row -->
    </div>
</template>


<script>
  export default {
    props: ['form', 'typeForm'],
    data() {
      return {
        imageImage: "",
        droppedFiles: false,
        urlGetTravelCategories: '/travel_categories/select',
        travelCategoriesSelect: [],
      }
    },
    methods: {
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        },
        encodeFileAsURL(files) {
            let self = this;
            for (let i = 0; i < files.length; i++) {
                let file = files[i]
                let reader = new FileReader();
                reader.onloadend = function() {
                    self.form.gallery.push({value: reader.result})
                };
                if (file) {
                    if (file["size"] > 3000000) {
                        if (this.$i18n.locale == 'ar') {
                            Swal.fire(
                                "خطأ...",
                                "الحجم المسموح به للصورة هو 3 ميجا بايت.",
                                "error"
                            );
                        } else {
                            Swal.fire(
                                "Oops...",
                                "You are uploading a large file 3MB last.",
                                "error"
                            );
                        }
                    } else if (file['type'] != 'image/jpeg' && file['type'] != 'image/png' && file['type'] != 'image/gif') {
                        if (this.$i18n.locale == 'ar') {
                            Swal.fire(
                                "خطأ...",
                                "يجب أن تكون الصورة لها امتداد من هذه الإمتدادات [jpg, png, gif].",
                                "error"
                            );
                        } else {
                            Swal.fire(
                                "Oops...",
                                "You must be image have extension between [jpg, png, gif].",
                                "error"
                            );
                        }
                    } else {
                        reader.readAsDataURL(file);
                    }
                }
            }
        },
        showFiles(files, input) {
            if (typeof input === 'string') {
                input = $('#' + input)
            }
            let lengthFiles = files.length;
            if (input.attr('multiple')) {
                if (lengthFiles > 0) {
                    this.encodeFileAsURL(files)
                }
            } else {
                if (lengthFiles > 0) {
                    this.encodeFileAsURL(files[0])
                }
            }
        },
        removeImage(index) {
            if (this.typeForm == 'edit') {
                if (this.form.gallery[index].id) {
                    this.form.deletedGallery.push(this.form.gallery[index])
                }
            }
            this.form.gallery.splice(index, 1)
        },
        handelDropImages() {
            const self = this;
            // view-images
            $('.wrapper-drop-image').on('drag dragstart dragend dragover dragenter dragleave drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
            }).on('dragover dragenter', function(e) {
                $(this).addClass('is-dragover');
            })
            .on('dragleave dragend drop', function() {
                $(this).removeClass('is-dragover');
            })
            .on('drop', function(e) {
                this.droppedFiles = e.originalEvent.dataTransfer.files;
                let lengthFiles = e.originalEvent.dataTransfer.files.length;
                let input = $(this).find('.custom-file-drop');
                self.showFiles(this.droppedFiles, input)
            });
        },
        addDomainToImage(url) { // return url
            let resultUrl = '';
            if (url.indexOf("data:image/") === 0) {
                resultUrl = url;
            } else {
                resultUrl = this.$domain + '/' + url;
            }
            return resultUrl;
        },
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
        this.handelDropImages()
        this.getTravelCategoriesSelect()
    }
  }
</script>
