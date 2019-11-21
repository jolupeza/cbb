import specialtyApi from '@/api/specialty';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieve( context ) {
    if ( null !== localStorage.getItem( 'specialties' ) ) {
      localStorage.removeItem( 'specialties' );
    }

    specialtyApi.retrieve().then( specialties => {
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
