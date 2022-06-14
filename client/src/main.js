import Vue from "vue";
import App from "@/App";
import router from "@/router";
import Inputmask from "inputmask";
import VueCookies from "vue-cookies";

import "@/utils/axios";
import "@/plugins/element";
import "@/plugins/alerts";
import "@/plugins/globals";
import "@/styles/style.css";

Vue.config.productionTip = false;

Vue.directive("mask", {
  bind(el, binding) {
    Inputmask(binding.value).mask(el.getElementsByTagName("INPUT")[0]);
  }
});

Vue.use(VueCookies);

new Vue({
  router,
  render: h => h(App)
}).$mount("#app");
