import Vue from "vue";
import VueRouter from "vue-router";

const originalPush = VueRouter.prototype.push;

VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch((err) => err);
};

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
    path: "/login",
    component: () => import("@/views/Auth"),
    meta: { onlyForUnauthorized: true },
  },

  {
    path: "/poll/:id",
    component: () => import("@/components/polls/Poll"),
  },

  {
    path: "/registration",
    component: () => import("@/components/RegistrationForm"),
    meta: { onlyForUnauthorized: true },
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
