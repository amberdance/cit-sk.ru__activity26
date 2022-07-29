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
    component: () => import("@/views/home/Index"),
  },

  {
    path: "/login",
    component: () => import("@/views/Auth"),
    meta: { onlyForUnauthorized: true },
  },

  {
    path: "/polls/:id",
    component: () => import("@/components/polls/Poll"),
  },

  {
    path: "/polls/:id/result",
    name: "PollResult",
    component: () => import("@/components/polls/PollResult"),
  },

  {
    path: "/registration",
    component: () => import("@/components/shared/RegistrationForm"),
    meta: { onlyForUnauthorized: true },
  },

  {
    path: "/privacy-policy",
    component: () => import("@/components/shared/PrivacyPolicy"),
    meta: { onlyForUnauthorized: true },
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
