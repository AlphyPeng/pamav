<template>
  <VApp>
    <RouterView />

    <!-- Global Snackbar (Notif) -->
    <v-snackbar v-model="snackbarStore.show" :color="snackbarStore.color" timeout="3000" location="top right">
      <div class="d-flex align-center">
        <v-icon :icon="snackbarStore.icon" class="me-2" size="22"></v-icon>
        <span>{{ snackbarStore.message }}</span>
      </div>
    </v-snackbar>
  </VApp>
</template>

<script setup>
import { useSnackbarStore } from '@/stores/snackbar';
const snackbarStore = useSnackbarStore();
</script>
