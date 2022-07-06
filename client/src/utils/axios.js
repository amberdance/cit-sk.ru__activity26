import axios from "axios";
import store from "@/store";
import router from "@/router";
import { responseManage, errorManage } from "@/utils/http";
import { camelize } from "./common";

axios.defaults.baseURL = process.env.VUE_APP_API_URL;

axios.interceptors.request.use(
  (request) => {
    const accessToken = $cookies.get("access_token");

    if (accessToken) request.headers.Authorization = `Bearer ${accessToken}`;

    return request;
  },

  (error) => Promise.reject(error)
);

axios.interceptors.response.use(
  (response) => responseManage(response),

  (error) => {
    if (error.response.status == 401) logout();

    return errorManage(error);
  }
);

router.beforeEach(async (to, from, next) => {
  try {
    const { data } = await axios.get("/auth/me");
    store.commit("setUser", camelize(data));
  } catch (e) {
    if ("response" in e && e.response.status == 401) logout();
    else console.error(e);
  } finally {
    next();
  }
});

const logout = () => {
  $cookies.remove("access_token");
  store.commit("setUser", {});
};
