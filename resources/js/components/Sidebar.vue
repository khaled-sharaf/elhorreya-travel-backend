<style lang="scss">

</style>

<template>
    <div class="sidebar-layout">
        <aside class="main-sidebar elevation-4 sidebar-dark-warning">
            <!-- Brand Logo -->
            <router-link :to="{name: 'home'}" class="brand-link">
                <img :src="$domain + $settings.logo" alt="logo" class="brand-image">
                <!-- <img :src="$domain + '/' + $settings.logo" :alt="$settings.site_name + ' logo'" class="brand-image"> -->
                <!-- <span class="brand-text font-weight-light">{{ $settings.site_name_ar }}</span> -->
            </router-link>

            <!-- Sidebar -->
            <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="$domain + '/' + $auth.image" class="img-circle elevation-2" alt="Admin Image">
                </div>
                <div class="info">
                    <router-link class="d-block" :to="{name: 'edit-user', params: {user: $auth, id: $auth.id}}">{{ $auth.name }}</router-link>
                </div>
            </div>

            <!-- Sidebar Menu-->
             <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" id="nav-sidebar-global" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->

                    <!-- <li class="nav-item has-treeview menu-open"> -->

                    <!-- =============================== Dashboard ================================== -->
                    <li class="nav-item">
                        <router-link :to="{name: 'home'}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            {{$t('global.dashboard')}}
                            <!-- <span class="right badge badge-danger">New</span> -->
                        </p>
                        </router-link>
                    </li>


                    <!-- =============================== users ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                {{ $t('sidebar.users') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                                <!-- <span class="badge badge-info right">130</span> -->
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'users'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_users') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-user'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_user') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                    <!-- =============================== marketing_hotels ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-building"></i>
                            <p>
                                {{ $t('sidebar.marketing_hotels') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'marketing_hotels'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_marketing_hotels') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-marketing_hotel'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_marketing_hotel') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                    <!-- =============================== hotels ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-building"></i>
                            <p>
                                {{ $t('sidebar.hotels') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'hotels'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_hotels') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-hotel'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_hotel') }} </p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="{name: 'rooms'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_rooms') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-room'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_room') }} </p>
                                </router-link>
                            </li>


                        </ul>
                    </li>


                    <!-- =============================== rooms ================================== -->
                    <!-- <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cubes"></i>
                            <p>
                                {{ $t('sidebar.rooms') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                        </ul>
                    </li> -->



                    <!-- =============================== travel programs ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-server"></i>
                            <p>
                                {{ $t('sidebar.travel_programs') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'travel_programs'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_travel_programs') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-travel_program'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_travel_program') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>



                    <!-- =============================== travel categories ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-project-diagram"></i>
                            <p>
                                {{ $t('sidebar.travel_categories') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'travel_categories'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.travel_categories') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-travel_category'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_travel_category') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>



                    <!-- =============================== travels ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-fighter-jet"></i>
                            <p>
                                {{ $t('sidebar.travels') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'travels'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_travels') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-travel'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_travel') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                    <!-- =============================== bookings ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                {{ $t('sidebar.bookings') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'bookings'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_bookings') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>



                    <!-- =============================== mailing_list ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-mail-bulk"></i>
                            <p>
                                {{ $t('sidebar.mailing_list') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'mailing_list'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_mailing_list') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                    <!-- =============================== blogs ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>
                                {{ $t('sidebar.blogs') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'blogs'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_blogs') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-blog'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_blog') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                    <!-- =============================== images ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-images"></i>
                            <p>
                                {{ $t('sidebar.images') }}
                                <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'images'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_images') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-image'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_image') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>



                    <!-- =============================== contact us ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-envelope"></i>
                        <p>
                            {{ $t('sidebar.contact_us') }}
                            <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'contact_us'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_contact_us') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                    <!-- =============================== contact_infos ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-phone"></i>
                        <p>
                            {{ $t('sidebar.contact_infos') }}
                            <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'contact_infos'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_contact_infos') }} </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{name: 'create-contact_info'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_contact_info') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>


                    <!-- =============================== settings ================================== -->
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            {{ $t('sidebar.settings') }}
                            <i class="fas right" :class="$i18n.locale == 'ar' ? 'fa-angle-right' : 'fa-angle-left'"></i>
                        </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <router-link :to="{name: 'settings'}" class="nav-link">
                                    <i class="far fa-eye nav-icon"></i>
                                    <p> {{ $t('global.show') + ' ' + $t('sidebar.all_settings') }} </p>
                                </router-link>
                            </li>
                            <!-- <li class="nav-item">
                                <router-link :to="{name: 'create-setting'}" class="nav-link">
                                    <i class="fas fa-plus nav-icon"></i>
                                    <p> {{ $t('global.create') + ' ' + $t('sidebar.new_setting') }} </p>
                                </router-link>
                            </li> -->
                            <li class="nav-item">
                                <router-link :to="{name: 'home_tabs'}" class="nav-link">
                                    <i class="fas fa-image nav-icon"></i>
                                    <p> {{ $t('sidebar.home_tabs') }} </p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                </ul>

            </nav>

            <!-- /.sidebar-menu -->

            </div>
            <!-- /.sidebar -->
        </aside>
    </div>
</template>


<script>

export default {
    name: 'sidebar',
    data() {
        return {
        }
    },
    mounted() {

    }
}
</script>
