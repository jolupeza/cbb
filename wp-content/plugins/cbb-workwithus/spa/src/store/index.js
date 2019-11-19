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
    modal: false,
    loading: false,
    message: {
      type: 'danger',
      msg: '',
      show: false
    }
  },
  mutations: {
    SET_STEP( state, step ) {
      state.step = step;
    },
    SET_MODAL( state, status ) {
      state.modal = status;
    },
    SET_LOADING( state, status ) {
      state.loading = status;
    },
    SET_MESSAGE( state, { type, msg, show }) {
      state.message.type = type;
      state.message.msg = msg;
      state.message.show = show;
    }
  },
  actions: {
    setStep( context, step ) {
      context.commit( 'SET_STEP', step );
    },
    setModal( context, status ) {
      context.commit( 'SET_MODAL', status );
    },
    setStatusLoading( context, status ) {
      context.commit( 'SET_LOADING', status );
    },
    setMessage( context, { type, msg, show }) {
      context.commit( 'SET_MESSAGE', { type, msg, show });
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
