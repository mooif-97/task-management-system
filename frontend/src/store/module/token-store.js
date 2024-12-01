import authentication from "../../api/authenticatation-api";

const tokenStore = {
    state: () => ({
        token: '',
        userId: ''
    }),
    mutations: {
        setToken(state, token) {
            state.token = token;
        },
        setUserId(state, userId) {
            state.userId = userId;
        },
    },
    actions: {
        async authorize({ commit }, { userId, password }) {
            const tokenRes = await authentication.loginAndGetToken({ userId, password })
            const successToken = tokenRes?.token
            if(successToken){
                // should return .token if authentication is success
                commit('setToken', successToken);
                commit('setUserId', userId);
            }
        }
    },
    getters: {
        getToken(state) {
            return state.token;
        },
        getUserId(state) {
            return state.userId;
        }
    },
};

export default tokenStore;