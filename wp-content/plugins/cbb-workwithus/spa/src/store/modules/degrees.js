import degreeApi from '@/api/degree';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieve( context, areaId ) {
    degreeApi.retrieve( areaId ).then( degrees => {
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
