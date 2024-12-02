import { createStore } from 'vuex';
import tokenStore from './module/token-store'
import messageStore from './module/message-store'
import modalStore from './module/modal-store';
import apiLoadingStore from './module/api-loading-store';

const store = createStore({
  modules: {
    tokenStore,
    messageStore,
    modalStore,
    apiLoadingStore
  },
});

export default store;