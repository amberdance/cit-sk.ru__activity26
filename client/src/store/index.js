import Vue from "vue";
import Vuex from "vuex";
import shared from "./shared.js";

Vue.use(Vuex);

export default new Vuex.Store({
  modules: { shared },
});
