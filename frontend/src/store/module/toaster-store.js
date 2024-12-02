const toasterStore = {
  state: () => ({
    toaster: {
      show: false,
      title: "",
      description: "",
      type: "info",
    },
  }),
  mutations: {
    showToaster(state, { title, description, type }) {
      state.toaster.title = title;
      state.toaster.description = description;
      state.toaster.type = type;
      state.toaster.show = true;
    },
    hideToaster(state) {
      state.toaster.show = false;
    },
  },
  actions: {
    triggerToaster({ commit }, { title, description, type }) {
      commit("showToaster", { title, description, type });
      setTimeout(() => {
        commit("hideToaster");
      }, 3000);
    },
  },
  getters: {
    getToaster(state) {
      return state.toaster;
    },
  },
};

export default toasterStore;