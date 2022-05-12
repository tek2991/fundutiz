<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PieChart from "@/Charts/PieChart.vue";
import BarChart from "@/Charts/BarChart.vue";

const props = defineProps({
    pieChartData: Array,
    barChartData: Array,
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard ({{
                    $page.props.user.current_team
                        ? $page.props.user.current_team.name
                        : "No Team!"
                }})
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <!-- Pie Charts -->
                    <div
                        class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 grid gap-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 text-center">
                        <div
                            v-for="item in pieChartData"
                            :key="item.name"
                            class="block p-6 max-w-sm bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <h3
                                class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                <span
                                    v-if="
                                        (item.data.fund_data.fund_balance /
                                            item.data.fund_data
                                                .total_allocations) *
                                            100 <
                                        20
                                    ">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 mb-1 inline text-orange-600"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="2">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </span>
                                {{ item.name }}
                            </h3>
                            <PieChart
                                :labels="item.data.labels"
                                :backgroundColors="item.data.backgroundColors"
                                :data="item.data.data" />
                            <ul role="list" class="my-7 space-y-5">
                                <li class="flex space-x-3">
                                    <span
                                        class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">
                                        Total Fund:
                                        {{
                                            item.data.fund_data
                                                .total_allocations
                                        }}
                                    </span>
                                </li>
                                <li class="flex space-x-3">
                                    <span
                                        class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">
                                        Utilization:
                                        {{
                                            item.data.fund_data
                                                .total_utilization_incured +
                                            item.data.fund_data
                                                .total_utilization_proposed
                                        }}
                                    </span>
                                </li>
                                <li class="flex space-x-3">
                                    <span
                                        class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">
                                        Balance:
                                        {{ item.data.fund_data.fund_balance }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <!-- Bar Chart -->
                    </div>
                    <div
                        class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 text-center">
                        <div
                            class="block p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
                            <h3
                                class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                User wise Utilization
                            </h3>
                            <BarChart
                                :height="200"
                                :labels="barChartData.labels"
                                :backgroundColors="barChartData.backgroundColors"
                                :data="barChartData.data" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
