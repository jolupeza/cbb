import specialityApi from '@/api/speciality';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieve( context, area ) {
    specialityApi.retrieve( area ).then( specialities => {
      context.commit( 'RETRIEVE', specialities );
    });
  }
};

const mutations = {
  RETRIEVE( state, specialities ) {
    state.all = specialities;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
