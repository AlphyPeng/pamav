<template>
    <v-form @submit.prevent="openCreateDialog">
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

    <ConfirmDialog v-model="isCreateDialogOpen" title="Create Permission"
        message="Are you sure you want to create this permission?" confirm-text="Submit" color="primary" icon="bx-check"
        :loading="loading" @confirm="handleSubmit" />
</template>

<script setup>
import ConfirmDialog from '@/components/common/dialogs/ConfirmDialog.vue';
import { defineEmits, reactive } from 'vue';

const props = defineProps({
    loading: {
        type: Boolean,
        default: false
    },
    errors: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['cancel', 'submit']);

const isCreateDialogOpen = ref(false);

const form = reactive({
    name: '',
    guard_name: 'web'
})

const openCreateDialog = () => {
    isCreateDialogOpen.value = true;
};

const handleSubmit = async () => {
    emit('submit', form);
    isCreateDialogOpen.value = false;
};

const resetForm = () => {
    form.name = '';
};

defineExpose({ resetForm });

</script>
<style></style>
