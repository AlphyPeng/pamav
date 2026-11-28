<template>
  <v-badge dot location="bottom right" offset-x="3" offset-y="3" color="success" bordered>
    <v-avatar class="cursor-pointer" color="primary" variant="tonal">
      <v-img v-if="user.avatar" :src="`/storage/${user.avatar}`" alt="User Avatar" cover />
      <v-icon v-else icon="bx-user" color="grey-darken-1"></v-icon>

      <!-- SECTION Menu -->
      <v-menu activator="parent" width="230" location="bottom end" offset="14px">
        <v-list>
          <!-- 👉 User Avatar & Name -->
          <v-list-item>
            <template #prepend>
              <v-list-itemAction start>
                <v-badge dot location="bottom right" offset-x="3" offset-y="3" color="success">
                  <v-avatar color="primary" variant="tonal">
                    <v-img v-if="user.avatar" :src="`/storage/${user.avatar}`" alt="User Avatar" cover />

                    <v-icon v-else icon="bx-user" color="grey-darken-1"></v-icon>
                  </v-avatar>
                </v-badge>
              </v-list-itemAction>
            </template>

            <v-list-item-title class="font-weight-semibold">
              {{ user.first_name + ' ' + user.last_name }}
            </v-list-item-title>
            <v-list-itemSubtitle>Admin</v-list-itemSubtitle>
          </v-list-item>
          <d-divider class="my-2" />

          <!-- 👉 Profile -->
          <v-list-item link>
            <template #prepend>
              <v-icon class="me-2" icon="bx-user" size="22" />
            </template>

            <v-list-item-title>Profile</v-list-item-title>
          </v-list-item>

          <!-- 👉 Settings -->
          <v-list-item link>
            <template #prepend>
              <v-icon class="me-2" icon="bx-cog" size="22" />
            </template>

            <v-list-item-title>Settings</v-list-item-title>
          </v-list-item>

          <!-- 👉 Pricing -->
          <v-list-item link>
            <template #prepend>
              <v-icon class="me-2" icon="bx-dollar" size="22" />
            </template>

            <v-list-item-title>Pricing</v-list-item-title>
          </v-list-item>

          <!-- 👉 FAQ -->
          <v-list-item link>
            <template #prepend>
              <v-icon class="me-2" icon="bx-help-circle" size="22" />
            </template>

            <v-list-item-title>FAQ</v-list-item-title>
          </v-list-item>

          <!-- Divider -->
          <d-divider class="my-2" />

          <!-- 👉 Logout -->
          <v-list-item to="/login">
            <template #prepend>
              <v-icon class="me-2" icon="bx-log-out" size="22" />
            </template>

            <v-list-item-title @click="logout">Logout</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>
      <!-- !SECTION -->
    </v-avatar>
  </v-badge>
</template>

<script setup>
import { useAuthStore } from '@/stores/auth';
import { useSnackbarStore } from '@/stores/snackbar';
import { ref } from 'vue';
import { useRouter } from "vue-router";

const router = useRouter();
const authStore = useAuthStore();

const loading = ref(false);

const snackbar = useSnackbarStore();

const user = authStore.user;

const logout = async () => {
  loading.value = true;

  try {
    await axios.post('/api/logout');

    authStore.user = null;

    await router.push('/login');

  } catch (error) {
    console.error("Failed to logout:", error);

    const errorMessage = error.response?.data?.message || 'An unexpected error occurred. Please try again.';
    snackbar.triggerSnackbar(errorMessage, 'error');

  } finally {
    loading.value = false;
  }
}
</script>
