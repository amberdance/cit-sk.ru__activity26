import { transform, isArray, isObject, camelCase } from "lodash";

export const camelize = (obj) =>
  transform(obj, (acc, value, key, target) => {
    const camelKey = isArray(target) ? key : camelCase(key);

    acc[camelKey] = isObject(value) ? camelize(value) : value;
  });

export const getRandomQuote = async () => {
  const { quotes } = await import("../quotes.js");

  return Promise.resolve(quotes[_.random(0, quotes.length - 1)]);
};
