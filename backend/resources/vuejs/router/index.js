import Vue from "vue";
import VueRouter from "vue-router";
import { canNavigate } from "@/libs/acl/routeProtection";
import {
  getHomeRouteForLoggedInUser,
  getUserData,
  isUserLoggedIn,
} from "@/auth/utils";
import useJwt from "@/auth/jwt/useJwt";

Vue.use(VueRouter);

const router = new VueRouter({
  mode: "history",
  base: process.env.BASE_URL,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
  routes: [],
});



export default router;
