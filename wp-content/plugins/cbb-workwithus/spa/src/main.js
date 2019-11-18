import Vue from 'vue';
import App from './App.vue';
import store from './store';
import { ValidationProvider, ValidationObserver, extend } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import es from 'vee-validate/dist/locale/es';

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

new Vue({
  store,
  render: h => h( App )
}).$mount( '#wp-vue-workwithus' );
