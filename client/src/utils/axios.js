import axios from "axios";
import store from "@/store";
import router from "@/router";
import { responseManage, errorManage } from "@/utils/http";
import { camelize } from "./common";
import { CMS_PREFFIX_ROUTE } from "../values";

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
  let isUserAuthorized = !_.isEmpty(store.getters.get("user"));

  if (!isUserAuthorized || !$cookies.get("access_token")) {
    try {
      const { data } = await axios.get("/auth/me");
      store.commit("setState", { key: "user", value: camelize(data) });
      isUserAuthorized = true;
    } catch (e) {
      if ("code" in e && e.code == 401) logout();
      else console.error(e);
    }
  }

  if ("onlyForUnauthorized" in to.meta && isUserAuthorized) {
    next({ path: from.path });
  }

  if (
    to.path.includes(CMS_PREFFIX_ROUTE) &&
    !store.getters.get("user").isAdmin
  ) {
    next({ path: from.path });
  }

  next();
});

const logout = () => {
  $cookies.remove("access_token");
  store.commit("clear", "user");
};
