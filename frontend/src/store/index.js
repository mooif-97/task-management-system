import { createStore } from 'vuex';
import tokenStore from './module/token-store'
import toasterStore from './module/toaster-store'
import modalStore from './module/modal-store';
import apiLoadingStore from './module/api-loading-store';

const store = createStore({
  modules: {
    tokenStore,
    toasterStore,
    modalStore,
    apiLoadingStore
  },
});

export default store;