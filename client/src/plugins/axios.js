import axios from "axios";
import { responseManage, errorManage } from "@/utils/http";

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
    if (error.response && error.response.status == 401)
      $cookies.remove("access_token");

    return errorManage(error);
  }
);
