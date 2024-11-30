import axios from "axios";
import store from "../../store";

const axiosInstance = axios.create({
  baseURL: "https://86mwsr-8000.csb.app/",
  timeout: 10000,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
});

// Adding request interceptor
axiosInstance.interceptors.request.use(
  (config) => {
    const token = store.getters.getToken;
    if (token) {
      config.headers["Authorization"] = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    _handleRequestResponseError();
    return Promise.reject(error);
  }
);

// Adding response interceptor
axiosInstance.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    _handleRequestResponseError();
    return Promise.reject(error);
  }
);

function _handleRequestResponseError() {}

function _handleRequestSuccess() {}

export default axiosInstance;
