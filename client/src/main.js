import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import VueCookies from "vue-cookies";
import VueCountdown from "@chenfengyuan/vue-countdown";

import "@/utils/axios";
import "@/plugins/element";
import "@/plugins/prototypes";
import "@/styles/style.css";
import "test" from test;


Vue.config.productionTip = false;

Vue.use(VueCookies);
Vue.component(VueCountdown.name, VueCountdown);

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
