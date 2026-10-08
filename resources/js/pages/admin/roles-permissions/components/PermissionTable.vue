<template>
    <div>
        <v-data-table :headers="headers" :items="permissions" :loading="loading" hover hide-default-footer>
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
defineProps({
    permissions: {
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
        title: "Name",
        key: "name",
        width: 120,
        align: "center",
        sortable: false,
    },
    {
        title: "Date Created",
        key: "created_at",
        width: 250,
        align: "center",
        sortable: false,
    },
    {
        title: "Date Updated",
        key: "updated_at",
        width: 250,
        align: "center",
        sortable: false,
    }
];
</script>
<style></style>
