import cityApi from '@/api/city';

const state = {
  all: JSON.parse( localStorage.getItem( 'cities' ) ) || []
};

const getters = {};

const actions = {
  retrieve( context ) {
    cityApi.retrieve().then( cities => {
      localStorage.setItem( 'cities', JSON.stringify( cities ) );
      context.commit( 'RETRIEVE', cities );
    }).catch( error => {
      console.error( error );
    });
  },
  destroy( context ) {
    localStorage.removeItem( 'cities' );
    context.commit( 'DESTROY' );
  }
};

const mutations = {
  RETRIEVE( state, cities ) {
    state.all = cities;
  },
  DESTROY( state ) {
    state.all = [];
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
