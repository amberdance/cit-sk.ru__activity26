import { onWarning, onError } from "@/plugins/alerts";
import { has } from "lodash";

const errorCollection = {
  HTTP: {
    500: (e) => {
      onError("Внутренняя ошибка сервера");

      return Promise.reject({
        code: e.response.data.error.code,
        error: e.response.data.error.message,
      });
    },

    422: (e) => {
      onError("Указанные данные заполнены некорректно");

      return Promise.reject({
        code: e.response.data.error.code,
        error: e.response.data.error.message,
      });
    },

    413: (e) => {
      onError("Превышен объем загружаемых данных");

      return Promise.reject({
        code: e.response.data.error.code,
        error: e.response.data.error.message,
      });
    },

    405: (e) => {
      onError(
        `Метод ${e.config.method.toUpperCase()} запрещен для данного маршрута`
      );

      return Promise.reject({
        code: 405,
        error: e.message,
      });
    },

    404: (e) => {
      onError(`Маршрут ${error.response.config.url} не найден`);

      return Promise.reject({
        code: 404,
        error: e.message,
      });
    },

    403: (e) => {
      onError("Доступ запрещен");

      return Promise.reject({
        code: 401,
        error: e.message,
      });
    },

    401: (error) => {
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

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

    100: () =>
      Promise.reject({
        error: "Duplicate entry",
        code: 10,
      }),

    20: () => {
      onWarning("Превышен лимит вводимых символов");
      return Promise.reject("Data too long");
    },

    30: (e) =>
      Promise.reject({
        error: e.error,
        code: e.code,
      }),

    404: (e) => onError(e.error),
  },
};

export const responseManage = (response) => {
  if (response.data == "") return Promise.resolve(response);
  if ("error" in response.data) return errorManage(response.data);
  if ("data" in response.data) return Promise.resolve(response);
};

export const errorManage = (error) => {
  if (error.response.status in errorCollection.HTTP) {
    return errorCollection.HTTP[error.response.status](error);
  }

  return has(errorCollection.custom, error.response.data.code)
    ? errorCollection.custom[error.code](error)
    : errorCollection.custom[0](error);
};
