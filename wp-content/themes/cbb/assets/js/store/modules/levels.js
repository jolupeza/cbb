import levelApi from './../../api/level'

const state = {
  all: []
}

const getters = {}

const actions = {
  getAllLevels({ dispatch, commit }) {
    return new Promise((resolve, reject) => {
      levelApi.getLevels()
        .then(levels => {
          commit('setLevels', levels);
          resolve();
        })
        .catch(err => {
          let info = {type: 'danger', text: err.message, display: true}
          dispatch('setMessage', info, { root: true });
          reject();
        })
    })
  }
}

const mutations = {
  setLevels(state, levels) {
    state.all = levels
  }
}

const methods = {}

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations
}
