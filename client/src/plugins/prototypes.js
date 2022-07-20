import Vue from "vue";
import axios from "axios";
import store from "@/store";
import { camelize } from "@/utils/common";
import { onError, onSuccess, notificationBase } from "../utils/alerts";

const plugins = () => {
  /*
   *--------------------------------------------------------------
   *            SHARED
   *--------------------------------------------------------------
   */

  Vue.prototype.$onSuccess = (message, duration) =>
    notificationBase("success", message, duration);

  Vue.prototype.$onError = (message, duration) =>
    notificationBase("error", message, duration);

  Vue.prototype.$onWarning = (message, duration) =>
    notificationBase("warning", message, duration);

  /*
   *--------------------------------------------------------------
   *            AUTH
   *--------------------------------------------------------------
   */

  Vue.prototype.$logout = async function () {
    try {
      await axios.post("/auth/logout");
    } catch (e) {
      onError("Случилась неведомая ошибка, уверен ее скоро исправят");

      console.error(e);
    } finally {
      onSuccess("Возвращайтесь !");

      $cookies.remove("access_token");
      store.commit("setUser", {});
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

Vue.prototype.$openNewWindow = link => {
  window.open(link, "_blank");
};

Vue.use(plugins);

const responseData = (data, responseType = null) => {
  if (Array.isArray(data) && !data.length) return data;
  if (responseType == "blob") return data;
  if (!data) return [];
  if ("data" in data) return camelize(data.data);

  return camelize(data);
};
