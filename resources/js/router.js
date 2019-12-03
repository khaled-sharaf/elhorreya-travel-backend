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


// marketing_hotels
import MarketingHotels from './views/marketing_hotels/Index'
import CreateMarketingHotel from './views/marketing_hotels/Create'
import EditMarketingHotel from './views/marketing_hotels/Edit'
import MarketingHotelProfile from './views/marketing_hotels/Profile'


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


// travels
import Travels from './views/travels/Index'
import CreateTravel from './views/travels/Create'
import EditTravel from './views/travels/Edit'
import TravelProfile from './views/travels/Profile'

// bookings
import Bookings from './views/bookings/Index'

// mailing_list
import MailingList from './views/mailing_list/Index'

// blogs
import Blogs from './views/blogs/Index'
import CreateBlog from './views/blogs/Create'
import EditBlog from './views/blogs/Edit'


// images
import Images from './views/images/Index'
import CreateImage from './views/images/Create'
import EditImage from './views/images/Edit'


// contact_us
import ContactUs from './views/contact_us/Index'


// contact_infos
import ContactInfos from './views/contact_infos/Index'
import CreateContactInfo from './views/contact_infos/Create'
import EditContactInfo from './views/contact_infos/Edit'


// settings
import Settings from './views/settings/Index'
import CreateSetting from './views/settings/Create'
import EditSetting from './views/settings/Edit'

// home_tabs
import HomeTabs from './views/home_tabs/Edit'


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


                ////////////////// marketing_hotels routes ///////////////////
                {
                    path: 'marketing_hotels',
                    name: 'marketing_hotels',
                    component: MarketingHotels
                },
                {
                    path: 'marketing_hotel/create',
                    name: 'create-marketing_hotel',
                    component: CreateMarketingHotel
                },
                {
                    path: 'marketing_hotel/:id/edit',
                    name: 'edit-marketing_hotel',
                    component: EditMarketingHotel,
                    props: true
                },
                {
                    path: 'marketing_hotel/profile/:id',
                    name: 'marketing_hotel-profile',
                    component: MarketingHotelProfile,
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


                ////////////////// travels routes ///////////////////
                {
                    path: 'travels',
                    name: 'travels',
                    component: Travels
                },
                {
                    path: 'travel/create',
                    name: 'create-travel',
                    component: CreateTravel
                },
                {
                    path: 'travel/:id/edit',
                    name: 'edit-travel',
                    component: EditTravel,
                    props: true
                },
                {
                    path: 'travel/profile/:id',
                    name: 'travel-profile',
                    component: TravelProfile,
                    props: true
                },


                ////////////////// bookings routes ///////////////////
                {
                    path: 'bookings',
                    name: 'bookings',
                    component: Bookings
                },


                ////////////////// MailingList routes ///////////////////
                {
                    path: 'mailing_list',
                    name: 'mailing_list',
                    component: MailingList
                },


                ////////////////// blogs routes ///////////////////
                {
                    path: 'blogs',
                    name: 'blogs',
                    component: Blogs
                },
                {
                    path: 'blog/create',
                    name: 'create-blog',
                    component: CreateBlog
                },
                {
                    path: 'blog/:id/edit',
                    name: 'edit-blog',
                    component: EditBlog,
                    props: true
                },


                ////////////////// images routes ///////////////////
                {
                    path: 'images',
                    name: 'images',
                    component: Images
                },
                {
                    path: 'image/create',
                    name: 'create-image',
                    component: CreateImage
                },
                {
                    path: 'image/:id/edit',
                    name: 'edit-image',
                    component: EditImage,
                    props: true
                },



                ////////////////// contact_us routes ///////////////////
                {
                    path: 'contact_us',
                    name: 'contact_us',
                    component: ContactUs
                },



                ////////////////// contact_infos routes ///////////////////
                {
                    path: 'contact_infos',
                    name: 'contact_infos',
                    component: ContactInfos
                },
                {
                    path: 'branch/create',
                    name: 'create-contact_info',
                    component: CreateContactInfo
                },
                {
                    path: 'branch/:id/edit',
                    name: 'edit-contact_info',
                    component: EditContactInfo,
                    props: true
                },



                ////////////////// settings routes ///////////////////
                {
                    path: 'settings',
                    name: 'settings',
                    component: Settings
                },
                // {
                //     path: 'setting/create',
                //     name: 'create-setting',
                //     component: CreateSetting
                // },
                {
                    path: 'setting/:id/edit',
                    name: 'edit-setting',
                    component: EditSetting,
                    props: true
                },




                ////////////////// Home Tabs routes ///////////////////
                {
                    path: 'home_tabs',
                    name: 'home_tabs',
                    component: HomeTabs
                },
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
