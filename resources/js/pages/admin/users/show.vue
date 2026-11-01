<template>
    <v-container fluid>
        <v-card class="pa-4">
            <!-- HEADER -->
            <v-row align="center" justify="space-between">
                <v-col cols="12" md="6">
                    <div class="text-h4 font-weight-medium">View User</div>

                    <div class="text-body-2 text-medium-emphasis mt-1">
                        View detailed information and profile status of this user account.
                    </div>
                </v-col>
            </v-row>

            <v-divider class="my-4" />

            <UserForm mode="view" :initial-data="user" @cancel="goBack" />
        </v-card>
    </v-container>
</template>

<script setup>
import { useSnackbarStore } from '@/stores/snackbar';
import { useRoute, useRouter } from "vue-router";
import UserForm from "./components/UserForm.vue";

const snackbar = useSnackbarStore();

const route = useRoute();
const router = useRouter();
const userId = route.params.id;

const user = ref({});
const loading = ref(false);

const goBack = () => {
    router.push({ name: "users.index" });
};

const fetchUser = async () => {
    try {
        const response = await axios.get(`/api/admin/users/${userId}`)
        user.value = response.data.data;

    } catch (error) {
        console.error("Failed to load users:", error);

        const errorMessage = error.response?.data?.message || 'An unexpected error occurred. Please try again.';
        snackbar.triggerSnackbar(errorMessage, 'error');

    } finally {
        loading.value = false
    }
}

onMounted(() => {
    fetchUser();
})
</script>
<style></style>
