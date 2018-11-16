export default {
  locals: [],
  error: {},
  pathUrl: window.location.protocol + '//' + window.location.host,
  getLocals() {
    let action = `locals?parent=0&orderby=menu_order&order=asc`

    return new Promise((resolve, reject) => {
      this.processRequest('get', action, {})
        .then(() => {
          if (this.locals.length) {
            resolve(this.locals)
          }

          reject(this.error)
        })
    })

  },
  processRequest(method, action, params) {
    return axios[method](this.buildUrl(action), params)
      .then(response => {
        this.locals = response.data
      })
      .catch(error => {
        this.error = error.response.data
      })
  },
  buildUrl(action) {
    return this.pathUrl + '/wp-json/wp/v2/' + action
  }
}
