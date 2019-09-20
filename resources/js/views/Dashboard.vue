<style>


</style>

<template>
    <div>
        <header-page :title="$t('global.dashboard')"></header-page>
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row mt-3">

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ counts.users }}</h3>
                                <p>{{ $t('sidebar.users') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <router-link :to="{name: 'users'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>{{ counts.hotels }}</h3>
                                <p>{{ $t('sidebar.hotels') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <router-link :to="{name: 'hotels'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ counts.rooms }}</h3>
                                <p>{{ $t('sidebar.rooms') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-cubes"></i>
                            </div>
                            <router-link :to="{name: 'rooms'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ counts.travel_programs }}</h3>
                                <p>{{ $t('sidebar.travel_programs') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-server"></i>
                            </div>
                            <router-link :to="{name: 'travel_programs'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ counts.travel_categories }}</h3>
                                <p>{{ $t('sidebar.travel_categories') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <router-link :to="{name: 'travel_categories'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ counts.travels }}</h3>
                                <p>{{ $t('sidebar.travels') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-fighter-jet"></i>
                            </div>
                            <router-link :to="{name: 'travels'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-dark">
                            <div class="inner">
                                <h3>{{ counts.bookings }}</h3>
                                <p>{{ $t('sidebar.bookings') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <router-link :to="{name: 'bookings'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-light">
                            <div class="inner">
                                <h3>{{ counts.mailing_list }}</h3>
                                <p>{{ $t('sidebar.mailing_list') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-mail-bulk"></i>
                            </div>
                            <router-link :to="{name: 'mailing_list'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ counts.blogs }}</h3>
                                <p>{{ $t('sidebar.blogs') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <router-link :to="{name: 'blogs'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->

                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ counts.images }}</h3>
                                <p>{{ $t('sidebar.images') }}</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-images"></i>
                            </div>
                            <router-link :to="{name: 'images'}" class="small-box-footer">
                                {{ $t('global.more_info') }} <i class="fas" :class="$i18n.locale == 'ar' ? 'fa-arrow-circle-left' : 'fa-arrow-circle-right'"></i>
                            </router-link>
                        </div>
                    </div>
                    <!-- ./col -->


                </div>
                <!-- /.row -->

            </div><!--/. container-fluid -->
        </section>
    </div>
</template>


<script>
    import HeaderPage from './../components/HeaderPage'
    export default {
        components: {
            HeaderPage
        },
        data() {
            return {
                counts: {
                    users: 0,
                    hotels: 0,
                    rooms: 0,
                    travel_programs: 0,
                    travel_categories: 0,
                    travels: 0,
                    bookings: 0,
                    mailing_list: 0,
                    blogs: 0,
                    images: 0,
                },
                urlGetCounts: '/models-counts'
            }
        },
        methods: {
            getCountsAllModels() {
                axios.get(this.urlGetCounts).then(response => {
                    if (response.status === 200) {
                        this.counts = response.data.counts
                    }
                })
                .catch(errors => {
                    setTimeout(() => {
                        this.getCountsAllModels()
                    }, 1000)
                });
            }
        },
        mounted() {
            this.$nextTick(() => {
                this.getCountsAllModels()
            })
        },
        beforeRouteEnter (to, from, next) {
            next(vm => {
                to.meta.title = vm.$t('global.dashboard')
            })
        }
    }
</script>
