<style>


</style>

<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('global.edit') + ' ' + $t('global.room')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <router-link class="btn btn-primary btn-sm" :to="{name: 'rooms'}">{{ $t('global.show') + ' ' + $t('sidebar.all_rooms') }}</router-link>
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="updateRoom()">
                                <!-- card-body -->
                                <div class="card-body">
                                    <form-room typeForm="edit" :form="form"></form-room>
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
import FormRoom from './Form'
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'

import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        FormRoom,
        BtnUpdate
    },
    data() {
      return {
        urlModel: '/rooms',
        form: new Form({
            id: '',
            info: '',
            options: '',
            price_night: '',
            offer_days: '',
            offer_price: '',
            hotel_id: '',
            display: 1,
        }),
        roomEdit: {},
        idPage: 'rooms',
        typePage: 'edit'
      }
    },
    methods: {
        updateRoom() {
            loadReq(this.$Progress);
            this.form.put(this.urlModel + '/' + this.form.id).then(response => {
                if (response.status === 200) {
                    this.roomEdit = response.data.room
                    this.form.fill(this.roomEdit)
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
        getRoomEdit(route) {
            axios.get(this.urlModel + '/' + route.params.id).then(response => {
                if (response.status === 200) {
                    const room = response.data.room
                    if (room != null) {
                        this.roomEdit = room
                        this.form.fill(this.roomEdit)
                    } else {
                        this.$router.push({name: 'rooms'})
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getRoomEdit(this.$route)
                }, 1000)
            })
        }
    },
    watch: {

    },
    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.edit_room')
            vm.$nextTick(() => {
                if (to.params.room) {
                    vm.roomEdit = to.params.room
                    vm.form.fill(vm.roomEdit)
                } else {
                    vm.getRoomEdit(to)
                }
            })
        })
    }
}
</script>
