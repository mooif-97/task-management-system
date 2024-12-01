import axiosInstance from "./axios/base-axios";

class Authentication {
  async loginAndGetToken({ user_id, password }) {
    return await axiosInstance.post("authenticate", {
      user_id,
      password,
    });
  }
}

const authentication = new Authentication();
export default authentication;
