<template>
    <div>
        <v-data-table :headers="headers" :items="permissions" :loading="loading" hover hide-default-footer>
            <!-- CREATED AT -->
            <template #item.created_at="{ item }">
                {{ formatDate(item.created_at) }}
            </template>

            <!-- UPDATED AT -->
            <template #item.updated_at="{ item }">
                {{ formatDate(item.updated_at) }}
            </template>

            <!-- ACTIONS -->
            <template #item.actions="{ item }">
                <div class="d-flex justify-center ga-1">
                    <!-- VIEW -->
                    <v-btn icon="bx-show" size="small" variant="text" color="info" />

                    <!-- EDIT -->
                    <v-btn icon="bx-edit" size="small" variant="text" color="primary" />

                    <!-- DELETE -->
                    <v-btn icon="bx-trash" size="small" variant="text" color="error" />
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
import dayjs from 'dayjs';
import { defineProps, } from 'vue';

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
    },
    {
        title: "Actions",
        key: "actions",
        width: 150,
        align: "center",
        sortable: false,
    },
];

const formatDate = (dateString) => {
    if (!dateString) return '-';
    return dayjs(dateString).format('MMM DD, YYYY h:mm A')
};
</script>
<style></style>
