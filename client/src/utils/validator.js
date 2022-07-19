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
  /^(\+7[- ]?)?(\([9]{1}\d{2}\)?[- ]?)?[\d- ]{5,10}$/g.test(phone);

export const emailValidator = (email) =>
  /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
    email
  );

export const passwordStrengthValidator = (password) =>
  /^(?=(.*[a-z]){3,})(?=(.*[A-Z]){2,})(?=(.*[0-9]){1,})(?=(.*[!@#$%^&*()\-__+.]){1,}).{8,}$/g.test(
    password
  );

export const incomeCallCodeValidator = (code) => /^\d{4}/g.test(code);

export const birthdatValidator = (birthday) =>
  /^(?:0[1-9]|[12]\d|3[01])([/.-])(?:0[1-9]|1[012])\1(?:19|20)\d\d$/g.test(
    birthday
  );
