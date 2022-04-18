<script setup>
import { computed } from 'vue';

const props = defineProps({
    type: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'inline-block p-4 rounded-t-lg border-b-2 border-indigo-400 text-sm font-medium leading-5 text-gray-900 focus:outline-none focus:border-indigo-700 transition'
        : 'inline-block p-4 rounded-t-lg border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition';
});
</script>

<template>
    <button :type="type" :class="classes">
        <slot />
    </button>
</template>
