<template>
    <v-container fluid>
        <v-card class="pa-4">
            <!-- HEADER -->
            <v-row align="center" justify="space-between">
                <v-col cols="12" md="6">
                    <div class="text-h4 font-weight-medium">Create User</div>

                    <div class="text-body-2 text-medium-emphasis mt-1">
                        Fill out the form below to add a new user.
                    </div>
                </v-col>
            </v-row>

            <v-divider class="my-4" />

            <UserForm ref="userFormRef" mode="create" :loading="loading" :errors="errors" @submit="handleCreate"
                @cancel="goBack" />
        </v-card>
    </v-container>
</template>

<script setup>
import { useSnackbarStore } from '@/stores/snackbar';
import { useRouter } from "vue-router";
import UserForm from "./components/UserForm.vue";

const router = useRouter();
const loading = ref(false);
const errors = ref({});

const goBack = () => {
    router.push({ name: "users.index" });
};

const snackbar = useSnackbarStore();

const userFormRef = ref(null);

const handleCreate = async (formData) => {
    loading.value = true;
    errors.value = {};

    try {
        const response = await axios.post('/api/admin/users', formData, {
            headers: { 'Content-Type': 'multipart/form-data' }
        });

        snackbar.triggerSnackbar(response.data.message, 'success');

        // Clear the form
        userFormRef.value?.resetForm();

    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
        } else {
            console.error('An unexpected error occurred:', error);

            const errorMessage = error.response?.data?.message || 'An unexpected error occurred. Please try again.';
            snackbar.triggerSnackbar(errorMessage, 'error');
        }

    } finally {
        loading.value = false;
    }
};
</script>

<style></style>
