import dataCities from '@/assets/resources/cities.json';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieve( context ) {
    if ( null !== localStorage.getItem( 'cities' ) ) {
      localStorage.removeItem( 'cities' );
    }

    context.commit( 'RETRIEVE', dataCities );
  },
  destroy( context ) {
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
