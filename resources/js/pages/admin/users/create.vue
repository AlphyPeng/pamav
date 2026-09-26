<template>
    <v-container fluid>
        <v-card class="pa-4">
            <!-- HEADER -->
            <v-row align="center" justify="space-between">
                <v-col cols="12" md="6">
                    <div class="text-h4 font-weight-medium">Create User</div>

                    <div class="text-body-2 text-medium-emphasis mt-1">
                        Fill out the form below to add a new user.
                    </div>
                </v-col>

                <v-col cols="12" md="auto">
                    <div class="d-flex ga-3">
                        <v-btn variant="tonal" color="grey" prepend-icon="bx bx-arrow-back" @click="goBack">
                            Back
                        </v-btn>

                        <v-btn variant="flat" color="primary" prepend-icon="bx bx-check">
                            Submit
                        </v-btn>
                    </div>
                </v-col>
            </v-row>

            <v-divider class="my-4" />

            <UserForm />
        </v-card>
    </v-container>
</template>

<script setup>
import { useRouter } from "vue-router";
import UserForm from "./components/UserForm.vue";

const router = useRouter();

const goBack = () => {
    router.push({ name: "users.index" });
};
</script>

<style></style>
