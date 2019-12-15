import degreeApi from '@/api/degree';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieve( context, levelId ) {
    degreeApi.retrieve( levelId ).then( degrees => {
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
