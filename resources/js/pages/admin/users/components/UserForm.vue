<template>
    <v-form>
        <v-row>
            <v-col cols="12" class="d-flex">
                <!-- IMAGE PREVIEW -->
                <v-avatar rounded="lg" size="100" class="me-6 border-sm">
                    <v-img v-if="accountDataLocal.avatarImg" :src="accountDataLocal.avatarImg" cover />
                    <v-icon v-else icon="bx-user" size="80" class="text-disabled" />
                </v-avatar>

                <!-- UPLOAD PHOTO-->
                <div class="d-flex flex-column justify-center gap-5">
                    <div class="d-flex flex-wrap gap-2">
                        <v-btn color="primary" @click="refInputEl?.click()" prepend-icon="bx-upload">
                            <v-icon icon="bx-cloud-upload" class="d-sm-none" />
                            <span class="d-none d-sm-block">Upload new photo</span>
                        </v-btn>

                        <input ref="refInputEl" type="file" name="file" accept=".jpeg,.png,.jpg" hidden
                            @input="changeAvatar" />
                    </div>

                    <p class="text-body-1 mb-0">
                        Allowed JPG, JPEG or PNG. Max size of 2 MB
                    </p>
                </div>
            </v-col>
        </v-row>

        <v-divider class="mt-6 mb-3" />

        <v-row>
            <v-col cols="12" class="pb-0">
                <h6 class="text-h6 font-weight-medium">Personal Information</h6>
            </v-col>

            <v-col md="4" cols="12">
                <v-text-field>
                    <template #label>
                        First Name <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field>
                    <template #label>
                        Middle Name <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field>
                    <template #label>
                        Last Name <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="6" cols="12">
                <v-text-field>
                    <template #label>
                        Employee ID <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="6" cols="12">
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
                <v-text-field>
                    <template #label>
                        Email Address <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="6" cols="12">
                <v-text-field>
                    <template #label>
                        Contact Number <span class="text-error">*</span>
                    </template>
                </v-text-field>
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="Street / House No." />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="Barangay" />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="City / Municipality" />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="Province" />
            </v-col>
            <v-col md="4" cols="12">
                <v-text-field label="ZIP Code" />
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
import { defineEmits } from 'vue';

const emit = defineEmits(['cancel']);

const loading = ref(false);

const form = {
    avatarImg: '',
    firstName: '',
    middleName: '',
    lastName: '',
    employeeId: '',
    role: '',
    email: '',
    phone: '',
    street: '',
    barangay: '',
    city: '',
    province: '',
    zip: '',
}

const refInputEl = ref()
const accountDataLocal = ref(structuredClone(form))

const changeAvatar = event => {
    const { files } = event.target
    if (files && files.length) {
        const fileReader = new FileReader()
        fileReader.readAsDataURL(files[0])
        fileReader.onload = () => {
            if (typeof fileReader.result === 'string') {
                accountDataLocal.value.avatarImg = fileReader.result
            }
        }
    }
}
</script>
<style></style>
