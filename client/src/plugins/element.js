import Vue from "vue";
import lang from "element-ui/lib/locale/lang/ru-RU";
import locale from "element-ui/lib/locale";
import "@/styles/element-variables.scss";

import {
  Link,
  Dialog,
  Input,
  InputNumber,
  Checkbox,
  Switch,
  Select,
  Option,
  Button,
  ButtonGroup,
  Form,
  FormItem,
  Alert,
  Icon,
  Row,
  Col,
  Card,
  Container,
  Tooltip,
  Header,
  Main,
  Footer,
  Divider,
  Loading,
  MessageBox,
  Message,
  Notification,
} from "element-ui";

locale.use(lang);

Vue.use(Link);
Vue.use(Dialog);
Vue.use(Input);
Vue.use(InputNumber);
Vue.use(Checkbox);
Vue.use(Switch);
Vue.use(Select);
Vue.use(Option);
Vue.use(Button);
Vue.use(ButtonGroup);
Vue.use(Form);
Vue.use(FormItem);
Vue.use(Alert);
Vue.use(Icon);
Vue.use(Row);
Vue.use(Col);
Vue.use(Card);
Vue.use(Container);
Vue.use(Header);
Vue.use(Main);
Vue.use(Footer);
Vue.use(Divider);
Vue.use(Tooltip);
Vue.use(Loading.directive);

Vue.prototype.$loading = Loading.service;
Vue.prototype.$msgbox = MessageBox;
Vue.prototype.$alert = MessageBox.alert;
Vue.prototype.$confirm = MessageBox.confirm;
Vue.prototype.$prompt = MessageBox.prompt;
Vue.prototype.$notify = Notification;
Vue.prototype.$message = Message;
