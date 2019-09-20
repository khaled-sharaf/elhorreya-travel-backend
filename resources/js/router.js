import Vue from 'vue'
import Router from 'vue-router'

// default layout and dashboard
import DefaultLayout from './layouts/DefaultLayout'
import Dashboard from './views/Dashboard'
// import DashboardTest from './views/DashboardTest'


// users
import Users from './views/users/Index'
import CreateUser from './views/users/Create'
import EditUser from './views/users/Edit'


// hotels
import Hotels from './views/hotels/Index'
import CreateHotel from './views/hotels/Create'
import EditHotel from './views/hotels/Edit'
import HotelProfile from './views/hotels/Profile'


// rooms
import Rooms from './views/rooms/Index'
import CreateRoom from './views/rooms/Create'
import EditRoom from './views/rooms/Edit'


// travel programs
import travelPrograms from './views/travel_programs/Index'
import CreateTravelProgram from './views/travel_programs/Create'
import EditTravelProgram from './views/travel_programs/Edit'


// travel categories
import travelCategories from './views/travel_categories/Index'
import CreateTravelCategory from './views/travel_categories/Create'
import EditTravelCategory from './views/travel_categories/Edit'


// settings
import Settings from './views/settings/Index'
import CreateSetting from './views/settings/Create'
import EditSetting from './views/settings/Edit'


Vue.use(Router)

var pathRoute = ''

if (process.env.NODE_ENV === 'production') {
    pathRoute = '/' + window.cp_prefix
} else {
    pathRoute = '/Belal/horreya/horreya_backend/public/' + window.cp_prefix
}
const vueRouter = new Router({
    mode: 'history',
    base: pathRoute,
    // base: process.env.BASE_URL,
    linkExactActiveClass: 'active',
    routes: [
        {
            path: '/',
            name: 'default-layout',
            component: DefaultLayout,
            children: [
                {
                    path: '/dashboard',
                    name: 'home',
                    component: Dashboard
                },

                ////////////////// users routes ///////////////////
                {
                    path: 'users',
                    name: 'users',
                    component: Users
                },
                {
                    path: 'user/create',
                    name: 'create-user',
                    component: CreateUser
                },
                {
                    path: 'user/:id/edit',
                    name: 'edit-user',
                    component: EditUser,
                    props: true
                },


                ////////////////// hotels routes ///////////////////
                {
                    path: 'hotels',
                    name: 'hotels',
                    component: Hotels
                },
                {
                    path: 'hotel/create',
                    name: 'create-hotel',
                    component: CreateHotel
                },
                {
                    path: 'hotel/:id/edit',
                    name: 'edit-hotel',
                    component: EditHotel,
                    props: true
                },
                {
                    path: 'hotel/profile/:id',
                    name: 'hotel-profile',
                    component: HotelProfile,
                    props: true
                },


                ////////////////// rooms routes ///////////////////
                {
                    path: 'rooms',
                    name: 'rooms',
                    component: Rooms
                },
                {
                    path: 'room/create',
                    name: 'create-room',
                    component: CreateRoom
                },
                {
                    path: 'room/:id/edit',
                    name: 'edit-room',
                    component: EditRoom,
                    props: true
                },


                ////////////////// travel programs routes ///////////////////
                {
                    path: 'travel_programs',
                    name: 'travel_programs',
                    component: travelPrograms
                },
                {
                    path: 'travel_program/create',
                    name: 'create-travel_program',
                    component: CreateTravelProgram
                },
                {
                    path: 'travel_program/:id/edit',
                    name: 'edit-travel_program',
                    component: EditTravelProgram,
                    props: true
                },


                ////////////////// travel categories routes ///////////////////
                {
                    path: 'travel_categories',
                    name: 'travel_categories',
                    component: travelCategories
                },
                {
                    path: 'travel_category/create',
                    name: 'create-travel_category',
                    component: CreateTravelCategory
                },
                {
                    path: 'travel_category/:id/edit',
                    name: 'edit-travel_category',
                    component: EditTravelCategory,
                    props: true
                },


                ////////////////// settings routes ///////////////////
                {
                    path: 'settings',
                    name: 'settings',
                    component: Settings
                },
                {
                    path: 'setting/create',
                    name: 'create-setting',
                    component: CreateSetting
                },
                {
                    path: 'setting/:id/edit',
                    name: 'edit-setting',
                    component: EditSetting,
                    props: true
                }
            ]
        },
        {
            path: '*',
            redirect: { name: 'home' }
        }
    ]
})

vueRouter.beforeEach((to, from, next) => {
    setTimeout(() => {
        const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);
        // If a route with a title was found, set the document (page) title to that value.
        if(nearestWithTitle) document.title = nearestWithTitle.meta.title;
    })
  next();
});


export default vueRouter
