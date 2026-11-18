<template>
    <v-form @submit.prevent="handleSubmit">
        <v-row>
            <!-- ROLE NAME -->
            <v-col cols="12">
                <v-text-field label="Name" />
            </v-col>
        </v-row>

        <div class="d-flex justify-end ga-3 mt-4">
            <v-btn variant="tonal" color="grey" @click="$emit('cancel')">
                Cancel
            </v-btn>

            <v-btn type="submit" color="primary" prepend-icon="bx bx-check" :loading="loading">
                Submit Permission
            </v-btn>
        </div>
    </v-form>
</template>

<script setup>
</script>
<style></style>
