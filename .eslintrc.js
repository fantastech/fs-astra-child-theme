/* eslint-env node */
module.exports = {
  root: true,
  env: {
    browser: true,
    jquery: true,
  },
  extends: 'eslint:recommended',
  parserOptions: {
    ecmaVersion: 5,
  },
  globals: {
    wp: true,
  },
  rules: {
    semi: [
      'error',
      'always',
    ],
    quotes: [
      'error',
      'single',
    ],
    'no-console': 0,
    'comma-dangle': [
      'error',
      {
        arrays: 'always-multiline',
        objects: 'always-multiline',
        imports: 'always-multiline',
        exports: 'always-multiline',
        functions: 'ignore',
      },
    ],
  },
  ignorePatterns: [
    'assets/js/jquery.lightbox_me.min.js',
  ],
};