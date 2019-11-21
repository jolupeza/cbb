import degreeApi from '@/api/degree';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieve( context ) {
    if ( null !== localStorage.getItem( 'degrees' ) ) {
      localStorage.removeItem( 'degrees' );
    }

    degreeApi.retrieve().then( degrees => {
      context.commit( 'RETRIEVE', degrees );
    });
  }
};

const mutations = {
  RETRIEVE( state, degrees ) {
    state.all = degrees;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
