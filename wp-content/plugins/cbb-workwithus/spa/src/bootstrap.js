window.axios = require( 'axios' );

window.clone = function( obj ) {
  return JSON.parse( JSON.stringify( obj ) );
};

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = document.head.querySelector( 'meta[name="csrf-token"]' );

if ( token ) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// } else {
// console.error( 'CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token' );

window.axios.interceptors.response.use( function( response ) {
  return response;
}, function( error ) {
  return Promise.reject( error );
});
