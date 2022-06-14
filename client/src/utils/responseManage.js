import { onWarning, onError } from "@/plugins/alerts";
import { has } from "lodash";

const errorCollection = {
  HTTP: {
    500: error => {
      onError("Внутренняя ошибка сервера");
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

    413: error => {
      onError("Превышен объем загружаемых данных");
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

    405: error => {
      onError(
        `Метод ${error.config.method.toUpperCase()} запрещен для данного маршрута`
      );

      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

    404: error => {
      onError(`Маршрут ${error.response.config.url} не найден`);
      return Promise.reject({
        error: `${error.response.status} ${error.response.statusText}`,
        code: 404
      });
    },

    403: error => {
      onError("Доступ запрещен");
      return Promise.reject(error);
    },

    400: error => {
      onError("Параметры Http запроса указаны некорректно");
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    },

    401: error => {
      return Promise.reject(
        `${error.response.status} ${error.response.statusText}`
      );
    }
  },

  custom: {
    0: e => {
      onError(process.env.NODE_ENV == "development" ? e.error : "");
      if (process.env.NODE_ENV == "development") console.error(e.error);

      return Promise.reject("Bad response from server");
    },

    404: e => onError(e.error),

    102: () =>
      Promise.reject({
        error: "Duplicate entry",
        code: 102
      }),

    103: () => {
      onWarning("Тип файла не поддерживается");
      return Promise.reject("Wrong file format");
    },

    104: () => {
      onWarning("Превышен лимит загружаемых файлов");
      return Promise.reject("Limit exceeded");
    },

    105: () => {
      onWarning("Не удалось загрузить файл");
      return Promise.reject("Did not upload");
    },

    106: () => {
      onWarning("Не прикреплен файл");
      return Promise.reject("File is required");
    },

    107: () => {
      onWarning("Пустая заявка");
      return Promise.reject("Application is empty");
    },

    108: error => {
      onWarning("В хранилище отсутствуют позиции");
      Promise.reject(error);
    },

    109: error => Promise.reject(error),

    110: () => {
      onWarning("Присутствует незакрытая заявка", 3500);
      return Promise.reject("Uncompleted application");
    },

    111: () => {
      onWarning("Превышен лимит вводимых символов");
      return Promise.reject("Data too long");
    },

    112: () => {
      onWarning("Сертификат не прошел валидацию");
      return Promise.reject("Certificate validation failed");
    },

    113: () => {
      onWarning("Указан некорректный id позиции");
      return Promise.reject("Id is undefined");
    }
  }
};

export const responseManage = response => {
  if ("error" in response.data) return errorManage(response.data);

  if (typeof response.data === "string") return Promise.resolve(response);

  if (Array.isArray(response.data) && !response.data.length)
    Promise.resolve(response.data);

  if ("code" in response.data) {
    if (response.data.code in errorCollection.custom) {
      return errorCollection.custom[Number(response.data.code)]({
        error: response.data.error || "Server error"
      });
    }

    if (response.data.code === 1) return Promise.resolve(response);
  }

  return Promise.resolve(response);
};

export const errorManage = error => {
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

  Promise.reject(error);
};
