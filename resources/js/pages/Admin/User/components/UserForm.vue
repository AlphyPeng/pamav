<template>
    <v-form>
        <v-row>
            <v-col cols="12" class="d-flex">
                <!-- IMAGE PREVIEW -->
                <v-avatar rounded="lg" size="100" class="me-6 border-sm" />

                <!-- UPLOAD PHOTO-->
                <div class="d-flex flex-column justify-center gap-5">
                    <div class="d-flex flex-wrap gap-2">
                        <v-btn color="primary" prepend-icon="bx-upload">
                            <v-icon icon="bx-cloud-upload" class="d-sm-none" />
                            <span class="d-none d-sm-block">Upload new photo</span>
                        </v-btn>

                        <input ref="refInputEl" type="file" name="file" accept=".jpeg,.png,.jpg" hidden />
                    </div>

                    <p class="text-body-1 mb-0">
                        Allowed JPG, JPEG or PNG. Max size of 2 MB
                    </p>
                </div>
            </v-col>
        </v-row>
    </v-form>
</template>

<script setup>

const loading = ref(false);
</script>
<style></style>
