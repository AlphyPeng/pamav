export const routes = [
  { path: "/", redirect: "/dashboard" },
  {
    path: "/",
    component: () => import("@/layouts/default.vue"),
    children: [
      {
        path: "dashboard",
        component: () => import("@/pages/dashboard.vue"),
        meta: { requiresAuth: true },
      },
      {
        path: "admin",
        children: [
          {
            path: "users",
            name: "users.index",
            component: () => import("@/pages/Admin/User/Index.vue"),
            meta: { requiresAuth: true },
          },
          {
            path: "users/create",
            name: "users.create",
            component: () => import("@/pages/Admin/User/Create.vue"),
            meta: { requiresAuth: true },
          },
        ],
      },
      {
        path: "account-settings",
        component: () => import("@/pages/account-settings.vue"),
      },
      {
        path: "typography",
        component: () => import("@/pages/typography.vue"),
      },
      {
        path: "icons",
        component: () => import("@/pages/icons.vue"),
      },
      {
        path: "cards",
        component: () => import("@/pages/cards.vue"),
      },
      {
        path: "tables",
        component: () => import("@/pages/tables.vue"),
      },
      {
        path: "form-layouts",
        component: () => import("@/pages/form-layouts.vue"),
      },
    ],
  },
  {
    path: "/",
    component: () => import("@/layouts/blank.vue"),
    children: [
      {
        path: "login",
        component: () => import("@/pages/login.vue"),
        meta: { requiresGuest: true },
      },
      {
        path: "register",
        component: () => import("@/pages/register.vue"),
        meta: { requiresGuest: true },
      },
      {
        path: "/:pathMatch(.*)*",
        component: () => import("@/pages/[...error].vue"),
      },
    ],
  },
];
