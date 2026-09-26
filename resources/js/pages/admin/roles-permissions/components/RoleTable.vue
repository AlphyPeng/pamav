<template>
    <div>
        <v-data-table :headers="headers" :loading="loading" hover hide-default-footer>
            <!-- ACTIONS -->
            <template #item.actions="{ item }">
                <div class="d-flex justify-center ga-1">
                    <!-- VIEW -->
                    <v-btn icon="bx-show" size="small" variant="text" color="info" @click="viewRole(item)" />

                    <!-- EDIT -->
                    <v-btn icon="bx-edit" size="small" variant="text" color="primary" @click="editRole(item)" />

                    <!-- DELETE -->
                    <v-btn icon="bx-trash" size="small" variant="text" color="error" @click="deleteRole(item)" />
                </div>
            </template>

            <!-- NO DATA -->
            <template #no-data>
                <div class="pa-4 text-center">
                    No roles found.
                </div>
            </template>
        </v-data-table>
    </div>
</template>

<script setup>

const headers = [
    {
        title: "Name",
        key: "employee_id",
        width: 120,
        align: "center",
        sortable: false,
    },
    {
        title: "Date Created",
        key: "first_name",
        width: 250,
        align: "center",
        sortable: false,
    },
    {
        title: "Date Updated",
        key: "last_name",
        width: 250,
        align: "center",
        sortable: false,
    }
];
</script>
<style></style>
