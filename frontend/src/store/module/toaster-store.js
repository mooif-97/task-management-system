const toasterStore = {
    state: () => ({
        show: false,
        message: '',
        type: 'info'
    }),
    mutations: {
        showToaster(state, { message, type = 'success' }) {
            state.message = message;
            state.type = type;
            state.show = true;
        },
        hideToaster(state) {
            state.show = false;
            state.message = '';
        },
    },
    actions: {
        triggerToast({ commit }, { message, type }) {
            commit('showToast', { message, type });
            setTimeout(() => {
                commit('hideToaster');
            }, 3000);
        },
    }
};

export default toasterStore;