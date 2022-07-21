process.env.VUE_APP_VERSION = require("./package.json").version;
process.env.VUE_APP_API_URL =
  process.env.NODE_ENV == "development"
    ? "http://regional-polls.ru/api"
    : "https://activity26.ru/api";

module.exports = {
  filenameHashing: false,
  lintOnSave: process.env.NODE_ENV !== "production",

  configureWebpack: {
    performance: {
      hints: false,
    },
  },
};
