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
                        <div class="small-box bg-warning">
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
                    hotels: 0
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
            this.getCountsAllModels()
        },
        beforeRouteEnter (to, from, next) {
            next(vm => {
                to.meta.title = vm.$t('global.dashboard')
            })
        }
    }
</script>
