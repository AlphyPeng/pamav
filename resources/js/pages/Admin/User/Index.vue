<template>
    <v-container fluid>
        <v-card class="pa-4">
            <!-- HEADER -->
            <v-row align="center" justify="space-between">
                <v-col cols="12" md="6">
                    <div class="text-h4 font-weight-medium">Users</div>
                </v-col>

                <v-col cols="12" md="auto">
                    <v-btn color="primary" prepend-icon="bx-user-plus">
                        Add User
                    </v-btn>
                </v-col>
            </v-row>

            <!-- FILTERS -->
            <UserFilter v-model:search="search" v-model:status="status" />

            <v-divider class="mb-4" />

            <!-- TABLE -->
            <UserTable :users="users" :loading="loading" />

            <!-- PAGINATION -->
            <div class="d-flex justify-end mt-4">
                <v-pagination v-model="page" :length="totalPages" :total-visible="7" />
            </div>
        </v-card>
    </v-container>
</template>

<script setup>
import { ref } from "vue";

import UserFilter from "./components/UserFilter.vue";
import UserTable from "./components/UserTable.vue";

/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/

const search = ref("");
const status = ref(null);

const page = ref(1);
const perPage = ref(10);

const loading = ref(false);
const users = ref([]);

const totalItems = ref(0);

</script>
<style></style>
