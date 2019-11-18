import jobDegreeApi from '@/api/jobDegree';

const state = {
  all: JSON.parse( localStorage.getItem( 'jobdegrees' ) ) || []
};

const getters = {};

const actions = {
  retrieve( context ) {
    jobDegreeApi.retrieve().then( jobDegrees => {
      localStorage.setItem( 'jobdegrees', JSON.stringify( jobDegrees ) );
      context.commit( 'RETRIEVE', jobDegrees );
    });
  }
};

const mutations = {
  RETRIEVE( state, jobdegrees ) {
    state.all = jobdegrees;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
