import mutations from "@/store/mutations";

export default {
  namespaced: false,

  state: {
    common: {},
    isLoading: false,
    accessToken: null,
  },

  getters: {
    get: (state) => (key) => state[key],
    isLoading: (state) => state.isLoading,
  },

  mutations: {
    isLoading(state, status = true) {
      state.isLoading = status;
    },

    setProperty(state, { key, value }) {
      state.common[key] = value;
    },

    login(state, token) {
      state.accessToken = token;
    },

    logout(state) {
      state.accessToken = null;
    },

    ...mutations,
  },

  actions: {},
};
