<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PieChart from "@/Charts/PieChart.vue";

const props = defineProps({
    pieChartData: Array,
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard ({{ $page.props.user.current_team ? $page.props.user.current_team.name : 'No Team!' }})
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <div
                        class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8 grid gap-4 grid-cols-1 md:grid-cols-2 xl:grid-cols-3 text-center">
                        <div v-for="item in pieChartData" :key="item.name" class="bg-white p-6 overflow-hidden shadow-xl sm:rounded-lg">
                            <h3 class="text-xl">{{ item.name }}</h3>
                            <PieChart
                                :labels="item.data.labels"
                                :backgroundColors="item.data.backgroundColors"
                                :data="item.data.data" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
