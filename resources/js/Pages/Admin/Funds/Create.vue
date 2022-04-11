<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateFundForm from '@/Pages/Admin/Funds/Partials/CreateFundForm.vue';
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Fund (Head Of Account)
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateFundForm />
            </div>
        </div>
    </AppLayout>
</template>
