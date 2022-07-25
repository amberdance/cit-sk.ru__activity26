import { transform, isArray, isObject, camelCase } from "lodash";

export const camelize = (obj) =>
  transform(obj, (acc, value, key, target) => {
    const camelKey = isArray(target) ? key : camelCase(key);

    acc[camelKey] = isObject(value) ? camelize(value) : value;
  });
