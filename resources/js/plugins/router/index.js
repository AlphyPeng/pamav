import { useAuthStore } from "@/stores/auth";
import { createRouter, createWebHistory } from "vue-router";
import { routes } from "./routes";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
});

router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore();

  // only fetch once if not loaded yet
  if (auth.user === null) {
    await auth.fetchUser();
  }

  const isLoggedIn = auth.isLoggedIn;

  if (to.meta.requiresAuth && !isLoggedIn) {
    return next("/login");
  }

  if (to.meta.guestOnly && isLoggedIn) {
    return next("/dashboard");
  }

  if (to.meta.permission) {
    const hasPermission = auth.permissions.includes(to.meta.permission);

    if (!hasPermission) {
      return next("/403");
    }
  }

  return next();
});

export default function (app) {
  app.use(router);
}
export { router };
