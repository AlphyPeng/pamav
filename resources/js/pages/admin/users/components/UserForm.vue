<template>
    <v-form @submit.prevent="handleSubmit">
        <v-row>
            <v-col cols="12" class="d-flex">
                <!-- IMAGE PREVIEW -->
                <v-avatar rounded="lg" size="100" class="me-6 border-sm">
                    <v-img v-if="avatarPreview" :src="avatarPreview" cover />
                    <v-icon v-else icon="bx-user" size="80" class="text-disabled" />
                </v-avatar>

                <!-- UPLOAD PHOTO-->
                <div class="d-flex flex-column justify-center gap-2">
                    <div class="d-flex flex-wrap">
                        <v-btn color="primary" @click="refInputEl?.click()" prepend-icon="bx-upload">
                            <v-icon icon="bx-cloud-upload" class="d-sm-none" />
                            <span class="d-none d-sm-block">Upload new photo</span>
                        </v-btn>

                        <input ref="refInputEl" type="file" name="file" accept=".jpeg, .png, .jpg" hidden
                            @input="changeAvatar" />
                    </div>
                    <p class="text-body-1 mb-0">
                        Allowed JPG, JPEG or PNG. Max size of 2 MB
                    </p>
                    <span v-if="errors.avatar" class="text-error text-sm">
                        {{ errors.avatar[0] }}
                    </span>
                </div>
            </v-col>
        </v-row>

        <v-divider class="mt-6 mb-3" />

        <v-row>
            <v-col cols="12" class="pb-0">
                <h6 class="text-h6 font-weight-medium">Personal Information</h6>
            </v-col>

            <v-col md="4" cols="12">
                <v-text-field v-model="form.first_name" :error-messages="errors.first_name">
                    <template #label>
                        First Name <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="Middle Name" v-model="form.middle_name" :error-messages="errors.middle_name" />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field v-model="form.last_name" :error-messages="errors.last_name">
                    <template #label>
                        Last Name <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field v-model="form.employee_id" :error-messages="errors.employee_id">
                    <template #label>
                        Employee ID <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field type="password" v-model="form.password" :error-messages="errors.password">
                    <template #label>
                        Password <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field>
                    <template #label>
                        Role <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
        </v-row>

        <v-divider class="mt-6 mb-3" />

        <v-row>
            <v-col cols="12" class="pb-0">
                <h6 class="text-h6 font-weight-medium">Contact Details</h6>
            </v-col>

            <v-col md="6" cols="12">
                <v-text-field v-model="form.email" :error-messages="errors.email">
                    <template #label>
                        Email Address <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="6" cols="12">
                <v-text-field v-model="form.contact_number" prefix="+63" maxlength="10"
                    :error-messages="errors.contact_number">
                    <template #label>
                        Contact Number <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="Street / House No." v-model="form.street" />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="Barangay" v-model="form.barangay" />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="City / Municipality" v-model="form.city" />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="Province" v-model="form.province" />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="ZIP Code" v-model="form.zip" />
            </v-col>
        </v-row>

        <div class="d-flex justify-end ga-3 mt-4">
            <v-btn variant="tonal" color="grey" @click="$emit('cancel')">
                Cancel
            </v-btn>

            <v-btn type="submit" color="primary" prepend-icon="bx bx-check" :loading="loading">
                Create User
            </v-btn>
        </div>
    </v-form>
</template>

<script setup>
import { useSnackbarStore } from '@/stores/snackbar';
import { defineEmits, ref } from 'vue';

const emit = defineEmits(['cancel']);

const snackbar = useSnackbarStore();

const loading = ref(false);

const form = ref({
    avatar: '',
    first_name: '',
    middle_name: '',
    last_name: '',
    employee_id: '',
    password: '',
    role: '',
    email: '',
    contact_number: '',
    street: '',
    barangay: '',
    city: '',
    province: '',
    zip: '',
});

const errors = ref({});

const refInputEl = ref();
const avatarPreview = ref(null);

const changeAvatar = event => {
    const { files } = event.target
    if (files && files.length) {
        form.value.avatar = files[0]

        const fileReader = new FileReader()
        fileReader.readAsDataURL(files[0])
        fileReader.onload = () => {
            if (typeof fileReader.result === 'string') {
                avatarPreview.value = fileReader.result
            }
        }
    }
}

const handleSubmit = async () => {
    loading.value = true;
    errors.value = {};

    try {
        const formData = new FormData();

        for (const key in form.value) {
            if (form.value[key] !== null && form.value[key] !== '') {
                formData.append(key, form.value[key]);
            }
        }

        await axios.post('/api/admin/users', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            }
        })

        snackbar.triggerSnackbar('User successfully created!', 'success')

    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors || {};
        } else {
            console.error('An unexpected error occurred:', error);

            const errorMessage = error.response?.data?.message || 'An unexpected error occurred. Please try again.';
            snackbar.triggerSnackbar(errorMessage, 'error');
        }

    } finally {
        loading.value = false;
    }
}
</script>
<style></style>
