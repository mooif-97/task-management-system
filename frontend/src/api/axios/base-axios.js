import axios from "axios";
import store from "../../store";

const axiosInstance = axios.create({
  baseURL: "https://86mwsr-8000.csb.app/api/",
  timeout: 10000,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

// Adding request interceptor
axiosInstance.interceptors.request.use(
  (config) => {
    store.commit('setIsLoading', true)
    const token = store.getters.getToken;
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    _handleRequestResponseError(error);
    return Promise.reject(error);
  }
);

// Adding response interceptor
axiosInstance.interceptors.response.use(
  (response) => {
    store.commit('setIsLoading', false)
    return response;
  },
  (error) => {
    store.commit('setIsLoading', false)
    _handleRequestResponseError(error);
    return Promise.reject(error);
  }
);

function _handleRequestResponseError(error) {
  console.log('warn response error', error)
  // show toaster to display error message
  store.dispatch('triggerToaster', {
    title: 'Error in Request',
    description: 'hhaha',
    type: 'error'
  })

}

function _handleRequestSuccess() {}

export default axiosInstance;
