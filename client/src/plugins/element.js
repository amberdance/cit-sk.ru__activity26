import { ElButton } from "element-plus";
import locale from "element-plus/lib/locale";
import ru from "element-plus/es/locale/lang/ru";

export default (app) => {
  locale.use(ru);
  app.use(ElButton);
};
