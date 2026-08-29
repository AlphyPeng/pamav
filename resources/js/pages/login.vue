<template>
  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <div class="position-relative my-sm-16">
      <!-- 👉 Auth Card -->
      <VCard class="auth-card" max-width="460" :class="$vuetify.display.smAndUp ? 'pa-6' : 'pa-0'">
        <VCardItem class="justify-center">
          <RouterLink to="/" class="app-logo">
            <!-- eslint-disable vue/no-v-html -->
            <div class="d-flex" v-html="logo" />
            <h1 class="app-logo-title">
              sneat
            </h1>
          </RouterLink>
        </VCardItem>

        <VCardText>
          <h4 class="text-h4 mb-1">
            Welcome to Sneat! 👋🏻
          </h4>
          <p class="mb-0">
            Please sign-in to your account and start the adventure
          </p>
        </VCardText>

        <VCardText>
          <VForm @submit.prevent="login">
            <VRow>
              <!-- Employee ID -->
              <VCol cols="12">
                <VTextField v-model="form.employeeId" autofocus label="Employee ID" type="text" />
              </VCol>

              <!-- Password -->
              <VCol cols="12">
                <VTextField v-model="form.password" label="Password" placeholder="············"
                  :type="isPasswordVisible ? 'text' : 'password'" autocomplete="password"
                  :append-inner-icon="isPasswordVisible ? 'bx-hide' : 'bx-show'"
                  @click:append-inner="isPasswordVisible = !isPasswordVisible" />

                <!-- remember me checkbox -->
                <div class="d-flex align-center justify-space-between flex-wrap my-6">
                  <VCheckbox v-model="form.remember" label="Remember me" />

                  <a class="text-primary" href="javascript:void(0)">
                    Forgot Password?
                  </a>
                </div>

                <!-- login button -->
                <VBtn block type="submit">
                  Login
                </VBtn>
              </VCol>

              <!-- create account -->
              <VCol cols="12" class="text-body-1 text-center">
                <span class="d-inline-block">
                  New on our platform?
                </span>
                <RouterLink class="text-primary ms-1 d-inline-block text-body-1" to="/register">
                  Create an account
                </RouterLink>
              </VCol>

              <VCol cols="12" class="d-flex align-center">
                <VDivider />
                <span class="mx-4 text-high-emphasis">or</span>
                <VDivider />
              </VCol>

              <!-- auth providers -->
              <VCol cols="12" class="text-center">
                <AuthProvider />
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from "vue-router";

import AuthProvider from '@/views/pages/authentication/AuthProvider.vue';
import logo from '@images/logo.svg?raw';

const router = useRouter();

const loading = ref(false);

const form = ref({
  employeeId: '',
  password: ''
})

const isPasswordVisible = ref(false)

const login = async () => {
  try {
    loading.value = true;

    await axios.get("/sanctum/csrf-cookie");

    const response = await axios.post("/api/login", {
      employee_id: form.value.employeeId,
      password: form.value.password,
    });

    router.push("/dashboard");

    console.log("Login successful:", response.data);

  } catch (error) {
    console.error("Login failed:", error);

    if (error.response?.status === 422) {
      // Validation error
      console.log(error.response.data);
    }

    if (error.response?.status === 401) {
      // Invalid credentials
      console.log(error.response.data.message);
    }

  } finally {
    loading.value = false;
  }
}
</script>

<style lang="scss">
@use "@core-scss/template/pages/page-auth";
</style>
