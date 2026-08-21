<template>
    <div>
        <v-data-table-server :headers="headers" :items="users" :loading="loading" hover hide-default-footer>
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
                    <v-btn icon="bx-trash" size="small" variant="text" color="error" @click="deleteUser(item)" />
                </div>
            </template>

            <!-- NO DATA -->
            <template #no-data>
                <div class="pa-4 text-center">
                    No users found.
                </div>
            </template>
        </v-data-table-server>
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';

const router = useRouter();

defineProps({
    users: {
        type: Array,
        default: () => [],
    },

    loading: {
        type: Boolean,
        default: false,
    },
})

const headers = [
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

const deleteUser = (user) => {
    console.log("Delete user:", user);
};
</script>

<style></style>
