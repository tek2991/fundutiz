<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";

const form = useForm({
    name: "",
    active: false,
});

const createTeam = () => {
    form.post(route("admin.financial_year.store"), {
        errorBag: "createFinancialYear",
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="createTeam">
        <template #title> Financial Year Details </template>

        <template #description>
            Create a new Financial Year. If set as active it will be the default
            financial year for the company.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Financial Year" />
                <JetInput
                    id="name"
                    v-model="form.name"
                    type="text"
                    class="block w-full mt-1"
                    autofocus />
                <JetInputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="name" value="Set as active (All transancations will be created in this financial year.)" />
                <JetCheckbox
                    id="active"
                    v-model:checked="form.active"
                    name="active" />
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
