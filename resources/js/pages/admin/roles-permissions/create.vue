<template>
    <v-container fluid>
        <v-card class="pa-4">
            <!-- HEADER -->
            <v-row align="center">
                <v-col cols=" 12" md="6">
                    <div class="text-h4 font-weight-medium">Create {{ titleText }}</div>

                    <div class="text-body-2 text-medium-emphasis mt-1">
                        Fill out the form below to add a new {{ titleText.toLowerCase() }}.
                    </div>
                </v-col>
            </v-row>

            <v-divider class="my-4" />

            <!-- FORM -->
            <RoleForm v-if="isRole" @cancel="goBack" />
            <PermissionForm v-else @cancel="goBack" />
        </v-card>
    </v-container>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';

import PermissionForm from './components/PermissionForm.vue';
import RoleForm from './components/RoleForm.vue';
/*
|--------------------------------------------------------------------------
| Router
|--------------------------------------------------------------------------
*/

const route = useRoute();
const router = useRouter();

/*
|--------------------------------------------------------------------------
| Computed
|--------------------------------------------------------------------------
*/

const isRole = computed(() => route.name === 'roles.create');
const titleText = computed(() => (isRole.value ? 'Role' : 'Permission'));

/*
|--------------------------------------------------------------------------
| Methods
|--------------------------------------------------------------------------
*/

const goBack = () => {
    const tabQuery = isRole.value ? 'roles' : 'permissions';
    router.push({ name: "roles-permissions.index", query: { tab: tabQuery } });
};



</script>

<style></style>
