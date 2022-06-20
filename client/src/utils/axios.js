import axios from "axios";
import { responseManage, errorManage } from "@/utils/responseManage";

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
    return errorManage(error);
  }
);
