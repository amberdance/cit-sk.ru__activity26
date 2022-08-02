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
    path: "/recovery",
    component: () => import("@/components/recovery/SmsCode"),
    meta: { onlyForUnauthorized: true },
  },

  {
    path: "/recovery/password",
    name: "PasswordReset",
    meta: { onlyForUnauthorized: true },
    component: () => import("@/components/recovery/Password"),
    beforeEnter: (to, from, next) => {
      if (!_.has(to.params, "uuid")) next({ path: "/recovery" });
      else next();
    },
  },

  {
    path: "/registration",
    component: () => import("@/components/shared/RegistrationForm"),
    meta: { onlyForUnauthorized: true },
  },

  {
    path: "/poll/results",
    component: () => import("@/components/polls/PollResultList"),
  },

  {
    path: "/poll/:id",
    component: () => import("@/components/polls/Poll"),
  },

  {
    path: "/poll/:id/result",
    name: "PollResult",
    component: () => import("@/components/polls/PollResult"),
  },

  {
    path: "/polls",
    component: () => import("@/components/polls/PollList"),
  },

  {
    path: "/privacy-policy",
    component: () => import("@/components/shared/PrivacyPolicy"),
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
