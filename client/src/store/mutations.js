import Vue from "vue";

export default {
  set(state, { key, props }) {
    Vue.set(state[key], props.id, props);
  },

  clear(state, key) {
    state[key] = {};
  },

  update(state, { key, props }) {
    for (const prop in props) {
      if (typeof props[prop] === "object") {
        for (const nestedKey in props[prop]) {
          Vue.set(
            state[key][props.id][prop],
            nestedKey,
            props[prop][nestedKey]
          );
        }
      } else Vue.set(state[key][props.id], prop, props[prop]);
    }
  },

  remove(state, { key, id }) {
    Vue.delete(state[key], id);
  },
};
