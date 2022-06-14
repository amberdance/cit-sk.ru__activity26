import Vue from "vue";
import { camelize } from "@/utils/common";
import axios from "axios";

Plugin.install = Vue => {
  /*
   *--------------------------------------------------------------
   *            SHARED
   *--------------------------------------------------------------
   */

  Vue.prototype.$isLoading = function(state = true) {
    this.$store.commit("common/isLoading", state);
  };

  Vue.prototype.$openNewWindow = link => {
    window.open(link, "_blank");
  };

  Vue.prototype.$setAppCache = function(key, value) {
    try {
      const id = this.$store.getters["user/info"].id;

      if (!localStorage.getItem("app_cache")) {
        localStorage.setItem(
          "app_cache",
          JSON.stringify({
            [id]: {}
          })
        );
      }

      let cache = JSON.parse(localStorage.getItem("app_cache"));

      cache[id][this.$route.path] = { [key]: value };

      localStorage.setItem("app_cache", JSON.stringify(cache));
    } catch (e) {
      console.error(e);
    }
  };

  Vue.prototype.$getAppCache = function(key) {
    try {
      return JSON.parse(localStorage.getItem("app_cache"))[
        this.$store.getters["user/info"].id
      ][this.$route.path][key];
    } catch (e) {
      return {};
    }
  };

  /*
   *--------------------------------------------------------------
   *            API
   *--------------------------------------------------------------
   */

  const handleData = (data, responseType = null) => {
    if (Array.isArray(data) && !data.length) return data;
    if (responseType == "blob") return data;
    if (!data) return [];
    if ("data" in data) return camelize(data.data);

    return camelize(data);
  };

  Vue.prototype.$HttpPost = async (route, params, responseType = "json") => {
    const { data } = await axios.post(route, params, { responseType });

    return handleData(data, responseType);
  };

  Vue.prototype.$HttpGet = async (route, params, responseType = "json") => {
    const { data } = await axios.get(route, { params, responseType });

    return handleData(data, responseType);
  };

  Vue.prototype.$HttpPut = async (route, params, responseType = "json") => {
    const { data } = await axios.put(route, params, { responseType });

    return handleData(data, responseType);
  };

  Vue.prototype.$HttpPatch = async (route, params) => {
    const { data } = await axios.patch(route, params);

    return handleData(data);
  };

  Vue.prototype.$HttpDelete = async route => {
    const { data } = await axios.delete(route);

    return handleData(data);
  };
};

Vue.use(Plugin);
