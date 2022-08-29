import { onError } from "@/utils/alerts";
import { has } from "lodash";

const errorCollection = {
  HTTP: {
    500: (e) => {
      onError("Внутренняя ошибка сервера");

      return Promise.reject({
        code: 500,
        error: e.message,
      });
    },

    422: (e) => {
      return Promise.reject({
        code: e.response.status,
        message: e.response.data.message || e.response.data.error.message,
        errors: e.errors,
      });
    },

    405: (e) => {
      onError(
        `Метод ${e.config.method.toUpperCase()} запрещен для  маршрута ${
          e.response.config.url
        }`
      );

      return Promise.reject({
        code: 405,
        error: e.message,
      });
    },

    404: (e) => {
      return Promise.reject({
        code: 404,
        error: e.message,
      });
    },

    403: (e) => Promise.reject(e),
    401: (e) => Promise.reject(e),

    400: (error) => {
      onError("Параметры Http запроса указаны некорректно");

      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },
  },

  custom: {
    0: (e) => {
      if (process.env.NODE_ENV == "development") console.error(e.error);

      return Promise.reject(e);
    },

    //Duplicate entry
    1062: (e) =>
      Promise.reject({
        error: e.message,
        code: e.code,
      }),
  },
};

export const responseManage = (response) => {
  if (response.data == "") return Promise.resolve(response);
  else if ("data" in response.data) return Promise.resolve(response);
  else if ("error" in response.data) return errorManage(response.data);

  return Promise.resolve(response);
};

export const errorManage = (error) => {
  if ("response" in error) {
    if (error.response.status in errorCollection.HTTP)
      return errorCollection.HTTP[error.response.status](error);

    return has(errorCollection.custom, error.response.data.code)
      ? errorCollection.custom[error.code](error)
      : errorCollection.custom[0](error);
  }

  if ("code" in error) {
    if (
      error.code.toLowerCase().includes("err") ||
      error.message.toLowerCase().includes("err")
    )
      return Promise.reject(error);
  }

  return Promise.reject("error" in error ? error.error : error);
};
