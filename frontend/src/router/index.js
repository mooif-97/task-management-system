import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    component: () => import("../views/Home/Home.vue"),
    props: { msg: "Heyy" },
  },
  {
    path: "/task-listing",
    component: () => import("../views/TaskListing/TaskListing.vue"),
    props: { msg: "Heyy" },
  },
  {
    path: "/:pathMatch(.*)*",
    name: "not-found",
    component: () => import("../views/NotFound/NotFound.vue"),
  },
];

const router = createRouter({
  routes,
  history: createWebHistory(),
});

export default router;
