import Vue from "vue";
import lang from "element-ui/lib/locale/lang/ru-RU";
import locale from "element-ui/lib/locale";
import "@/styles/element-variables.scss";

import {
  Alert,
  Button,
  Container,
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
  Drawer,
  Skeleton,
  SkeletonItem,
  Card,
  Radio,
  RadioButton,
  RadioGroup,
  CheckboxGroup,
  Checkbox,
  CheckboxButton,
  Option,
  OptionGroup,
  Select,
  ButtonGroup,
  Switch,
  Progress,
  Table,
  TableColumn,
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
  Drawer,
  Skeleton,
  SkeletonItem,
  Card,
  Radio,
  RadioButton,
  RadioGroup,
  CheckboxGroup,
  Checkbox,
  CheckboxButton,
  Option,
  OptionGroup,
  Select,
  ButtonGroup,
  Switch,
  Progress,
  Table,
  TableColumn,
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
