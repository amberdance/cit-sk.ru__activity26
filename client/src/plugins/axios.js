import axios from "axios";
import { auth } from "@/utils/auth";
import { responseManage, errorManage } from "@/utils/http";
import router from "../router";

axios.defaults.baseURL = process.env.VUE_APP_API_URL;

axios.interceptors.request.use(
  (request) => {
    // eslint-disable-next-line no-undef
    const accessToken = $cookies.get("access_token");

    if (accessToken) request.headers.Authorization = `Bearer ${accessToken}`;

    return request;
  },

  (error) => Promise.reject(error)
);

axios.interceptors.response.use(
  (response) => responseManage(response),

  (error) => {
    if (error.response && error.response.status == 401) {
      auth.purge();

      return router.push("/auth");
    }

    return errorManage(error);
  }
);

// router.beforeEach(async (to, from, next) => {
// if (!auth.isAuthorized()) {
//     if (!store.getters["user/info"]) await store.dispatch("user/getUser");

//     if (/admin/.test(to.path) && store.getters["user/info"].role !== "admin") {
//       return next({ path: from.path });
//     }

// return next();
// }

// if ("requiresAuth" in to.meta && !to.meta.requiresAuth) return next();

//   next({
//     path: "/auth",
//     query: { redirect: to.fullPath },
//   });
// });
