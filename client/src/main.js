import Vue from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import VueCookies from "vue-cookies";
import VueCountdown from "@chenfengyuan/vue-countdown";
import VueScrollTo from "vue-scrollto";
import VueKinesis from "vue-kinesis";

import "@/utils/axios";
import "@/plugins/element";
import "@/plugins/prototypes";
import "element-ui/lib/theme-chalk/display.css";
import "@/styles/style.css";
import "@/styles/grid.css";

Vue.config.productionTip = false;

Vue.use(VueCookies);
Vue.use(VueScrollTo);
Vue.use(VueKinesis);
Vue.component(VueCountdown.name, VueCountdown);

new Vue({
  router,
  store,
  render: (h) => h(App),
}).$mount("#app");
