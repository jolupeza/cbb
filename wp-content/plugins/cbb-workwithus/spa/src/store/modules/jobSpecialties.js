import jobSpecialtyApi from '@/api/jobSpecialty';

const state = {
  all: JSON.parse( localStorage.getItem( 'jobspecialties' ) ) || []
};

const getters = {};

const actions = {
  retrieve( context ) {
    jobSpecialtyApi.retrieve().then( jobSpecialties => {
      localStorage.setItem( 'jobspecialties', JSON.stringify( jobSpecialties ) );
      context.commit( 'RETRIEVE', jobSpecialties );
    });
  }
};

const mutations = {
  RETRIEVE( state, jobSpecialties ) {
    state.all = jobSpecialties;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
