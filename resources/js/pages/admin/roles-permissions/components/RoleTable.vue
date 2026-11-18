<template>
    <div>
        <!-- FILTER -->
        <v-row class="my-2">
            <v-col cols="12" md="4">
                <v-text-field v-model="search" label="Search Permission Name" clearable
                    prepend-inner-icon="bx-search" />
            </v-col>
        </v-row>

        <!-- TABLE -->
        <v-data-table :headers="headers" :search="search" :filter-keys="['name']" :loading="loading" hover
            hide-default-footer>
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

const search = ref('');

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
</script>
<style></style>
