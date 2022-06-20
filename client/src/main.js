import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import ElementPlus from "element-plus";
import Maska from 'maska'
import "element-plus/dist/index.css";
import "./styles/style.css";

const app = createApp(App);

app.use(store);
app.use(router);
app.use(ElementPlus, { size: "medium" });
app.use(Maska);
app.mount("#app");
