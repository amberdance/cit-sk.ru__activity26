import { CMS_PREFFIX_ROUTE } from "../values";

export default [
  {
    path: CMS_PREFFIX_ROUTE,
    component: () => import("@/components/layouts/CmsLayout"),
    redirect: { name: "Dashboard" },

    children: [
      {
        path: "dashboard",
        name: "Dashboard",
        component: () => import("@/components/admin/Dashboard"),
      },
      {
        path: "users",
        component: () => import("@/components/admin/UsersList"),
      },
      {
        path: "polls",
        component: () => import("@/components/admin/PollsList"),
      },
    ],
  },
];
