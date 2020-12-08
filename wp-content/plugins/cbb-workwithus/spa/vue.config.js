module.exports = {
  css: {
    loaderOptions: {
      scss: {
        additionalData: `@import "~@/scss/general.scss"; @import "~@/scss/variables.scss"; @import "~@/scss/fonts.scss";`
      }
    }
  },
  devServer: {
    host: 'localhost',
    port: 8080,
    disableHostCheck: true
  }
}
