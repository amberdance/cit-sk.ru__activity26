export const matchPasswordsValidator = (
  password,
  comparePassword,
  callback
) => {
  if (!password) return callback(new Error("Повторите введенный пароль"));
  if (password !== comparePassword)
    return callback(new Error("Введенные пароли не совпадают"));

  return callback();
};

export const phoneNumberValidator = (phone) =>
  /(\+7)[- _]*\(?[- _]*(\d{3}[- _]*\)?([- _]*\d){7}|\d\d[- _]*\d\d[- _]*\)?([- _]*\d){6})/g.test(
    phone
  );

export const emailValidator = (email) =>
  /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
    email
  );

export const passwordStrengthValidator = (password) =>
  /^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){1,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{8,}$/g.test(
    password
  );

export const incomeCallCodeValidator = (code) => /^\d{4}/g.test(code);
