<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import WarningBadge from "@/Icons/WarningBadge.vue";

const props = defineProps({
    fund: Object,
    assignedTeams: Array,
    allTeams: Array,
});

const form = useForm({
    name: props.fund.name,
    teams: {},
});

props.allTeams.forEach((team) => {
    form.teams[team.id] = props.assignedTeams.some((assignedTeam) => assignedTeam.id === team.id);
});

const select_all = ref(props.assignedTeams.length === props.allTeams.length);

watch(
    () => select_all.value,
    (value) => {
        for (const team of props.allTeams) {
            form.teams[team.id] = value;
        }
    }
);

const submit = () => {
    form.put(route("admin.fund.update", props.fund.id), {
        errorBag: "updateFund",
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="submit">
        <template #title> Update Financial Year Details </template>

        <template #description>
            Update the details of the Head of Account.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Fund" />
                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-12">
                <h3>Assign teams for this fund.</h3>
            </div>
            <div class="col-span-12 flex gap-2">
                <JetLabel for="select_all" value="Select All" />
                <JetCheckbox id="select_all" v-model:checked="select_all" />
            </div>
            <div
                class="col-span-6 sm:col-span-4 flex gap-2"
                v-for="team in allTeams"
                :key="team.id">
                <JetLabel :for="`team_${team.id}`" :value="team.name" />
                <JetCheckbox
                    id="`team_${team.id}`"
                    v-model:checked="form.teams[team.id]"
                    name="teams[]" />
            </div>
            <div class="col-span-12">
                <JetInputError :message="form.errors.teams" />
            </div>
        </template>

        <template #actions>
            <JetButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Update
            </JetButton>
        </template>
    </JetFormSection>
</template>
