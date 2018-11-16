import Vue from 'vue'
import Vuex from 'vuex'
import locals from './modules/locals'
import levels from './modules/levels'
import form from './modules/form.js'
import date from './modules/date.js'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    inProgress: false,
    message: {
      type: null,
      text: null,
      display: false
    }
  },
  modules: {
    locals,
    levels,
    form,
    date
  },
  actions: {
    setInProgress(context, value) {
      context.commit('setInProgress', value)
    },
    setMessage(context, { type, text, display }) {
      context.commit('setMessage', { type, text, display })
    }
  },
  mutations: {
    setInProgress(state, value) {
      state.inProgress = value;
    },
    setMessage(state, { type, text, display }) {
      state.message.type = type
      state.message.text = text
      state.message.display = display

      setTimeout(() => {
        state.message.type = null
        state.message.text = null
        state.message.display = false
      }, 3000)
    }
  }
})
