module.exports = {
  env: {
    node: true,
  },
  extends: [
    "eslint:recommended",
    "plugin:vue/vue3-recommended",
    "prettier",
    "plugin:@shopify/esnext",
    "plugin:@shopify/prettier",
    "plugin:@shopify/typescript",
    "plugin:@shopify/typescript-type-checking",
  ],
  rules: {
    "generator-star-spacing": "off",
    "vue/require-default-prop": "off",
    "vue/multi-word-component-names": "off",
    "arrow-body-style": "off",
    "prefer-arrow-callback": "off",
    "prettier/prettier": "off",
  },
  parser: "vue-eslint-parser",
  parserOptions: {
    parser: "@typescript-eslint/parser",
    babelOptions: {
      parserOpts: {
        plugins: ["jsx"],
      },
    },
  },
  plugins: ["prettier"],
};
