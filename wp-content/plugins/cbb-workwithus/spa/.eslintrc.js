module.exports = {
  root: true,
  env: {
    node: true
  },
  extends: [
    'plugin:vue/essential',
    '@vue/standard',
    'wordpress'
  ],
  rules: {
    'no-console': 'production' === process.env.NODE_ENV ? 'error' : 'off',
    'no-debugger': 'production' === process.env.NODE_ENV ? 'error' : 'off',
    'no-unused-vars': 'off'
  },
  parserOptions: {
    parser: 'babel-eslint'
  }
};
