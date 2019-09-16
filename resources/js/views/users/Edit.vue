<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('global.edit') + ' ' + ($auth.id == $route.params.id ? $t('global.the_profile') : $t('global.user'))"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <router-link class="btn btn-primary btn-sm" :to="{name: 'users'}">{{ $t('global.show') + ' ' + $t('sidebar.all_users') }}</router-link>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="updateUser()">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-user typeForm="edit" :form="form"></form-user>
                                </div>
                                <!-- ./card-body -->


                                <!-- card-footer -->
                                <div class="card-footer">
                                    <button
                                        type="submit"
                                        :disabled="form.busy"
                                        class="btn btn-success float-right"
                                    > {{ $t('global.update') }} </button>
                                </div> <!-- ./card-footer -->

                            </form><!-- form -->
                        </div>
                    </div><!-- /.col-12 -->

                </div><!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
    </div>
</template>


<script>
import FormUser from './Form'
import HeaderPage from './../../components/HeaderPage'

import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormUser
    },
    data() {
      return {
        urlModel: '/users',
        form: new Form({
          id: "",
          name: "",
          email: "",
          password: "",
          password_confirmation: "",
          image: ""
        }),
        userEdit: {},
        idPage: 'users',
        typePage: 'edit'
      }
    },
    methods: {
        updateUser() {
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                if (response.status === 200) {
                    ToastReq.fire({
                        text: this.success_msg
                    });
                }
            }).catch(response => {
                ToastFailed.fire({
                    title: this.failed_title + "!",
                    text: this.failed_msg,
                })
                this.$Progress.fail();
            });
        },
        getUserEdit(route) {
            axios.get(this.urlModel + '/' + route.params.id).then(response => {
                if (response.status === 200) {
                    const user = response.data.user
                    if (user != null) {
                        this.userEdit = user
                        this.form.reset()
                        this.form.fill(this.userEdit)
                    } else {
                        this.$router.push({name: 'users'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getUserEdit(this.$route)
                }, 1000)
            })
        }
    },
    watch: {
        "$route.params.id"(val) {
            if (this.$route.params.user) {
                this.userEdit = this.$route.params.user
                this.form.reset()
                this.form.fill(this.userEdit)
            } else {
                this.getUserEdit(this.$route)
            }
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_user')
            if (to.params.user) {
                vm.userEdit = to.params.user
                vm.form.reset()
                vm.form.fill(vm.userEdit)
            } else {
                vm.getUserEdit(to)
            }
        })
    }
}
</script>
