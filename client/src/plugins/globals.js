import Vue from "vue";
import { auth } from "@/utils/auth";
import { camelize } from "@/utils/common";
import axios from "axios";

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

  Vue.prototype.$login = (payload) => auth.login(payload);
  Vue.prototype.$logout = () => auth.logout();
  Vue.prototype.$isAuthorized = () => auth.isAuthorized();

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

  Vue.prototype.$post = async (route, params, responseType = "json") => {
    const { data } = await axios.post(route, params, { responseType });

    return handleData(data, responseType);
  };

  Vue.prototype.$get = async (route, params, responseType = "json") => {
    const { data } = await axios.get(route, { params, responseType });

    return handleData(data, responseType);
  };

  Vue.prototype.$put = async (route, params, responseType = "json") => {
    const { data } = await axios.put(route, params, { responseType });

    return handleData(data, responseType);
  };

  Vue.prototype.$patch = async (route, params) => {
    const { data } = await axios.patch(route, params);

    return handleData(data);
  };

  Vue.prototype.$delete = async (route) => {
    const { data } = await axios.delete(route);

    return handleData(data);
  };
};

Vue.use(Plugin);
