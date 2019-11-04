import scheduleApi from './../../api/schedule';

const state = {
  setting: {}
};

const getters = {};

const actions = {
  getSetting (context) {
    scheduleApi.getSetting().then((setting) => {
      context.commit('SET_SETTING', setting);
    }).catch((error) => {
      console.error(error);
    });
  }
};

const mutations = {
  SET_SETTING (state, setting) {
    state.setting = setting;
  }
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
};
