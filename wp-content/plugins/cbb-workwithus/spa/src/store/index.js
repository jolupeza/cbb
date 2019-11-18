import Vue from 'vue';
import Vuex from 'vuex';
import cities from '@/store/modules/cities';
import provinces from '@/store/modules/provinces';
import districts from '@/store/modules/districts';
import applications from '@/store/modules/applications';
import jobDegrees from '@/store/modules/jobDegrees';
import jobSpecialties from '@/store/modules/jobSpecialties';

Vue.use( Vuex );

export default new Vuex.Store({
  state: {
    step: 1,
    modal: false
  },
  mutations: {
    SET_STEP( state, step ) {
      state.step = step;
    },
    SET_MODAL( state, status ) {
      state.modal = status;
    }
  },
  actions: {
    setStep( context, step ) {
      context.commit( 'SET_STEP', step );
    },
    setModal( context, status ) {
      context.commit( 'SET_MODAL', status );
    }
  },
  modules: {
    cities,
    provinces,
    districts,
    applications,
    jobDegrees,
    jobSpecialties
  }
});
