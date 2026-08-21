<template>
    <div>
        <v-row class="my-2">
            <v-col cols="12" md="4">
                <v-text-field v-model="search" label="Search by Employee ID, Name, or Email" clearable />
            </v-col>

            <v-col cols="12" md="3">
                <v-select v-model="status" label="Status" />
            </v-col>
        </v-row>
    </div>
</template>

<script setup>
const search = defineModel('search');
const status = defineModel('status');
</script>
<style></style>
