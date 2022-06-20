process.env.VUE_APP_VERSION = require("./package.json").version;

process.env.VUE_APP_API_URL =
  process.env.NODE_ENV == "development"
    ? "http://regional-polls/api/v1"
    : "https://polls.stavregion.ru/api/v1";

module.exports = {
  productionSourceMap: false,
  filenameHashing: true,

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
