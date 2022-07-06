import mutations from "@/store/mutations";

export default {
  namespaced: false,

  state: {
    common: {},
    isLoading: false,

    user: {
      isAuthorized: false,
      accessToken: null,
    },
  },

  getters: {
    list: (state) => (key) => state[key],
    isLoading: (state) => state.isLoading,
  },

  mutations: {
    isLoading(state, status = true) {
      state.isLoading = status;
    },

    setProperty(state, { key, value }) {
      state.common[key] = value;
    },

    setUserdata(state, user) {
      state.user = user;
    },

    ...mutations,
  },

  actions: {},
};
