<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">


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


                <!-- image -->
                <div class="form-group">
                    <label> {{ $t('images_table.image') }} <span class="field-required"></span></label>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="wrapper-drop-image" :class="{'contains-image': form.image != '', 'is-invalid': form.errors.has('image')}" id="image-default-image"> <!-- contains-image -->
                                <div class="overlay-drop-image">
                                    <div class="view-images">
                                        <div class="image elevation-5" v-if="form.image != ''">
                                            <div class="img">
                                                <img :src="imageImage">
                                            </div>
                                        </div>

                                    </div>
                                    <label class="view-overlay" for="image_image">
                                        <div class="content-overlay">
                                            <i class="icon far fa-image"></i>
                                            <span class="title"> {{ $t('global.drag_msg') }} </span>
                                        </div>
                                    </label>
                                </div>
                                <input
                                    type="file"
                                    class="custom-file-drop custom-file-input"
                                    id="image_image"
                                    accept="image/*"
                                    @change="showFiles($event.target.files, $event.target.id)"
                                    :class="{ 'is-invalid': form.errors.has('image') }"
                                >
                                <has-error :form="form" field="image"></has-error>
                            </div>
                        </div>
                    </div>
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
        imageImage: "",
        droppedFiles: false
      }
    },
    methods: {
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        },
        encodeFileAsURL(files) {
            let self = this;
            let file = files;
            let reader = new FileReader();
            reader.onloadend = function() {
                self.form.image = reader.result
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
        }
    },
    watch: {
        "form.image"(val) {
            this.imageImage = this.addDomainToImage(val);
        }
    },
    mounted() {
        if (this.typeForm == 'edit') {
            let getImage = setInterval(() => {
                if (this.form.image != '') {
                    this.imageImage = this.$domain + '/' + this.form.image
                    clearInterval(getImage)
                }
            }, 500)
        }
        this.handelDropImages()
    }
  }
</script>
