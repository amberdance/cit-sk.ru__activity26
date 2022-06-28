import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
  {
    path: "*",
    redirect: "/home",
  },

  { path: "/", redirect: "/home" },

  {
    path: "/home",
    component: () => import("@/views/Home"),
  },

  {
    path: "/register",
    component: () => import("@/components/RegisterForm.vue"),
  },

  {
    path: "/vote",
    component: () => import("@/components/VoteForm.vue"),
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
