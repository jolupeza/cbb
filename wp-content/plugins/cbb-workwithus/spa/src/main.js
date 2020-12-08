/* globals wpData */

import Vue from 'vue';
import App from './App.vue';
import store from './store';
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import es from 'vee-validate/dist/locale/es';
import 'animate.css/animate.css';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';
import helpers from '@/helpers';

require( './bootstrap' );

Vue.config.productionTip = false;

for ( const rule in rules ) {
  extend( rule, {
    ...rules[rule],
    message: es.messages[rule]
  });
}

extend( 'mimes', {
  message: ( field, values ) => 'El archivo cargado no es válido.'
});

Vue.component( 'ValidationProvider', ValidationProvider );
Vue.component( 'ValidationObserver', ValidationObserver );

window.wpData = wpData;
Object.defineProperty( Vue.prototype, 'wpData', { value: wpData });
Object.defineProperty( Vue.prototype, '$helpers', { value: helpers });

new Vue({
  store,
  render: h => h( App )
}).$mount( '#wp-vue-workwithus' );
