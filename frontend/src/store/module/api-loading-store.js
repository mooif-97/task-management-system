
const apiLoadingStore = {
    state: () => ({
        loading: false,
    }),
    mutations: {
        setIsLoading(state, loading) {
            state.loading = loading;
        }
    },
    getters: {
        isLoading(state) {
            return state.loading;
        }
    },
};

export default apiLoadingStore;