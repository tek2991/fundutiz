<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import JetTabButton from "@/Jetstream/TabButton.vue";
import CreateAllocationForm from "@/Pages/Admin/Transactions/Partials/CreateAllocationForm.vue";
import CreateUtilizationForm from "@/Pages/Admin/Transactions/Partials/CreateUtilizationForm.vue";

const selectedTab = ref("utilization");
const setTab = value => selectedTab.value = value;
defineProps({
    funds: Object,
    sanctioners: Object,
});
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Transactions ({{ $page.props.user.current_team ? $page.props.user.current_team.name : 'No Team!' }})
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <div
                    class="bg-white sm:rounded-lg text-sm font-medium text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700">
                    <ul class="flex flex-wrap -mb-px text-center">
                        <li class="mr-2">
                            <JetTabButton
                                @click="tab = setTab('utilization')"
                                :active="selectedTab == 'utilization'">
                                Utilization
                            </JetTabButton>
                        </li>
                        <li class="mr-2">
                            <JetTabButton
                                @click="tab = setTab('allocation')"
                                :active="selectedTab == 'allocation'">
                                Allocation
                            </JetTabButton>
                        </li>
                    </ul>
                    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                        <CreateAllocationForm v-if="selectedTab == 'allocation'" :funds="funds" :sanctioners="sanctioners"></CreateAllocationForm>
                        <CreateUtilizationForm v-else :funds="funds" :sanctioners="sanctioners"></CreateUtilizationForm>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
