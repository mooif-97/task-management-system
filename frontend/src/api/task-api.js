import axiosInstance from "./axios/base-axios";

class TaskApi {
    async getTasksByFilterAndPagination(requestBody) {
        return await axiosInstance.post('items-by-pagination', requestBody);
    }

    async createTask(requestBody) {
        const formattedReqBody = this._formatRequestBody(requestBody)
        return await axiosInstance.post('items', formattedReqBody);
    }

    async updateTask(requestBody) {
        const formattedReqBody = this._formatRequestBody(requestBody)
        return await axiosInstance.patch('items', formattedReqBody);
    }
    _convertDateToISO(date) {
        return date ? new Date(date).toISOString() : null
    }

    _formatRequestBody(requestBody) {
        return {...requestBody, due_date: this._convertDateToISO(requestBody.due_date)}
    }
}

const taskApi = new TaskApi();
export default taskApi;
