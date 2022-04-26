<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetTabButton from "@/Jetstream/TabButton.vue";
import EditAllocationForm from "@/Pages/Admin/Transactions/Partials/EditAllocationForm.vue";
import EditUtilizationForm from "@/Pages/Admin/Transactions/Partials/EditUtilizationForm.vue";

const selectedTab = props.transaction.type

const props = defineProps({
    transaction: Object,
    funds: Object,
    sanctioners: Object,
});
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Transactions Details
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div
                    class="bg-white sm:rounded-lg text-sm font-medium text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-center">
                        <li class="mr-2">
                            <JetTabButton
                                :active="selectedTab == 'utilization'">
                                Utilization
                            </JetTabButton>
                        </li>
                        <li class="mr-2">
                            <JetTabButton
                                :active="selectedTab == 'allocation'">
                                Allocation
                            </JetTabButton>
                        </li>
                    </ul>
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                        <EditAllocationForm v-if="selectedTab == 'allocation'" :funds="funds" :sanctioners="sanctioners" :transaction="transaction"></EditAllocationForm>
                        <EditUtilizationForm v-else :funds="funds" :sanctioners="sanctioners" :transaction="transaction"></EditUtilizationForm>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
