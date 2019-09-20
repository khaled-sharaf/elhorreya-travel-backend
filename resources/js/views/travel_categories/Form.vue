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
                            <div class="wrapper-drop-image" :class="{'contains-image': form.image != '', 'is-invalid': form.errors.has('image')}" id="travel_category-default-image"> <!-- contains-image -->
                                <div class="overlay-drop-image">
                                    <div class="view-images">
                                        <div class="image elevation-5" v-if="form.image != ''">
                                            <div class="img">
                                                <img :src="travelCategoryImage">
                                            </div>
                                        </div>

                                    </div>
                                    <label class="view-overlay" for="travel_category_image">
                                        <div class="content-overlay">
                                            <i class="icon far fa-image"></i>
                                            <span class="title"> {{ $t('global.drag_msg') }} </span>
                                        </div>
                                    </label>
                                </div>
                                <input
                                    type="file"
                                    class="custom-file-drop custom-file-input"
                                    id="travel_category_image"
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
        travelCategoryImage: "",
        droppedFiles: false,
        urlGetTravelPrograms: '/travel_programs/select',
        travelProgramsSelect: [],
      }
    },
    methods: {
        getIndex(array, key, value) {
            return array.findIndex(i => i[key] == value);
        },
        encodeFileAsURL(files) {
            let self = this;
            if (!files.length) {
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
    watch: {
        "form.image"(val) {
            this.travelCategoryImage = this.addDomainToImage(val);
        }
    },
    mounted() {
        if (this.typeForm == 'edit') {
            let getImage = setInterval(() => {
                if (this.form.image != '') {
                    this.travelCategoryImage = this.$domain + '/' + this.form.image
                    clearInterval(getImage)
                }
            }, 500)
        }
        this.handelDropImages()
        this.getTravelProgramsSelect()
    }
  }
</script>
