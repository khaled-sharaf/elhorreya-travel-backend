
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
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <upload-image
                                :form="form"
                                propertyName="image"
                                :required="false"
                                :defaultSrcImage="defaultUserAvatar"
                                :maxSize="3150000"
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
        defaultUserAvatar: "images/user-avatar/default-avatar.png",
      }
    }
  }
</script>
