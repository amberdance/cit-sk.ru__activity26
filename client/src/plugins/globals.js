import Vue from "vue";
import axios from "axios";
import { camelize } from "@/utils/common";
import { onError } from "./alerts";

Plugin.install = (Vue) => {
  /*
   *--------------------------------------------------------------
   *            SHARED
   *--------------------------------------------------------------
   */

  /*
   *--------------------------------------------------------------
   *            AUTH
   *--------------------------------------------------------------
   */

  Vue.prototype.$logout = async () => {
    try {
      await axios.post("/auth/logout");
      $cookies.remove("access_token");
      this.$store.commit("setUserdata", {});
    } catch (e) {
      onError("Случилась неведомая ошибка, уверен ее скоро исправят");
      console.error(e);
    }
  };

  Vue.prototype.$isAuthorized = () => Boolean($cookies.get("access_token"));

  /*
   *--------------------------------------------------------------
   *            API
   *--------------------------------------------------------------
   */

  Vue.prototype.$http = {
    post: async (route, params, responseType = "json") => {
      const { data } = await axios.post(route, params, { responseType });
      return responseData(data, responseType);
    },

    get: async (route, params, responseType = "json") => {
      const { data } = await axios.get(route, { params, responseType });
      return responseData(data, responseType);
    },

    put: async (route, params, responseType = "json") => {
      const { data } = await axios.put(route, params, { responseType });
      return responseData(data, responseType);
    },

    patch: async (route, params) => {
      const { data } = await axios.patch(route, params);
      return responseData(data);
    },

    delete: async (route) => {
      const { data } = await axios.delete(route);
      return responseData(data);
    },
  };
};

const responseData = (data, responseType = null) => {
  if (Array.isArray(data) && !data.length) return data;
  if (responseType == "blob") return data;
  if (!data) return [];
  if ("data" in data) return camelize(data.data);

  return camelize(data);
};

Vue.use(Plugin);
