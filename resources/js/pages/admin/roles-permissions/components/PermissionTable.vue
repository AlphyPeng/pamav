<template>
    <div>
        <v-data-table :headers="headers" :loading="loading" hover hide-default-footer>
            <!-- ACTIONS -->
            <template #item.actions="{ item }">
                <div class="d-flex justify-center ga-1">
                    <!-- VIEW -->
                    <v-btn icon="bx-show" size="small" variant="text" color="info" @click="viewPermission(item)" />

                    <!-- EDIT -->
                    <v-btn icon="bx-edit" size="small" variant="text" color="primary" @click="editPermission(item)" />

                    <!-- DELETE -->
                    <v-btn icon="bx-trash" size="small" variant="text" color="error" @click="deletePermission(item)" />
                </div>
            </template>

            <!-- NO DATA -->
            <template #no-data>
                <div class="pa-4 text-center">
                    No permissions found.
                </div>
            </template>
        </v-data-table>
    </div>
</template>

<script setup>

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
</script>
<style></style>
