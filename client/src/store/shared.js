import mutations from "@/store/mutations";

export default {
  namespaced: false,

  state: {
    common: {},
    user: {},
  },

  getters: {
    get: (state) => (key) => state[key],
    isUserAuthorized: (state) => !_.isEmpty(state.user),
  },

  mutations: {
    set(state, { key, value }) {
      state.common[key] = value;
    },

    setUser(state, payload) {
      state.user = payload;
    },

    ...mutations,
  },

  actions: {},
};
