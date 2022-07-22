import mutations from "@/store/mutations";
import { dispatch } from "../utils/api";

export default {
  namespaced: false,

  state: {
    common: {},
    user: {},
    polls: [],
    news: [],
    counters: {},
  },

  getters: {
    objects: (state) => (key) => {
      const values = Object.values(state[key]);
      return values.length == 1 ? values[0] : values;
    },

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

    increaseStats(state, { key, value }) {
      state.statistics[key] = state.statistics[key] + value;
    },

    ...mutations,
  },

  actions: {
    async loadCounters({ commit }) {
      commit("clear", "statistics");
      const props = await dispatch.get("/pages/main/counters");
      commit("set", { key: "counters", props });
    },

    async loadPolls({ commit }, params) {
      commit("clear", "polls");
      const polls = await dispatch.get("/polls", params);
      polls.forEach((props) => commit("set", { key: "polls", props }));
    },

    async loadNews({ commit }, params) {
      commit("clear", "polls");
      const news = await dispatch.get("/pages/main/news", params);
      news.forEach((props) => commit("set", { key: "news", props }));
    },
  },
};
