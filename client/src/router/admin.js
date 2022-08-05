import { CMS_PREFFIX_ROUTE } from "../values";

export default [
  {
    path: CMS_PREFFIX_ROUTE,
    component: () => import("@/components/admin/Index"),
  },

  {
    path: CMS_PREFFIX_ROUTE + "/users",
    component: () => import("@/components/admin/UsersList"),
  },
];
