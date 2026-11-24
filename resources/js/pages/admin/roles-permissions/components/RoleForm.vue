<template>
    <v-form @submit.prevent="openCreateDialog">
        <v-row>
            <!-- ROLE NAME -->
            <v-col cols="12">
                <v-text-field v-model="form.name"
                    @update:model-value="(val) => (form.name = (val).toLowerCase().replace(' ', '-'))" label="Name"
                    :error-messages="errors.name" />
            </v-col>

            <v-col cols="12">
                <v-autocomplete v-model="form.permissions" :items="props.permissions" item-title="name" item-value="id"
                    label="Select Permission/s" chips closable-chips multiple clearable
                    :error-messages="errors.permissions" />
            </v-col>
        </v-row>

        <div class="d-flex justify-end ga-3 mt-4">
            <v-btn variant="tonal" color="grey" @click="$emit('cancel')">
                Cancel
            </v-btn>

            <v-btn type="submit" color="primary" prepend-icon="bx bx-check" :loading="loading">
                Submit Role
            </v-btn>
        </div>
    </v-form>

    <ConfirmDialog v-model="isCreateDialogOpen" title="Create Role" message="Are you sure you want to create this role?"
        confirm-text="Submit" color="primary" icon="bx-check" :loading="loading" @confirm="handleSubmit" />
</template>

<script setup>
import ConfirmDialog from '@/components/common/dialogs/ConfirmDialog.vue';
import { defineEmits, reactive } from 'vue';

const props = defineProps({
    permissions: {
        type: Array,
        default: () => [],
    },
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
    permissions: [],
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
