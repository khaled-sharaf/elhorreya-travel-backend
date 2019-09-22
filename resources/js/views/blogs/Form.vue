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
                            <div class="wrapper-drop-image" :class="{'contains-image': form.image != '', 'is-invalid': form.errors.has('image')}" id="blog-default-image"> <!-- contains-image -->
                                <div class="overlay-drop-image">
                                    <div class="view-images">
                                        <div class="image elevation-5" v-if="form.image != ''">
                                            <div class="img">
                                                <img :src="blogImage">
                                            </div>
                                        </div>

                                    </div>
                                    <label class="view-overlay" for="blog_image">
                                        <div class="content-overlay">
                                            <i class="icon far fa-image"></i>
                                            <span class="title"> {{ $t('global.drag_msg') }} </span>
                                        </div>
                                    </label>
                                </div>
                                <input
                                    type="file"
                                    class="custom-file-drop custom-file-input"
                                    id="blog_image"
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
                    <label> {{ $t('blogs_table.gallery') }} </label>

                    <div class="wrapper-drop-image"  :class="{'contains-image': form.gallery !== null && form.gallery.length > 0}" id="blog-multi-image"> <!-- contains-image -->
                        <div class="overlay-drop-image" for="blog_images">
                            <div class="view-images">
                                <div class="image elevation-5" v-for="(image, index) in form.gallery" :key="index">
                                    <div class="img">
                                        <img :src="addDomainToImage(image.value)">
                                        <div class="remove-image" @click="removeImage(index)"><i class="fas fa-times"></i></div>
                                    </div>
                                </div>
                            </div>
                            <label class="view-overlay" for="blog_images">
                                <div class="content-overlay">
                                    <i class="icon far fa-image"></i>
                                    <span class="title"> {{ $t('global.drag_msg') }} </span>
                                </div>
                            </label>
                        </div>
                        <input
                            type="file"
                            class="custom-file-drop"
                            id="blog_images"
                            accept="image/*"
                            @change="showFiles($event.target.files, $event.target.id)"
                            :class="{ 'is-invalid': form.errors.has('image') }"
                            multiple
                        >
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
        blogImage: "",
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
    },
    watch: {
        "form.image"(val) {
            this.blogImage = this.addDomainToImage(val);
        }
    },
    mounted() {
        if (this.typeForm == 'edit') {
            let getImage = setInterval(() => {
                if (this.form.image != '') {
                    this.blogImage = this.$domain + '/' + this.form.image
                    clearInterval(getImage)
                }
            }, 500)
        }
        this.handelDropImages()
    }
  }
</script>
