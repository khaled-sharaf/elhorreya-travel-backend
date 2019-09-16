import Vue from 'vue'
import Router from 'vue-router'

// default layout and dashboard
import DefaultLayout from './layouts/DefaultLayout'
import Dashboard from './views/Dashboard'
// import DashboardTest from './views/DashboardTest'


// users components
import Users from './views/users/Index'
import CreateUser from './views/users/Create'
import EditUser from './views/users/Edit'


// hotels components
import Hotels from './views/hotels/Index'
import CreateHotel from './views/hotels/Create'
import EditHotel from './views/hotels/Edit'
import HotelProfile from './views/hotels/Profile'


// companies components
// import Companies from './views/companies/Index'
// import CreateCompany from './views/companies/CreateCompany'
// import EditCompany from './views/companies/EditCompany'
// import CompanyProfile from './views/companies/CompanyProfile'



// settings components
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


                ////////////////// company routes ///////////////////
                // {
                //     path: 'companies',
                //     name: 'companies',
                //     component: Companies
                // },
                // {
                //     path: 'company/create',
                //     name: 'create-company',
                //     component: CreateCompany
                // },
                // {
                //     path: 'company/:id/edit',
                //     name: 'edit-company',
                //     component: EditCompany,
                //     props: true
                // },
                // {
                //     path: 'company/profile/:id',
                //     name: 'company-profile',
                //     component: CompanyProfile,
                //     props: true
                // },


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
