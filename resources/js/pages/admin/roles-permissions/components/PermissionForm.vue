<template>
    <v-form @submit.prevent="handleSubmit">
        <v-row>
            <!-- PERMISSION NAME -->
            <v-col cols="12">
                <v-text-field v-model="form.name" label="Name" :error-messages="errors.name" />
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
import { defineEmits, reactive } from 'vue';

const emit = defineEmits(['cancel']);

const loading = ref(false);

const form = reactive({
    name: '',
    guard_name: 'web'
})

const errors = reactive({
    name: []
});

const handleSubmit = async () => {
    loading.value = true;
    errors.name = [];

    try {
        await axios.post('/api/admin/permissions', form)

    } catch (error) {
        if (error.response?.status === 422) {
            errors.name = error.response.data.errors.name || [];
        }
    } finally {
        loading.value = false;
    }
}
</script>
<style></style>
