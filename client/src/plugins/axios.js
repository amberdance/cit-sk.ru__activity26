import axios from "axios";
import { responseManage, errorManage } from "@/utils/responseManage";

axios.defaults.baseURL = process.env.VUE_APP_API_URL;

axios.interceptors.request.use(
  (request) => Promise.resolve(request),
  (error) => Promise.reject(error)
);

axios.interceptors.response.use(
  (response) => responseManage(response),
  (error) => errorManage(error)
);

export default axios;
