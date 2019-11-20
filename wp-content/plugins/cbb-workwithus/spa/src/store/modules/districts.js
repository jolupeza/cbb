import districtApi from '@/api/district';
import dataDistricts from '@/assets/resources/districts.json';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieve({ commit }, idProvince ) {
    return new Promise( ( resolve ) => {
      let districts = dataDistricts.filter( district => {
        return district.province_id === idProvince;
      });

      commit( 'RETRIEVE', districts );
      resolve();
    });
  },
  retrieveByProvince( context, idProvince ) {
    return new Promise( ( resolve, reject ) => {
      districtApi.retrieveByProvince( idProvince ).then( districts => {
        context.commit( 'RETRIEVE', districts );
        resolve();
      }).catch( error => {
        console.error( error );
        reject( error );
      });
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
