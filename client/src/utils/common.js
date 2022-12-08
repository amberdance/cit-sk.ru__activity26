import _, { transform, isArray, isObject, camelCase } from "lodash";

export const camelize = (obj) =>
  transform(obj, (acc, value, key, target) => {
    const camelKey = isArray(target) ? key : camelCase(key);

    acc[camelKey] = isObject(value) ? camelize(value) : value;
  });

// Does not provide a nested objects
export const removeEmptyProps = (obj) =>
  _.omitBy(obj, (val) => _.isUndefined(val) || _.isNull(val) || val === "");
