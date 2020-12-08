import dataDistricts from '@/assets/resources/districts.json';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieveByProvince({ commit }, idProvince ) {
    return new Promise( ( resolve ) => {
      const districts = dataDistricts.filter( district => {
        return district.province_id === idProvince;
      });

      commit( 'RETRIEVE', districts );
      resolve();
    });
  },
  destroy( context ) {
    context.commit( 'DESTROY' );
  }
};

const mutations = {
  RETRIEVE( state, districts ) {
    state.all = districts;
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
