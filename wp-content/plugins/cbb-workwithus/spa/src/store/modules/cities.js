import cityApi from '@/api/city';
import dataCities from '@/assets/resources/cities.json';

const state = {
  all: JSON.parse( localStorage.getItem( 'cities' ) ) || []
};

const getters = {};

const actions = {
  byJson( context ) {
    context.commit( 'RETRIEVE', dataCities );
  },
  retrieve( context ) {
    cityApi.retrieve().then( cities => {
      localStorage.setItem( 'cities', JSON.stringify( cities ) );
      context.commit( 'RETRIEVE', cities );
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
