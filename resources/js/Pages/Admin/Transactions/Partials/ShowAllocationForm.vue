<script setup>
// import { useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";
import ButtonLink from "@/Jetstream/ButtonLink.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetTextarea from "@/Jetstream/Textarea.vue";
import JetLabel from "@/Jetstream/Label.vue";
import Select from "@/Jetstream/Select.vue";

const props = defineProps({
    transaction: Object,
    funds: Object,
    sanctioners: Object,
});

const form = ref({
    fund_id: props.transaction.fund.id,
    type: props.transaction.type,
    // status: "incured",
    sanctioned_at: props.transaction.sanctioned_at,
    amount: props.transaction.amount,
    // item: "",
    // vendor_name: "",
    file_number: props.transaction.file_number,
    // is_gem: "1",
    // non_gem_remark: "",
    // gem_non_availability: "",
    // gem_non_availability_remark: "",
    // sanctioner_id: "",
});

const submit = () => {
    console.warn("Form submitted");
};
</script>

<template>
    <JetFormSection @submitted="submit">
        <template #title>
            Budget Allocation Entry (FY:
            {{
                $page.props.current_financial_year
                    ? $page.props.current_financial_year.name
                    : "N/A"
            }})
        </template>

        <template #description>
            View transaction recording a budget allocation.
        </template>

        <template #form>
            <h3
                class="col-span-6 sm:col-span-4 text-lg font-medium text-gray-900">
                File Details
            </h3>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="fund_id" value="Head Of Account" />
                <Select v-model="form.fund_id" id="fund_id" disabled>
                    <option
                        :value="fund.id"
                        v-for="fund in funds"
                        :key="fund.id">
                        {{ fund.name }}
                    </option>
                </Select>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="file_number" value="File Number" />
                <JetInput
                    id="file_number"
                    v-model="form.file_number"
                    type="text"
                    class="block w-full mt-1"
                    disabled />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="sanctioned_at" value="Dated" />
                <JetInput
                    id="sanctioned_at"
                    v-model="form.sanctioned_at"
                    type="date"
                    class="block w-full mt-1"
                    disabled />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="amount" value="Amount" />
                <JetInput
                    id="amount"
                    v-model="form.amount"
                    type="number"
                    step="0.01"
                    class="block w-full mt-1"
                    disabled />
            </div>
        </template>

        <template #actions>
            <ButtonLink :href="route('admin.transaction.edit', transaction.id)"> Edit </ButtonLink>
        </template>
    </JetFormSection>
</template>
