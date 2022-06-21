import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    name: "Home",
    component: () => import("@/views/Home.vue"),
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

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
