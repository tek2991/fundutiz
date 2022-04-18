<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";

const form = useForm({
    name: "",
});

const submit = () => {
    form.post(route("admin.sanctioner.store"), {
        errorBag: "createSanctioner",
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="submit">
        <template #title> Budget Allocation Entry </template>

        <template #description>
            Create a new transaction for recording a budget allocation.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Name or Designation" />
                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Create
            </JetButton>
        </template>
    </JetFormSection>
</template>
