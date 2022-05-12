<template>
    <Bar
        :chart-options="chartOptions"
        :chart-data="chartData"
        :chart-id="chartId"
        :dataset-id-key="datasetIdKey"
        :plugins="plugins"
        :css-classes="cssClasses"
        :styles="styles"
        :width="width"
        :height="height" />
</template>

<script setup>
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

const props = defineProps({
    chartId: {
        type: String,
        default: "bar-chart",
    },
    datasetIdKey: {
        type: String,
        default: "label",
    },
    width: {
        type: Number,
        default: 400,
    },
    height: {
        type: Number,
        default: 400,
    },
    cssClasses: {
        default: "",
        type: String,
    },
    styles: {
        type: Object,
        default: () => {},
    },
    plugins: {
        type: Object,
        default: () => {},
    },
    labels: {
        type: Array,
        default: () => ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
    },
    backgroundColors: {
        type: Array,
        default: () => [
            "rgba(255, 99, 132)",
            "rgba(54, 162, 235)",
            "rgba(255, 206, 86)",
            "rgba(75, 192, 192)",
            "rgba(153, 102, 255)",
            "rgba(255, 159, 64)",
        ],
    },
    data: {
        type: Array,
        default: () => [
            Math.random() * 100,
            Math.random() * 100,
            Math.random() * 100,
            Math.random() * 100,
            Math.random() * 100,
            Math.random() * 100,
        ],
    },
});

const chartData = {
    labels: props.labels,
    datasets: [
        {
            backgroundColor: props.backgroundColors,
            data: props.data,
        },
    ],
};
const chartOptions = {
    responsive: true,
};
</script>
