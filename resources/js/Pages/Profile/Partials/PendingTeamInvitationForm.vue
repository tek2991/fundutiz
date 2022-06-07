<script setup>

</script>

<template>
    <div
        v-if="
            team.team_invitations.length > 0 &&
            userPermissions.canAddTeamMembers
        ">
        <JetSectionBorder />

        <!-- Team Member Invitations -->
        <JetActionSection class="mt-10 sm:mt-0">
            <template #title> Pending Team Invitations </template>

            <template #description>
                You have been invited to join these teams and have been sent
                an invitation email. They may join the team by accepting the
                invitation.
            </template>

            <!-- Pending Team Member Invitation List -->
            <template #content>
                <div class="space-y-6">
                    <div
                        v-for="invitation in team.team_invitations"
                        :key="invitation.id"
                        class="flex items-center justify-between">
                        <div class="text-gray-600">
                            {{ invitation.email }}
                        </div>

                        <div class="flex items-center">
                            <!-- Cancel Team Invitation -->
                            <button
                                v-if="userPermissions.canRemoveTeamMembers"
                                class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                @click="cancelTeamInvitation(invitation)">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </JetActionSection>
    </div>
</template>
