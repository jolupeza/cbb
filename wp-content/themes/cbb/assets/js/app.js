require('./bootstrap');

window.Vue = require('vue');
import store from './store'
import VeeValidate, { Validator } from 'vee-validate'
import { dict } from './assets/dict.js'
// import es from 'vee-validate/dist/locale/es'

Vue.use(VeeValidate, {enabledAutoClass: true})

Validator.localize('es', dict)

Vue.component('app-admission', require('./components/Admission/Form.vue'));
Vue.component('app-progress', require('./components/Progress/View.vue'));
Vue.component('app-message', require('./components/Message/View.vue'));

const app = new Vue({
  el: '#app',
  store
});
