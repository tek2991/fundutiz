<script setup>
import { ref } from 'vue';

defineProps({
    modelValue: String | Number,
});

defineEmits(['update:modelValue']);


</script>

<template>
    <select
        class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
    >
        <slot />
    </select>
</template>

