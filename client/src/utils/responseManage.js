import { onWarning, onError } from "@/plugins/alerts";
import { has } from "lodash";

const errorCollection = {
  HTTP: {
    500: (error) => {
      onError("Внутренняя ошибка сервера");
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

    413: (error) => {
      onError("Превышен объем загружаемых данных");
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

    405: (error) => {
      onError(
        `Метод ${error.config.method.toUpperCase()} запрещен для данного маршрута`
      );

      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

    404: (error) => {
      onError(`Маршрут ${error.response.config.url} не найден`);
      return Promise.reject({
        error: `${error.response.status} ${error.response.statusText}`,
        code: 404,
      });
    },

    403: (error) => {
      onError("Доступ запрещен");
      return Promise.reject(error);
    },

    400: (error) => {
      onError("Параметры Http запроса указаны некорректно");
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

    401: (error) => {
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },
  },

  custom: {
    0: (e) => {
      onError(process.env.NODE_ENV == "development" ? e.error : "");
      if (process.env.NODE_ENV == "development") console.error(e.error);

      return Promise.reject("Some error was occurred");
    },

    10: () =>
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
  if ("error" in response.data) return errorManage(response.data);

  if (typeof response.data === "string") return Promise.resolve(response);

  if (Array.isArray(response.data) && !response.data.length)
    Promise.resolve(response.data);

  if ("code" in response.data) {
    if (response.data.code in errorCollection.custom) {
      return errorCollection.custom[Number(response.data.code)]({
        error: response.data.error || "Server error",
      });
    }

    if (response.data.code === 1) return Promise.resolve(response);
  }

  return Promise.resolve(response);
};

export const errorManage = (error) => {
  if ("response" in error) {
    if (error.response.status in errorCollection.HTTP) {
      return errorCollection.HTTP[error.response.status](error);
    }
  }

  if (error.error || error.code) {
    return has(errorCollection.custom, error.code)
      ? errorCollection.custom[error.code](error)
      : errorCollection.custom[0](error);
  }

  return Promise.reject(error);
};
