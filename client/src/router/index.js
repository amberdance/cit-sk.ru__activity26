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
    path: "/registration",
    component: () => import("@/components/RegistrationForm.vue"),
  },

  {
    path: "/vote",
    component: () => import("@/components/polls/PollSingle.vue"),
  },
];

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  routes,
});

export default router;
