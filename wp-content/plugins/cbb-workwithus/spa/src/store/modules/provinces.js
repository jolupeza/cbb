import dataProvinces from '@/assets/resources/provinces.json';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieveByCity( context, idCity ) {
    return new Promise( ( resolve ) => {
      let provinces = dataProvinces.filter( province => {
        return province.department_id === idCity;
      });

      context.commit( 'RETRIEVE', provinces );
      resolve();
    });
  },
  destroy( context ) {
    context.commit( 'DESTROY' );
  }
};

const mutations = {
  RETRIEVE( state, provinces ) {
    state.all = provinces;
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
