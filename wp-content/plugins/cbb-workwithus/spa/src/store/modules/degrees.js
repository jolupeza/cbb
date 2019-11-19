import degreeApi from '@/api/degree';

const state = {
  all: JSON.parse( localStorage.getItem( 'degrees' ) ) || []
};

const getters = {};

const actions = {
  retrieve( context ) {
    degreeApi.retrieve().then( degrees => {
      localStorage.setItem( 'degrees', JSON.stringify( degrees ) );
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
