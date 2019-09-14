
<template>
    <div>
        <!-- row -->
        <div class="row justify-content-center">
            <!-- col-md -->
            <div class="col-md-12 col-lg-8">

                <!-- name -->
                <div class="form-group">
                    <label>{{ $t('users_table.name') }} <span class="field-required"></span></label>
                    <input
                        v-model="form.name"
                        type="text"
                        :placeholder="$t('users_table.name')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('name') }"
                    >
                    <has-error :form="form" field="name"></has-error>
                </div>

                <!-- email -->
                <div class="form-group">
                    <label>{{$t('users_table.email')}} <span class="field-required"></span></label>
                    <input
                        v-model="form.email"
                        type="text"
                        :placeholder="$t('users_table.email')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('email') }"
                    >
                    <has-error :form="form" field="email"></has-error>
                </div>

                <!-- password -->
                <div class="form-group">
                    <label>{{$t('users_table.password') }}<span class="field-required"></span></label>
                    <input
                        v-model="form.password"
                        type="password"
                        :placeholder="$t('users_table.password')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('password') }"
                    >
                    <has-error :form="form" field="password"></has-error>
                </div>

                <!-- password confirm -->
                <div class="form-group">
                    <label>{{$t('users_table.repeat_password')}} <span class="field-required"></span></label>
                    <input
                        v-model="form.password_confirmation"
                        type="password"
                        :placeholder="$t('users_table.repeat_password')"
                        class="form-control"
                        :class="{ 'is-invalid': form.errors.has('password_confirmation') }"
                    >
                    <has-error :form="form" field="password_confirmation"></has-error>
                </div>


                <div class="form-group">
                    <label> {{$t('users_table.image')}} </label>
                    <div class="custom-file">
                    <input
                        :lang="$i18n.locale"
                        type="file"
                        class="custom-file-input"
                        id="user_image"
                        accept="image/*"
                        @change="encodeUserProfileFileAsURL"
                        :class="{ 'is-invalid': form.errors.has('image') }"
                    >
                    <label class="custom-file-label" for="user_image"> {{$t('global.choose_image')}} </label>
                    <has-error :form="form" field="image"></has-error>
                    </div>
                    <div class="col-sm-12" style="text-align: center;">
                        <div class="user-avatar">
                            <span @click="removeAvatar" v-if="showBtnRemoveAvatar" class="remove-avatar"><i class="fas fa-times"></i> </span>
                            <img :src="userAvatar">
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
        userAvatar: "",
        oldUserAvatar: "images/user-avatar/default-avatar.png",
        showBtnRemoveAvatar: false
      }
    },
    methods: {
        imageHasHttp(imageUrl) {
            return imageUrl.indexOf('http') === 0 ? imageUrl : this.$domain + '/' + imageUrl;
        },
        encodeUserProfileFileAsURL(e) {
            let self = this;
            let file = e.target.files[0];
            let reader = new FileReader();
            reader.onloadend = function() {
                self.form.image = reader.result;
            };
            if (file) {
                if (file["size"] < 8000000) {
                    reader.readAsDataURL(file);
                } else {
                    if (this.$i18n.locale == 'ar') {
                        Swal.fire(
                            "خطأ...",
                            "الحجم المسموح به للصورة هو 8 ميجا بايت.",
                            "error"
                        );
                    } else {
                        Swal.fire(
                            "Oops...",
                            "You are uploading a large file, (8MB) last.",
                            "error"
                        );
                    }
                    this.form.image = this.oldUserAvatar;
                }
            } else {
                this.form.image = this.oldUserAvatar;
            }
            e.target.value = ''
        },
        removeAvatar() {
            this.form.image = this.oldUserAvatar
            this.userAvatar = this.imageHasHttp(this.oldUserAvatar)
        }
    },
    watch: {
        "form.image"(val) {
            if (val.indexOf("data:image/") == 0) {
                this.userAvatar = val;
                this.showBtnRemoveAvatar = true
            } else if (val != this.oldUserAvatar && this.typeForm == 'edit') {
                this.showBtnRemoveAvatar = true
            } else if (val == '' || val == null) {
                this.userAvatar = this.imageHasHttp(this.oldUserAvatar);
                this.showBtnRemoveAvatar = false
            } else {
                this.userAvatar = this.imageHasHttp(val);
                this.showBtnRemoveAvatar = false
            }


            // if go to profile only
            if (this.typeForm == 'edit') {
                if (this.form.image != '' && this.form.image.indexOf('data:image/') !== 0) {
                    this.userAvatar = this.imageHasHttp(this.form.image)
                }
            }

        }
    },
    mounted() {
        if (this.typeForm == 'create') {
            this.form.image = this.oldUserAvatar;
        } else {
            let getPhoto = setInterval(() => {
                if (this.form.image != '') {
                    this.userAvatar = this.imageHasHttp(this.form.image)
                    clearInterval(getPhoto)
                }
            }, 500)
        }
    },
  }
</script>
