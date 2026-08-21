<template>
    <div>
        <v-data-table-server :headers="headers" :items="users" :loading="loading" hover hide-default-footer>
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
</script>
<style></style>
