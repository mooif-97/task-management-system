import authentication from "../../api/authenticatation-api";

const tokenStore = {
    state: () => ({
        token: '',
    }),
    mutations: {
        setToken(state, token) {
            state.token = token;
        }
    },
    actions: {
        async authorize({ commit }, { userId, password }) {
            console.log('hey its been called')
            const newToken = await authentication.loginAndGetToken({ userId, password })
            commit('setToken', newToken);
        }
    },
    getters: {
        getToken(state) {
            return state.token;
        }
    },
};

export default tokenStore;