import axiosInstance from "./axios/base-axios";

class Authentication {
  async loginAndGetToken({ userId, password }) {
    const loginRes = await axiosInstance.post("api/authenticate", {
      user_id: userId,
      password,
    });
    return loginRes?.token;
  }
}

const authentication = new Authentication();
export default authentication;
