// const domain = 'http://localhost:8000'

require('./bootstrap');

window.Vue = require('vue');

Vue.config.productionTip = false

// global properties

Vue.prototype.$domain = window.url
Vue.prototype.$auth = window.auth
Vue.prototype.$settings = window.settings
Vue.prototype.$domain_admin = window.url + window.cp_prefix
Vue.prototype.$nameSettingsInDB = 'data_tabel_settings_view_columns'



/**************************************************************************************/


import i18n from './plugins/i18n' // localization
import App from './App.vue'
import router from './router'

/**************************************************************************************/

// select 2
import './plugins/select2/select2.min.css'
import './plugins/select2/select2.min.js'

// overlayScrollbars
import './plugins/overlayScrollbars/OverlayScrollbars.min.css'
import './plugins/overlayScrollbars/jquery.overlayScrollbars.min.js'

// json-excel
import './plugins/excel-export.js'

// vue2-editor
import './plugins/vue2-editor.js'

// vSelect
import './plugins/vSelect.js'


import './plugins/progressBar.js'
import './components.js'
import './filters.js'
import './directives.js'

/**************************************************************************************/
// paginate

import Paginate from 'vuejs-paginate'
Vue.component('paginate', Paginate)
/**************************************************************************************/

import { Form, HasError, AlertError, AlertErrors, AlertSuccess } from "vform";
window.Form = Form;
// vue form
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component(AlertErrors.name, AlertErrors);
Vue.component(AlertSuccess.name, AlertSuccess);

/**************************************************************************************/



import Swal from "sweetalert2";
window.Swal = Swal;

const ToastReq = Swal.mixin({
    position: "top-end",
    showConfirmButton: false,
    timer: 1500,
    type: "success",
});
const ToastFailed = Swal.mixin({
    showConfirmButton: false,
    type: 'error',
    // timer: 1500,
});
window.ToastReq = ToastReq;
window.ToastFailed = ToastFailed;

/**************************************************************************************/
import DatePicker from 'vue2-datepicker';
Vue.component(DatePicker.name, DatePicker);

/**************************************************************************************/


const app = new Vue({
  i18n,
  router,
  render: h => h(App)
}).$mount('#app')

