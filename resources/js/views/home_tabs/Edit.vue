<template>
    <div>
        <!-- Content Header (Page header) -->
        <header-page :title="$t('global.edit') + ' ' + $t('sidebar.home_tabs')"></header-page>
        <!-- /.content-header -->
        <section class="content">
            <div class="container-fluid">

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card">
                            <!-- card-header -->
                            <div class="card-header">
                                <!-- <router-link class="btn btn-primary btn-sm" :to="{name: 'rooms'}">{{ $t('global.show') + ' ' + $t('sidebar.all_rooms') }}</router-link> -->
                            </div>
                            <!-- ./card-header -->


                            <!-- form -->
                            <form @submit.prevent="updateTabs()">
                                <!-- card-body -->
                                <div class="card-body">

                                    <div class="tab-edit">
                                        <div class="row-tab" v-for="(tab, idx) in form.tabs" :key="tab.id">
                                            <h3 class="title-tab">
                                                {{ tab.name }}
                                            </h3>

                                            <div class="wrapper-tab">
                                                <!-- name -->
                                                <div class="form-group">
                                                    <label> {{ $t('home_tabs_table.name') }} <span class="field-required"></span></label>
                                                    <input
                                                        v-model="tab.name"
                                                        type="text"
                                                        :placeholder="$t('home_tabs_table.name')"
                                                        class="form-control"
                                                        :class="{ 'is-invalid': form.errors.has(`tabs.${idx}.name`) }"
                                                    >
                                                    <has-error :form="form" :field="`tabs.${idx}.name`"></has-error>
                                                </div>


                                                <!-- categories -->
                                                <div class="form-group">
                                                    <label> {{ $t('home_tabs_table.categories') }} <span class="field-required"></span></label>
                                                    <v-select
                                                        :options="categoriesSelect"
                                                        v-model="tab.categories"
                                                        multiple
                                                        taggable
                                                        :closeOnSelect="false"
                                                        :searchable="false"
                                                        label="name"
                                                        :reduce="category => category.id"
                                                        dir="rtl"
                                                        :class="{ 'is-invalid': form.errors.has(`tabs.${idx}.categories`) }"
                                                        @input="changeCategories"
                                                    >
                                                        <template v-slot:option="category">
                                                            <span class="image-v-select">
                                                                <img class="image" :src="$domain + category.image">
                                                            </span>
                                                            <span class="label" v-text="category.name"></span>
                                                        </template>
                                                        <div slot="no-options">لا يوجد أقسام.</div>
                                                    </v-select>
                                                    <has-error :form="form" :field="`tabs.${idx}.categories`"></has-error>
                                                </div>

                                                <!-- travels -->
                                                <div class="form-group">
                                                    <label> {{ $t('home_tabs_table.travels') }} <span class="field-required"></span></label>
                                                    <v-select
                                                        :options="tab.original_travels"
                                                        v-model="tab.travels"
                                                        multiple
                                                        taggable
                                                        :closeOnSelect="false"
                                                        :searchable="false"
                                                        label="name"
                                                        :reduce="travel => travel.id"
                                                        dir="rtl"
                                                        class="vs--travels-select"
                                                        :class="{ 'is-invalid': form.errors.has(`tabs.${idx}.travels`) }"
                                                    >
                                                        <template v-slot:option="travel">
                                                            <span class="image-v-select">
                                                                <img class="image" :src="$domain + travel.image">
                                                            </span>
                                                            <div class="label">
                                                                <h3 class="travel-name">{{ travel.name }}</h3>
                                                                <div class="box">
                                                                    <b>الفندق:</b>
                                                                    {{travel.hotel.name}}
                                                                </div>
                                                                <div class="box">
                                                                    <b>المدينة:</b>
                                                                    {{travel.hotel.address}}
                                                                </div>
                                                                <div class="box" v-if="travel.hotel_2 !== null">
                                                                    <b>الفندق الثانى:</b>
                                                                    {{travel.hotel_2.name}}
                                                                </div>
                                                                <div class="box" v-if="travel.hotel_2 !== null">
                                                                    <b>المدينة:</b>
                                                                    {{travel.hotel_2.address}}
                                                                </div>
                                                            </div>
                                                        </template>
                                                        <div slot="no-options">لا يوجد رحلات بهذا القسم.</div>
                                                    </v-select>
                                                    <has-error :form="form" :field="`tabs.${idx}.travels`"></has-error>
                                                </div>
                                            </div>

                                        </div><!-- ./row-tab -->
                                    </div><!-- ./tabs-edit -->


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
import BtnUpdate from './../../components/form/BtnUpdate'
import HeaderPage from './../../components/HeaderPage'

import MixinChangeLocaleMessages from "./../../mixins/MixinChangeLocaleMessages"

export default {
    mixins: [MixinChangeLocaleMessages],
    components: {
        HeaderPage,
        BtnUpdate
    },
    data() {
      return {
        urlModel: '/home_tabs',
        urlGetTravelCategories: '/travel_categories/select',
        categoriesSelect: [],
        form: new Form({
            tabs: []
        }),
        idPage: 'home_tabs',
        typePage: 'edit'
      }
    },

    methods: {
        updateTabs() {
            loadReq(this.$Progress);
            this.form.put(this.urlModel).then(response => {
                if (response.status === 200) {
                    console.log(response.data)
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
        getTabsEdit() {
            axios.get(this.urlModel).then(response => {
                if (response.status === 200) {
                    const data = response.data
                    if (typeof data === 'object') {
                        if (data.tabs != null) {
                            this.form.tabs = data.tabs
                            this.getTravelsByCategories()
                        } else {
                            this.$router.push({name: 'home'})
                        }
                    } else {
                        setTimeout(() => {
                            this.getTabsEdit()
                        }, 1000)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTabsEdit()
                }, 1000)
            })
        },

        changeCategories(value) {
            this.$nextTick(() => {
                this.getTravelsByCategories()
            })
        },

        getTravelCategoriesSelect() {
            axios.get(this.urlGetTravelCategories).then(response => {
                if (response.status === 200) {
                    const data = response.data
                    if (typeof data === 'object') {
                        this.categoriesSelect = response.data.travel_categories
                    } else {
                        setTimeout(() => {
                            this.getTravelCategoriesSelect()
                        }, 1000)
                    }
                }
            })
            .catch(errors => {
                setTimeout(() => {
                    this.getTravelCategoriesSelect()
                }, 1000)
            })
        },

        async getTravelsByCategories() {
            await this.form.tabs.forEach((tab, index) => {
                axios.get('/home_tabs/getTravelsByCategories', {params: {categories: tab.categories}}).then(response => {
                    if (response.status === 200) {
                        const data = response.data
                        if (typeof data === 'object') {
                            this.form.tabs[index].original_travels = response.data.travels
                            const currentTravels = []
                            this.form.tabs[index].travels.forEach(id => {
                                this.form.tabs[index].original_travels.forEach(t => {
                                    if (id === t.id) {
                                        currentTravels.push(id)
                                    }
                                })
                            })
                            this.form.tabs[index].travels = currentTravels
                        } else {
                            setTimeout(() => {
                                this.getTravelsByCategories()
                            }, 1000)
                        }
                    }
                }).catch(errors => {
                    setTimeout(() => {
                        this.getTravelsByCategories()
                    }, 1000)
                })
            })
        }
    },

    mounted() {
        this.getTravelCategoriesSelect()
    },

    beforeRouteEnter(to, from, next) {
        next(vm => {
            to.meta.title = vm.$t('sidebar.home_tabs')
            vm.$nextTick(() => {
                vm.getTabsEdit()
            })
        })
    }
}
</script>
