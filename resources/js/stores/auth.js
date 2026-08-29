import axios from "@/plugins/axios";
import { defineStore } from "pinia";
import { computed, ref } from "vue";

export const useAuthStore = defineStore("auth", () => {
  const user = ref(null);
  const roles = ref([]);
  const permissions = ref([]);

  const fetchUser = async () => {
    try {
      const { data } = await axios.get("/api/profile");

      user.value = data.user;
      //   roles.value = data.roles;
      //   permissions.value = data.permissions;
    } catch (e) {
      user.value = null;
      roles.value = [];
      permissions.value = [];
    }
  };

  const isLoggedIn = computed(() => !!user.value);

  return { user, roles, permissions, fetchUser, isLoggedIn };
});
