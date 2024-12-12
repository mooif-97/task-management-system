import axios from "axios";
import store from "../../store";

const axiosInstance = axios.create({
  baseURL: import.meta.env.VITE_APP_BASE_API_URL,
  // baseURL: "https://6x3dfh-8000.csb.app/api",
  timeout: 5000,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

// Adding request interceptor
axiosInstance.interceptors.request.use(
  (config) => {
    store.commit("setIsLoading", true);
    const token = localStorage.getItem("authToken");
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
    store.commit("setIsLoading", false);
    _handleRequestSuccess(response);
    return response;
  },
  (error) => {
    store.commit("setIsLoading", false);
    _handleRequestResponseError(error);
    return Promise.reject(error);
  }
);

function _handleRequestResponseError(error) {
  // treat 404 as warning
  const actionType = error?.response?.status === 404 ? "warning" : "error"
  const description = error?.response?.data?.message || error.message;
  // display error message using n-message
  store.dispatch("triggerMessage", {
    description,
    actionType,
  });
}

function _handleRequestSuccess(response) {
  const description = response?.data?.message;
  if(description) {
    store.dispatch("triggerMessage", {
      description,
      actionType: "success",
    });
  }
}

export default axiosInstance;
