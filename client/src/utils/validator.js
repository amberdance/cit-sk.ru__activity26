import { emailValidate } from "./common";

export const emailValidator = (value, callback, required = false) => {
  if (!required && !value) return callback();

  return emailValidate(value)
    ? callback()
    : callback(new Error("Недопустимый формат"));
};

export const postIndexValidator = (value, callback, required = false) => {
  if (!required && !value) return callback();

  if (/\D/.test(value) || String(value).length != 6) {
    callback(new Error("Недопустимый формат"));
  } else callback();
};
