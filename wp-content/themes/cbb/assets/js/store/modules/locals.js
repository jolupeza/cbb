import localApi from './../../api/local'

const state = {
  all: []
}

const getters = {}

const actions = {
  getAllLocals({ dispatch, commit }) {
    return new Promise((resolve, reject) => {
      localApi.getLocals()
        .then(locals => {
          commit('setLocals', locals)
          resolve()
        })
        .catch(err => {
          let info = {type: 'danger', text: err.message, display: true}
          dispatch('setMessage', info, { root: true })
          reject()
        })
    })
  }
}

const mutations = {
  setLocals(state, locals) {
    state.all = locals
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
