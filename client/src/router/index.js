import Vue from "vue";
import VueRouter from "vue-router";

const originalPush = VueRouter.prototype.push;

VueRouter.prototype.push = function push(location) {
  return originalPush.call(this, location).catch(err => err);
};

Vue.use(VueRouter);

const routes = [
  {
    path: "*",
    redirect: "/home"
  },

  { path: "/", redirect: "/home" },

  {
    path: "/home",
    component: () => import("@/views/Home")
  }
];

const router = new VueRouter({
  base: process.env.BASE_URL,
  routes
});

export default router;
