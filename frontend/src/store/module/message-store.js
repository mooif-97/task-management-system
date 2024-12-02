import { createDiscreteApi } from "naive-ui";

const { message } = createDiscreteApi(["message"]);
const messageConfig = Object.freeze({
  keepAliveOnHover: true,
  placement: "bottom",
  closable: true
})

const messageStore = {
  actions: {
    triggerMessage({  }, { description, actionType }) {
      message[actionType](description, messageConfig)
    }
  }
};

export default messageStore;