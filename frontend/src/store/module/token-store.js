const tokenStore = {
  state: () => ({
    token: "",
    userId: "",
  }),
  mutations: {
    setToken(state, token) {
      state.token = token;
    },
    setUserId(state, userId) {
      state.userId = userId;
    },
  },
  getters: {
    getToken(state) {
      return state.token;
    },
    getUserId(state) {
      return state.userId;
    },
  },
};

export default tokenStore;
