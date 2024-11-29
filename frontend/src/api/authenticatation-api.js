import axiosInstance from "./axios/base-axios"

class Authentication {
    async loginAndGetToken({user_id, password}) {
       const loginRes = await axiosInstance.post('api/login', {user_id, password})
       return loginRes?.token
    }
}

const authentication = new Authentication()
export default authentication