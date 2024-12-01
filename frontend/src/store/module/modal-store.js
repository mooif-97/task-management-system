
const modalStore = {
    state: () => ({
        // the states are used asmodal name
        taskEditModal: false,
        taskFilterModal: false,
    }),
    mutations: {
        toggleModal(state, { modalName, show }) {
            console.log(modalName, show)
            state[modalName] = show;
        },
        oi(state) {
            state.taskEditModal = true
        }
    },
    actions: {
        async showModal({ commit }, modalName) {
            commit('toggleModal', { modalName, show: true });
        },
        async hideModal({ commit }, modalName) {
            commit('toggleModal', { modalName, show: false });
        }
    },
    getters: {
        getModal: (state) => (modalName) => {
            return state[modalName];
        }
    },
};

export default modalStore;