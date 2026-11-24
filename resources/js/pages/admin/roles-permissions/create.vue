<template>
    <v-container fluid>
        <v-card class="pa-4">
            <!-- HEADER -->
            <v-row align="center">
                <v-col cols=" 12" md="6">
                    <div class="text-h4 font-weight-medium">Create {{ titleText }}</div>

                    <div class="text-body-2 text-medium-emphasis mt-1">
                        Fill out the form below to add a new {{ titleText.toLowerCase() }}.
                    </div>
                </v-col>
            </v-row>

            <v-divider class="my-4" />

            <!-- FORM -->
            <RoleForm v-if="isRole" ref="formRef" :permissions="permissions" :loading="loading" :errors="errors"
                @submit="handleCreate" @cancel="goBack" />
            <PermissionForm v-else ref="formRef" :loading="loading" :errors="errors" @submit="handleCreate"
                @cancel="goBack" />
        </v-card>
    </v-container>
</template>

<script setup>
import { useSnackbarStore } from '@/stores/snackbar';
import { useRoute, useRouter } from 'vue-router';

import { onMounted } from 'vue';
import PermissionForm from './components/PermissionForm.vue';
import RoleForm from './components/RoleForm.vue';

const route = useRoute();
const router = useRouter();

const loading = ref(false);
const errors = ref({});
const formRef = ref(null);
const permissions = ref([]);

const isRole = computed(() => route.name === 'roles.create');
const titleText = computed(() => (isRole.value ? 'Role' : 'Permission'));

const goBack = () => {
    const tabQuery = isRole.value ? 'roles' : 'permissions';
    router.push({ name: "roles-permissions.index", query: { tab: tabQuery } });
};

const snackbar = useSnackbarStore();

// Fetch the list of Permissions
const fetchPermissions = async () => {
    loading.value = true;

    try {
        const response = await axios.get('/api/admin/roles/permissions');
        permissions.value = response.data;

    } catch (error) {
        console.error("Failed to load permissions:", error);

        const errorMessage = error.response?.data?.message || 'An unexpected error occurred. Please try again.';
        snackbar.triggerSnackbar(errorMessage, 'error');

    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    fetchPermissions();
});

// Creation of Role 
const handleCreate = async (formData) => {
    loading.value = true;
    errors.value = {};

    try {
        let response = null;

        if (titleText.value === 'Role') {
            response = await axios.post('/api/admin/roles', formData);
        } else { // permissions 
            response = await axios.post('/api/admin/permissions', formData);
        }

        snackbar.triggerSnackbar(response.data.message, 'success');

        // Clear the form
        formRef.value?.resetForm();

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
}

</script>

<style></style>
