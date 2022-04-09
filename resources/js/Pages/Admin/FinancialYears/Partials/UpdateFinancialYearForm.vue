<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import WarningBadge from "@/Icons/WarningBadge.vue";

const props = defineProps({
    currentFinancialYear: Object,
    financialYear: Object,
});

const form = useForm({
    name: props.financialYear.name,
    is_active: props.financialYear.is_active,
});

const createTeam = () => {
    form.put(route("admin.financial_year.update", props.financialYear.id), {
        errorBag: "updateFinancialYear",
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="createTeam">
        <template #title> Update Financial Year Details </template>

        <template #description>
            If set as active it will be the default financial year for the
            company.
        </template>

        <template #form>
            <div class="col-span-6">
                <JetLabel value="Current Financial Year" />

                <div class="flex items-center mt-2">
                    <div class="ml-4 leading-tight" v-if="currentFinancialYear">
                        <div>{{ currentFinancialYear.name }}</div>
                        <div class="text-sm text-gray-700">
                            {{ currentFinancialYear.created_at }}
                        </div>
                    </div>
                    <div class="leading-tight" v-else>
                        <div> <WarningBadge /> Not Found!</div>
                    </div>
                </div>
            </div>
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
                <JetLabel
                    for="name"
                    value="Set as active (All transancations will be created in this financial year.)" />
                <JetCheckbox
                    id="is_active"
                    v-model:checked="form.is_active"
                    name="is_active" />
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
