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


                <!-- rating -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.rating') + ' ' + $t('global.from') }} 0 {{ $t('global.to') }} 100 </label>
                    <input
                        v-model="form.rating"
                        type="number"
                        :placeholder="$t('hotels_table.rating')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('rating') }"
                    >
                    <has-error :form="form" field="rating"></has-error>
                </div>


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
                    <textarea
                        v-model="form.info"
                        type="text"
                        :placeholder="$t('hotels_table.info')"
                        class="form-control textarea-form"
                        :class="{ 'is-invalid': form.errors.has('info') }"
                    ></textarea>
                    <has-error :form="form" field="info"></has-error>
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
                            <div class="wrapper-drop-image" :class="{'contains-image': form.image != '', 'is-invalid': form.errors.has('image')}" id="hotel-default-image"> <!-- contains-image -->
                                <div class="overlay-drop-image">
                                    <div class="view-images">
                                        <div class="image elevation-5" v-if="form.image != ''">
                                            <div class="img">
                                                <img :src="hotelImage">
                                            </div>
                                        </div>

                                    </div>
                                    <label class="view-overlay" for="hotel_image">
                                        <div class="content-overlay">
                                            <i class="icon far fa-image"></i>
                                            <span class="title"> {{ $t('global.drag_msg') }} </span>
                                        </div>
                                    </label>
                                </div>
                                <input
                                    type="file"
                                    class="custom-file-drop custom-file-input"
                                    id="hotel_image"
                                    accept="image/*"
                                    @change="showFiles($event.target.files, $event.target.id)"
                                    :class="{ 'is-invalid': form.errors.has('image') }"
                                >
                                <has-error :form="form" field="image"></has-error>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- gallery -->
                <div class="form-group">
                    <label> {{ $t('hotels_table.gallery') }} </label>

                    <div class="wrapper-drop-image"  :class="{'contains-image': form.gallery !== null && form.gallery.length > 0}" id="hotel-multi-image"> <!-- contains-image -->
                        <div class="overlay-drop-image" for="hotel_images">
                            <div class="view-images">
                                <div class="image elevation-5" v-for="(image, index) in form.gallery" :key="index">
                                    <div class="img">
                                        <img :src="addDomainToImage(image.value)">
                                        <div class="remove-image" @click="removeImage(index)"><i class="fas fa-times"></i></div>
                                    </div>
                                </div>
                            </div>
                            <label class="view-overlay" for="hotel_images">
                                <div class="content-overlay">
                                    <i class="icon far fa-image"></i>
                                    <span class="title"> {{ $t('global.drag_msg') }} </span>
                                </div>
                            </label>
                        </div>
                        <input
                            type="file"
                            class="custom-file-drop"
                            id="hotel_images"
                            accept="image/*"
                            @change="showFiles($event.target.files, $event.target.id)"
                            :class="{ 'is-invalid': form.errors.has('image') }"
                            multiple
                        >
                    </div>
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

            </div><!-- ./col-md -->
        </div><!-- ./row -->
    </div>
</template>


<script>
  export default {
    props: ['form', 'typeForm'],
    data() {
      return {
        hotelImage: "",
        droppedFiles: false
      }
    },
    methods: {
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        },
        encodeFileAsURL(files) {
            let self = this;
            if (files.length) {
                // multi images
                // if (self.form.gallery.length < 6 && (self.form.gallery.length + files.length) < 7) {
                    for (let i = 0; i < files.length; i++) {
                        let file = files[i]
                        let reader = new FileReader();
                        reader.onloadend = function() {
                            self.form.gallery.push({value: reader.result})
                        };
                        if (file) {
                            if (file["size"] > 4000000) {
                                if (this.$i18n.locale == 'ar') {
                                    Swal.fire(
                                        "خطأ...",
                                        "الحجم المسموح به للصورة هو 4 ميجا بايت.",
                                        "error"
                                    );
                                } else {
                                    Swal.fire(
                                        "Oops...",
                                        "You are uploading a large file 4MB last.",
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
                // } else {
                //     if (this.$i18n.locale == 'ar') {
                //         Swal.fire(
                //             "خطأ...",
                //             "يجب عليك تحميل 6 صور أو أقل.",
                //             "error"
                //         );
                //     } else {
                //         Swal.fire(
                //             "Oops...",
                //             "You must upload 6 images or less.",
                //             "error"
                //         );
                //     }
                // }

            } else {
                let file = files;
                let reader = new FileReader();
                reader.onloadend = function() {
                    self.form.image = reader.result
                };
                if (file) {
                    if (file["size"] > 4000000) {
                        if (this.$i18n.locale == 'ar') {
                            Swal.fire(
                                "خطأ...",
                                "الحجم المسموح به للصورة هو 4 ميجا بايت.",
                                "error"
                            );
                        } else {
                            Swal.fire(
                                "Oops...",
                                "You are uploading a large file 4MB last.",
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
    },
    watch: {
        "form.image"(val) {
            this.hotelImage = this.addDomainToImage(val);
        }
    },
    mounted() {
        if (this.typeForm == 'edit') {
            let getImage = setInterval(() => {
                if (this.form.image != '') {
                    this.hotelImage = this.$domain + '/' + this.form.image
                    this.showGoogleMapHotel()
                    clearInterval(getImage)
                }
            }, 500)
        } else if (this.typeForm == 'create') {
            this.showGoogleMapHotel()
        }
        this.handelDropImages()
    }
  }
</script>
