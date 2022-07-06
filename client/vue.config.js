process.env.VUE_APP_VERSION = require("./package.json").version;
process.env.VUE_APP_API_URL =
  process.env.NODE_ENV == "development"
    ? "http://regional-polls.ru/api"
    : "https://polls.stavregion.ru/api";

module.exports = {
  productionSourceMap: false,
  filenameHashing: true,
  lintOnSave: process.env.NODE_ENV !== "production",

  configureWebpack: {
    performance: {
      hints: false,
    },

    optimization: {
      splitChunks: {
        minSize: 10000,
        maxSize: 250000,
      },
    },
  },
};
