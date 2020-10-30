import formApi from './../../api/form';

const state = {
  items: {
    parent_name: null,
    parent_dni: null
  },
    labelTerms: ''
};

const getters = {};

const actions = {
    getLabelTerms({commit}) {
        formApi.getLabelTerms()
            .then(labelTerms => {
                commit('SET_LABEL_TERMS', labelTerms);
            });
    }
};

const mutations = {
    SET_LABEL_TERMS(state, labelTerms) {
        state.labelTerms = labelTerms;
    }
};

const methods = {};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
    methods
};
