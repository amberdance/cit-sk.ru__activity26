import axios from "axios";
// import { auth } from "@/utils/auth";
import { responseManage, errorManage } from "@/utils/http";
// import router from "../router";

axios.defaults.baseURL = process.env.VUE_APP_API_URL;
axios.defaults.withCredentials = true;
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

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
    // if (error.response && error.response.status == 401) {
    //   auth.purge();

    //   return router.push("/auth");
    // }

    return errorManage(error);
  }
);
