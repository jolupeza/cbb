import provinceApi from '@/api/province';

const state = {
  all: []
};

const getters = {};

const actions = {
  retrieveByCity( context, idCity ) {
    return new Promise( ( resolve, reject ) => {
      provinceApi.retrieveByCity( idCity ).then( provinces => {
        context.commit( 'RETRIEVE', provinces );
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
  RETRIEVE( state, cities ) {
    state.all = cities;
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
