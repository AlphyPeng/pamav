<template>
    <div>
        <!-- FILTER -->
        <v-row class="my-2">
            <v-col cols="12" md="4">
                <v-text-field v-model="search" label="Search Permission Name" clearable prepend-inner-icon="bx-search"
                    @click:clear="clearSearch" />
            </v-col>
        </v-row>

        <!-- TABLE -->
        <v-data-table :headers="headers" :items="permissions" :search="search" v-model:page="page" :items-per-page="10"
            :filter-keys="['name']" :loading="loading" hover hide-default-footer>
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
                    <v-btn icon="bx-trash" size="small" variant="text" color="error" @click="openDeleteDialog(item)" />
                </div>
            </template>

            <!-- NO DATA -->
            <template #no-data>
                <div class="pa-4 text-center">
                    No permissions found.
                </div>
            </template>
        </v-data-table>

        <!-- PAGINATION -->
        <div class="d-flex justify-end mt-4">
            <v-pagination v-model="page" :length="totalPages" :total-visible="7" />
        </div>

        <ConfirmDialog v-model="isDeleteDialogOpen" title="Permission Delete"
            :message="`Are you sure you want to delete this user <b>${selectedPermission?.name}</b>?`"
            confirm-text="Delete" color="error" icon="bx-trash" :loading="loading" @confirm="handleConfirmDelete" />
    </div>
</template>

<script setup>
import ConfirmDialog from '@/components/common/dialogs/ConfirmDialog.vue';
import dayjs from 'dayjs';
import { computed, ref } from 'vue';

const props = defineProps({
    permissions: {
        type: Array,
        default: () => [],
    },

    loading: {
        type: Boolean,
        default: false,
    },
});

const search = ref('');
const page = ref(1);
const itemsPerPage = 10;

const isDeleteDialogOpen = ref(false);
const selectedPermission = ref(null);

const emit = defineEmits('delete-permission');

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

// Pagination
const totalPages = computed(() => {
    const filtered = props.permissions.filter(item =>
        item.name?.toLowerCase().includes(search.value.toLowerCase())
    );

    return Math.ceil(filtered.length / itemsPerPage);
});

watch(search, () => {
    page.value = 1;
});

// Clear Search Field
const clearSearch = () => {
    search.value = '';
    page.value = 1;
};

// Delete Confirmation
const openDeleteDialog = (permission) => {
    selectedPermission.value = permission;
    isDeleteDialogOpen.value = true;
};

const handleConfirmDelete = () => {
    emit('delete-permission', selectedPermission.value);
    isDeleteDialogOpen.value = false;
};
</script>
<style></style>
