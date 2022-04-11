<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import UpdateFundForm from "@/Pages/Admin/Funds/Partials/UpdateFundForm.vue";
import { computed } from "vue";

const props = defineProps({
    fund: Object,
    assignedTeams: Array,
    user: Object,
});

const allTeams = computed(() => props.user.all_teams);
</script>

<template>
    <AppLayout title="Create Team">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Update Fund (Head Of Account)
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <UpdateFundForm
                    :fund="fund"
                    :assignedTeams="assignedTeams"
                    :allTeams="allTeams" />
            </div>
        </div>
    </AppLayout>
</template>
