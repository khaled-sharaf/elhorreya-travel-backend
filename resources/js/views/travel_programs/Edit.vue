<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('sidebar.edit_travel_program')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <h3 class="m-0 mb-2 text-dark">
                                    <router-link class="btn btn-primary btn-sm" :to="{name: 'travel_programs'}">{{ $t('global.show') + ' ' + $t('sidebar.all_travel_programs') }}</router-link>
                                </h3>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="updateTravelProgram()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-travel-program typeForm="edit" :form="form"></form-travel-program>
                                </div>
                                <!-- ./card-body -->


                                <!-- card-footer -->
                                <div class="card-footer">
                                    <btn-update :form="form"></btn-update>
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
import FormTravelProgram from './Form'
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormTravelProgram,
        BtnUpdate
    },
    data() {
      return {
        urlModel: '/travel_programs',
        form: new Form({
            id: 0,
            name: '',
            image: '',
            small_info: '',
            big_info: '',
            order: '',
        }),
        travelProgramEdit: {},
        idPage: 'travel_programs',
        typePage: 'edit'
      }
    },
    methods: {
        updateTravelProgram() {
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                if (response.status === 200) {
                    this.travelProgramEdit = response.data.data;
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
        getTravelProgramEdit(route) {
            axios.get(this.urlModel + '/' +  route.params.id).then(response => {
                if (response.status === 200) {
                    const travel_program = response.data.travel_program
                    if (travel_program != null) {
                        this.travelProgramEdit = travel_program
                        this.form.fill(this.travelProgramEdit)
                    } else {
                        this.$router.push({name: 'travel_programs'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelProgramEdit(this.$route)
                }, 1000)
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_travel_program')
            vm.$nextTick(() => {
                if (to.params.travel_program) {
                    vm.travelProgramEdit = to.params.travel_program
                    vm.form.fill(vm.travelProgramEdit)
                } else {
                    vm.getTravelProgramEdit(to)
                }
            })
        })
    }
}
</script>
