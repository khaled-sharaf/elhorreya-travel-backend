<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('sidebar.edit_travel_category')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <h3 class="m-0 mb-2 text-dark">
                                    <router-link class="btn btn-primary btn-sm" :to="{name: 'travel_categories'}">{{ $t('global.show') + ' ' + $t('sidebar.all_travel_categories') }}</router-link>
                                </h3>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="updateTravelCategory()" class="form-product">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-travel-category typeForm="edit" :form="form"></form-travel-category>
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
import FormTravelCategory from './Form'
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'
import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormTravelCategory,
        BtnUpdate
    },
    data() {
      return {
        urlModel: '/travel_categories',
        form: new Form({
            id: 0,
            name: '',
            discount: '',
            image: '',
            travel_program_id: '',
            order: '',
        }),
        TravelCategoryEdit: {},
        idPage: 'travel_categories',
        typePage: 'edit'
      }
    },
    methods: {
        updateTravelCategory() {
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                if (response.status === 200) {
                    this.TravelCategoryEdit = response.data.travel_category
                    this.form.fill(this.TravelCategoryEdit)
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
        getTravelCategoryEdit(route) {
            axios.get(this.urlModel + '/' +  route.params.id).then(response => {
                if (response.status === 200) {
                    const travel_category = response.data.travel_category
                    if (travel_category != null) {
                        this.TravelCategoryEdit = travel_category
                        this.form.fill(this.TravelCategoryEdit)
                    } else {
                        this.$router.push({name: 'travel_categories'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelCategoryEdit(this.$route)
                }, 1000)
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_travel_category')
            vm.$nextTick(() => {
                if (to.params.travel_category) {
                    vm.TravelCategoryEdit = to.params.travel_category
                    vm.form.fill(vm.TravelCategoryEdit)
                } else {
                    vm.getTravelCategoryEdit(to)
                }
            })
        })
    }
}
</script>
