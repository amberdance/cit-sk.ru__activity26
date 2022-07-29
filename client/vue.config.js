process.env.VUE_APP_VERSION = require("./package.json").version;
process.env.VUE_APP_API_URL =
  process.env.NODE_ENV == "development"
    ? "http://regional-polls.ru/api"
    : "https://activity26.ru/api";

module.exports = {
  lintOnSave: process.env.NODE_ENV !== "production",
  productionSourceMap: true,

  configureWebpack: (config) => {
    if (process.env.NODE_ENV === "production") {
      config.output.filename =
        "js/[name].[contenthash:8].min.js" +
        "?v=" +
        process.env.VUE_APP_VERSION;
      config.output.chunkFilename =
        "js/[name].[contenthash:8].min.js" +
        "?v=" +
        process.env.VUE_APP_VERSION;
    } else {
      config.output.filename = "js/[name].js";
      config.output.chunkFilename = "js/[name].js";
    }
  },
};
