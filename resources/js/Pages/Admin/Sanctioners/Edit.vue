<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateSanctionerForm from '@/Pages/Admin/Sanctioners/Partials/UpdateSanctionerForm.vue';

defineProps({
    sanctioner: Object,
});
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Sanctioning Authority
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateSanctionerForm :sanctioner="sanctioner" />
            </div>
        </div>
    </AppLayout>
</template>
