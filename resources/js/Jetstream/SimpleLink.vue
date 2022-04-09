<script setup>
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    href: String,
});

</script>

<template>
    <Link :href="href" class="no-underline hover:underline text-blue-800 font-semibold">
        <slot />
    </Link>
</template>
