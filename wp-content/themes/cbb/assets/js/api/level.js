export default {
  levels: [],
  error: {},
  pathUrl: window.location.protocol + '//' + window.location.host,
  getLevels() {
    let action = `levels?per_page=15&orderby=id&order=asc`

    return new Promise((resolve, reject) => {
      this.processRequest('get', action, {})
        .then(() => {
          if (this.levels.length) {
            resolve(this.levels)
          }

          reject(this.error)
        })
    })
  },
  processRequest(method, action, params) {
    return axios[method](this.buildUrl(action), params)
      .then(response => {
        this.levels = response.data
      })
      .catch(error => {
        this.error = error.response.data
      })
  },
  buildUrl(action) {
    return this.pathUrl + '/wp-json/wp/v2/' + action
  }
}
