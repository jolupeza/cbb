module.exports = {
  css: {
    loaderOptions: {
      scss: {
        prependData: `@import "~@/scss/variables.scss"; @import "~@/scss/fonts.scss";`
      }
    }
  },
  devServer: {
    host: 'localhost',
    port: 8080,
    disableHostCheck: true
  }
}