import {
  transform,
  isPlainObject,
  isArray,
  isObject,
  has,
  isEqual,
  camelCase,
  forOwn,
} from "lodash";

export const dateHelper = {
  currentDate: null,
  year: null,
  month: null,
  day: null,
  hour: null,
  minutes: null,
  seconds: null,

  _initialize(customDate) {
    this.currentDate = customDate ? new Date(customDate) : new Date();
    this.year = this.currentDate.getFullYear();
    this.month = this.currentDate.getMonth() + 1;
    this.day = this.currentDate.getDate();
    this.hour = this.currentDate.getHours();
    this.minutes = this.currentDate.getMinutes();
    this.seconds = this.currentDate.getSeconds();
  },

  getDate(customDate, delimiter = "-") {
    this._initialize(customDate);

    return `${this.year}${delimiter}${
      this.month < 10 ? `0${this.month}` : this.month
    }${delimiter}${this.day < 10 ? `0${this.day}` : this.day}`;
  },

  getDateTime(customDate, delimiter = "-") {
    this._initialize(customDate);

    return `${this.year}${delimiter}${
      this.month < 10 ? `0${this.month}` : this.month
    }${delimiter}${this.day < 10 ? `0${this.day}` : this.day} ${this.hour}:${
      this.minutes < 10 ? `0${this.minutes}` : this.minutes
    }:${this.seconds < 10 ? `0${this.seconds}` : this.seconds}`;
  },
};

export const emailValidate = (email) =>
  String(email)
    .toLowerCase()
    .match(
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );

export const passwordsCompare = (password, checkPassword) => {
  const letters = /[a-zA-Z]/;
  const numbers = /[0-9]/;

  if (!password || !checkPassword) {
    return Promise.reject({ error: "Empty field", code: 1 });
  }

  if (password != checkPassword) {
    return Promise.reject({ error: "Not matched", code: 2 });
  }

  if (
    password.length < 6 ||
    !letters.test(password) ||
    !numbers.test(password)
  ) {
    return Promise.reject({ error: "Weak password", code: 3 });
  }

  return Promise.resolve();
};

export const downloadFile = (blob, fileName) => {
  const link = document.createElement("a");

  link.href = window.URL.createObjectURL(
    new Blob([blob], { type: "octet/stream" })
  );

  link.setAttribute("download", fileName.replace(/[[:\s]/gm, "_"));

  document.body.appendChild(link);
  link.click();
  link.remove();
  URL.revokeObjectURL(link.href);
};

export const declOfNum = (number, titles) => {
  const cases = [2, 0, 1, 1, 1, 2];

  return titles[
    number % 100 > 4 && number % 100 < 20
      ? 2
      : cases[number % 10 < 5 ? number % 10 : 5]
  ];
};

export const getRandomInt = (min, max) => {
  min = Math.ceil(min);
  max = Math.floor(max);

  return Math.floor(Math.random() * (max - min + 1)) + min;
};

export const trimText = (text, length = 255, separator = " ...") =>
  String(text).length > length ? text.substr(0, length) + separator : text;

export const purgeLocalStorage = (key) => {
  if (key) localStorage.removeItem(key);
  else {
    for (const key in localStorage) {
      if (key in localStorage) localStorage.removeItem(key);
    }
  }
};

export const deepDiffObj = (base, object) => {
  if (!object) {
    throw new Error(`The object compared should be an object: ${object}`);
  }

  if (!base) return object;

  const result = transform(object, (result, value, key) => {
    if (!has(base, key)) result[key] = value;
    if (!isEqual(value, base[key])) {
      result[key] =
        isPlainObject(value) && isPlainObject(base[key])
          ? deepDiffObj(base[key], value)
          : value;
    }
  });

  forOwn(base, (value, key) => {
    if (!has(object, key)) result[key] = undefined;
  });

  return result;
};

export const camelize = (obj) =>
  transform(obj, (acc, value, key, target) => {
    const camelKey = isArray(target) ? key : camelCase(key);

    acc[camelKey] = isObject(value) ? camelize(value) : value;
  });
