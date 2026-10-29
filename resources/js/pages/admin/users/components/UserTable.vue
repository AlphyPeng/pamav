<template>
    <div>
        <v-data-table :headers="headers" :items="users" :loading="loading" hover hide-default-footer>
            <!-- PROFILE -->
            <template #item.avatar="{ item }">
                <v-avatar size="36" class="my-1">
                    <v-img v-if="item.avatar" :src="`/storage/${item.avatar}`" alt="User Avatar" cover />

                    <v-icon v-else icon="bx-user" color="grey-darken-1"></v-icon>
                </v-avatar>
            </template>

            <!-- STATUS -->
            <template #item.status="{ item }">
                <v-chip :color="getStatusColor(item.status)" size="small" variant="tonal">
                    {{ formatStatus(item.status) }}
                </v-chip>
            </template>

            <!-- ACTIONS -->
            <template #item.actions="{ item }">
                <div class="d-flex justify-center ga-1">
                    <!-- VIEW -->
                    <v-btn icon="bx-show" size="small" variant="text" color="info" @click="viewUser(item)" />

                    <!-- EDIT -->
                    <v-btn icon="bx-edit" size="small" variant="text" color="primary" @click="editUser(item)" />

                    <!-- DELETE -->
                    <v-btn icon="bx-trash" size="small" variant="text" color="error" @click="openDeleteDialog(item)" />
                </div>
            </template>

            <!-- NO DATA -->
            <template #no-data>
                <div class="pa-4 text-center">
                    No users found.
                </div>
            </template>
        </v-data-table>

        <ConfirmDialog v-model="isDeleteDialogOpen" title="User Delete"
            :message="`Are you sure you want to delete this user <b>${selectedUser?.employee_id}</b>?`"
            confirm-text="Delete" color="error" icon="bx-trash" :loading="isDeleting" @confirm="handleDelete" />
    </div>
</template>

<script setup>
import ConfirmDialog from '@/components/common/dialogs/ConfirmDialog.vue';
import { useSnackbarStore } from '@/stores/snackbar';
import { useRouter } from 'vue-router';

const snackbar = useSnackbarStore();

const router = useRouter();

const props = defineProps({
    users: {
        type: Array,
        default: () => [],
    },

    loading: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['fetch-users']);

const isDeleteDialogOpen = ref(false);
const selectedUser = ref(null);
const isDeleting = ref(false);

const headers = [
    {
        title: "Profile",
        key: "avatar",
        width: 80,
        align: "center",
        sortable: false,
    },
    {
        title: "Employee Id",
        key: "employee_id",
        width: 120,
        align: "center",
        sortable: false,
    },
    {
        title: "First Name",
        key: "first_name",
        width: 250,
        align: "center",
        sortable: false,
    },
    {
        title: "Last Name",
        key: "last_name",
        width: 250,
        align: "center",
        sortable: false,
    },
    {
        title: "Email",
        key: "email",
        width: 300,
        align: "center",
        sortable: false,
    },
    {
        title: "Status",
        key: "status",
        width: 120,
        align: "center",
        sortable: false,
    },
    {
        title: "Actions",
        key: "actions",
        width: 150,
        align: "center",
        sortable: false,
    },
];

/*
|--------------------------------------------------------------------------
| Format Status
|--------------------------------------------------------------------------
*/

const formatStatus = (status) => {
    if (!status) {
        return "";
    }

    return status.charAt(0).toUpperCase() + status.slice(1);
};

/*
|--------------------------------------------------------------------------
| Status Color
|--------------------------------------------------------------------------
*/

const getStatusColor = (status) => {
    const colors = {
        active: "success",
        inactive: "warning",
        suspended: "error",
    };

    return colors[status] ?? "secondary";
};

/*
|--------------------------------------------------------------------------
| Actions
|--------------------------------------------------------------------------
*/

const viewUser = (user) => {
    router.push(`/admin/users/${user.id}`);
};

const editUser = (user) => {
    router.push(`/admin/users/${user.id}/edit`);
};

const openDeleteDialog = (user) => {
    selectedUser.value = user;
    isDeleteDialogOpen.value = true;
};

const handleDelete = async () => {
    isDeleting.value = true;

    try {
        await axios.delete(`/api/admin/users/${selectedUser.value.id}`)

        selectedUser.value = null;
        isDeleteDialogOpen.value = false;

        // Fetch latest data
        emit('fetch-users');
        snackbar.triggerSnackbar('User successfully deleted!', 'success');

    } catch (error) {
        console.error('An unexpected error occurred:', error);

        const errorMessage = error.response?.data?.message || 'An unexpected error occurred. Please try again.';
        snackbar.triggerSnackbar(errorMessage, 'error');

    } finally {
        isDeleting.value = false;
    }
}
</script>

<style></style>
