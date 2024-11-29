import { createStore } from 'vuex';
import tokenStore from './module/token-store'
import toasterStore from './module/toaster-store'

const store = createStore({
  modules: {
    tokenStore,
    toasterStore,
  },
});

export default store;