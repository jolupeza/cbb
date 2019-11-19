import specialtyApi from '@/api/specialty';

const state = {
  all: JSON.parse( localStorage.getItem( 'specialties' ) ) || []
};

const getters = {};

const actions = {
  retrieve( context ) {
    specialtyApi.retrieve().then( specialties => {
      localStorage.setItem( 'specialties', JSON.stringify( specialties ) );
      context.commit( 'RETRIEVE', specialties );
    });
  }
};

const mutations = {
  RETRIEVE( state, specialties ) {
    state.all = specialties;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
