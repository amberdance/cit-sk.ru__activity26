import Vue from "vue";
import lang from "element-ui/lib/locale/lang/ru-RU";
import locale from "element-ui/lib/locale";
import "@/styles/element-variables.scss";

import {
  Alert,
  Button,
  Container,
  Checkbox,
  Divider,
  Dialog,
  Form,
  FormItem,
  Footer,
  Header,
  Input,
  Link,
  Loading,
  Main,
  MessageBox,
  Message,
  Notification,
  Row,
  Col,
} from "element-ui";

[
  Alert,
  Button,
  Container,
  Checkbox,
  Divider,
  Dialog,
  Form,
  FormItem,
  Footer,
  Header,
  Input,
  Link,
  Loading,
  Main,
  Row,
  Col,
].forEach((component) => Vue.use(component));

locale.use(lang);

Vue.use(Loading.directive);

Vue.prototype.$loading = Loading.service;
Vue.prototype.$msgbox = MessageBox;
Vue.prototype.$alert = MessageBox.alert;
Vue.prototype.$confirm = MessageBox.confirm;
Vue.prototype.$prompt = MessageBox.prompt;
Vue.prototype.$notify = Notification;
Vue.prototype.$message = Message;
