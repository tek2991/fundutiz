<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CreateFinancialYearForm from '@/Pages/Admin/FinancialYears/Partials/CreateFinancialYearForm.vue';
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Financial Year
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <CreateFinancialYearForm />
            </div>
        </div>
    </AppLayout>
</template>
