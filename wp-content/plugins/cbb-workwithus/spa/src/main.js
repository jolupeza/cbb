import Vue from 'vue';
import App from './App.vue';
import store from './store';
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import es from 'vee-validate/dist/locale/es';
import helpers from '@/helpers';

require( './bootstrap' );

Vue.config.productionTip = false;

for ( let rule in rules ) {
  extend( rule, {
    ...rules[rule],
    message: es.messages[rule]
  });
}

Vue.component( 'ValidationProvider', ValidationProvider );
Vue.component( 'ValidationObserver', ValidationObserver );

Object.defineProperty( Vue.prototype, '$helpers', { value: helpers });

new Vue({
  store,
  render: h => h( App )
}).$mount( '#wp-vue-workwithus' );
