<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import UpdateFinancialYearForm from '@/Pages/Admin/FinancialYears/Partials/UpdateFinancialYearForm.vue';

defineProps({
    financialYear: Object,
    currentFinancialYear: Object,
});
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Financial Year
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateFinancialYearForm :financialYear="financialYear" :currentFinancialYear="currentFinancialYear" />
            </div>
        </div>
    </AppLayout>
</template>
