<script setup>
import JetSectionBorder from "@/Jetstream/SectionBorder.vue";
import JetActionSection from "@/Jetstream/ActionSection.vue";
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
    userTeamInvitations: Array,
});

const acceptTeamInvitation = (invitation) => {
    Inertia.post(route("accept-team-invitations.accept", invitation), {
        preserveScroll: true,
    });
};

</script>

<template>
    <div v-if="userTeamInvitations.length > 0">
        <JetSectionBorder />

        <!-- Team Member Invitations -->
        <JetActionSection class="mt-10 sm:mt-0">
            <template #title> Pending Team Invitations </template>

            <template #description>
                You have been invited to join these teams and have been sent an
                invitation email. They may join the team by accepting the
                invitation.
            </template>

            <!-- Pending Team Member Invitation List -->
            <template #content>
                <div class="space-y-6">
                    <div
                        v-for="invitation in userTeamInvitations"
                        :key="invitation.id"
                        class="flex items-center justify-between">
                        <div class="text-gray-600">
                            {{ invitation.team.name }}
                        </div>

                        <div class="flex items-center">
                            <!-- Cancel Team Invitation -->
                            <button
                                v-if="true"
                                class="cursor-pointer ml-6 text-sm font-bold text-green-500 focus:outline-none"
                                @click="acceptTeamInvitation(invitation)">
                                Accept
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </JetActionSection>
    </div>
</template>
