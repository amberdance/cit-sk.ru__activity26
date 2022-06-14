import Vue from "vue";
import { Notification } from "element-ui";
import { random } from "lodash";

const messages = {
  success: [
    "Ты молодчина !",
    "Все прошло успешно",
    "Все прошло как и следовало ожидать",
    "Успех !",
    "Все корректно !",
    "Удачи",
    "А ты молодец !",
    "Все хорошо",
    "Мои поздравления!",
    "А я и не сомневался в тебе",
    "Да, все прошло как надо",
    "Отлично ! Еще на один шаг ближе к цели !",
    "Ты проделал немало работы",
    "Мне нравится твой подход !",
    "Не отчаивайся !",
    "Неплохо !",
    "Мойте руки"
  ],

  error: [
    "Произошла ошибка",
    "Произошло что-то непредвиденное",
    "Что - то пошло не так",
    "Все пошло не так, как задумывалось"
  ]
};

const randomAlertPhrase = (text, type) => {
  if (text) return text;

  const index = random(
    0,
    type == "success" ? messages.success.length - 1 : messages.error.length - 1
  );

  return type == "success" ? messages.success[index] : messages.error[index];
};

const notificationBase = (type, message = null, duration) => {
  if (type !== "warning") {
    message = randomAlertPhrase(message, type);
  }

  Notification({
    type,
    message,
    position: "bottom-right",
    duration: duration || 2000
  });
};

export const onSuccess = (text = null, duration) =>
  notificationBase("success", text, duration);

export const onError = (text = null, duration) =>
  notificationBase("error", text, duration);

export const onWarning = (text = null, duration) =>
  notificationBase("warning", text, duration);

const alerts = () => {
  Vue.prototype.$onSuccess = (message, duration) =>
    notificationBase("success", message, duration);

  Vue.prototype.$onError = (message, duration) =>
    notificationBase("error", message, duration);

  Vue.prototype.$onWarning = (message, duration) =>
    notificationBase("warning", message, duration);
};

Vue.use(alerts);
