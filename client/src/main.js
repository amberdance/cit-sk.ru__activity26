import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import VueCookies from "vue-cookies";

import "@/plugins/axios";
import "@/plugins/element";
import "@/plugins/alerts";
import "@/plugins/globals";
import "@/styles/style.css";

Vue.config.productionTip = false;

Vue.use(VueCookies);

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
