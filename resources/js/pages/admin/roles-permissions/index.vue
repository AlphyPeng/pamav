<template>
    <v-container fluid>
        <v-card class="pa-4">
            <!-- HEADER -->
            <v-row align="center" justify="space-between">
                <v-col cols="12" md="6">
                    <div class="text-h4 font-weight-medium">Roles & Permissions</div>

                    <div class="text-body-2 text-medium-emphasis mt-1">
                        Manage system roles and access control permissions.
                    </div>
                </v-col>
                <v-col cols="12" md="auto">
                    <v-btn color="primary" :prepend-icon="buttonConfig.icon" @click="handleCreate(activeTab)">
                        {{ buttonConfig.text }}
                    </v-btn>
                </v-col>
            </v-row>

            <!-- TABS -->
            <v-tabs v-model="activeTab" class="my-5" color="primary" align-tabs="start" density="comfortable">
                <v-tab value="roles" prepend-icon="bx-shield-quarter">
                    Roles
                </v-tab>

                <v-tab value="permissions" prepend-icon="bx-key">
                    Permissions
                </v-tab>
            </v-tabs>

            <!-- TAB CONTENT -->
            <v-window v-model="activeTab">
                <v-window-item value="roles">
                    <RoleTable />
                </v-window-item>

                <v-window-item value="permissions">
                    <PermissionTable :permissions="permissions" :loading="loading" />
                </v-window-item>
            </v-window>
        </v-card>
    </v-container>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";

import PermissionTable from "./components/PermissionTable.vue";
import RoleTable from "./components/RoleTable.vue";

/*
|--------------------------------------------------------------------------
| Router
|--------------------------------------------------------------------------
*/

const route = useRoute();
const router = useRouter();

/*
|--------------------------------------------------------------------------
| State
|--------------------------------------------------------------------------
*/

const loading = ref(false);
const roles = ref([])
const permissions = ref([])

/*
|--------------------------------------------------------------------------
| Computed
|--------------------------------------------------------------------------
*/
const activeTab = computed({
    get() {
        return route.query.tab === 'roles' ? 'roles' : 'permissions';
    },
    set(val) {
        router.replace({
            name: 'roles-permissions.index',
            query: { ...route.query, tab: val }
        });
    }
});

const buttonConfig = computed(() => {
    if (activeTab.value === 'roles') {
        return {
            text: 'Add Role',
            icon: 'bx-shield-plus'
        }
    } else {
        return {
            text: 'Add Permission',
            icon: 'bx-key'
        };
    }
});

/*
|--------------------------------------------------------------------------
| Methods
|--------------------------------------------------------------------------
*/

const handleCreate = (value) => {
    if (value === 'roles') {
        router.push({
            name: "roles.create",
        });
    } else {
        router.push({
            name: "permissions.create",
        });
    }
};

const fetchData = async () => {
    loading.value = true;
    try {
        if (activeTab.value === 'roles') {
            const response = await axios.get('api/admin/permissions');
            roles.value = response.data;
        } else {
            const response = await axios.get('/api/admin/permissions');
            permissions.value = response.data;
        }

    } catch (error) {
        console.error("Failed to load:", error);

    } finally {
        loading.value = false;
    }
}

/*
|--------------------------------------------------------------------------
| Initial Load
|--------------------------------------------------------------------------
*/
onMounted(() => {
    fetchData();
})
</script>
<style></style>
