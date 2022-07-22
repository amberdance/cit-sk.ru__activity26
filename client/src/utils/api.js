import axios from "axios";
import { camelize } from "./common";

const responseData = (data, responseType = null) => {
  if (Array.isArray(data) && !data.length) return data;
  if (responseType == "blob") return data;
  if (!data) return [];
  if ("data" in data) return camelize(data.data);

  return camelize(data);
};

export const dispatch = {
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
