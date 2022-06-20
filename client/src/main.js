import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import ElementPlus from "element-plus";
import Maska from "maska";
import axios from "./plugins/axios";
import { onSuccess, onWarning, onError } from "./plugins/alerts";
import "element-plus/dist/index.css";
import "./styles/style.css";

const app = createApp(App);

app.config.globalProperties.$axios = axios;

app.config.globalProperties.$onSuccess = (message, duration) =>
  onSuccess(message, duration);

app.config.globalProperties.$onError = (message, duration) =>
  onError(message, duration);

app.config.globalProperties.$onWarning = (message, duration) =>
  onWarning(message, duration);

app.use(router);
app.use(ElementPlus, { size: "medium" });
app.use(Maska);

app.mount("#app");
