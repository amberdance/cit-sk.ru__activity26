import axios from "axios";
import { camelize } from "./common";

const handleData = (data) => {
  if (!data) return Promise.reject("Empty data");

  if (data instanceof Object && "data" in data)
    return Promise.resolve(camelize(data.data));

  if ((Array.isArray(data) && data.length) || data instanceof Object) {
    return Promise.resolve(camelize(data));
  }

  return Promise.reject("Cannot find condition to handle response data");
};

export const dispatch = {
  async get(route, params) {
    const { data } = await axios.get(route, { params });

    return handleData(data);
  },

  async post(route, params) {
    const { data } = await axios.post(route, params);

    return handleData(data);
  },

  async delete(route) {
    const { data } = await axios.delete(route);

    return handleData(data);
  },

  async put(route, params) {
    const { data } = await axios.put(route, params);

    return handleData(data);
  },

  async patch(route, params) {
    const { data } = await axios.patch(route, params);

    return handleData(data);
  },
};
