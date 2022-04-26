<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { watch, computed } from "vue";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetTextarea from "@/Jetstream/Textarea.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import Select from "@/Jetstream/Select.vue";

const props = defineProps({
    transaction: Object,
    funds: Object,
    sanctioners: Object,
});

const form = useForm({
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
    form.put(route("admin.transaction.update", props.transaction.id), {
        errorBag: "updateAllocationTransaction",
    });
};

</script>

<template>
    <JetFormSection @submitted="submit">
        <template #title> Budget Allocation Entry (FY: {{ $page.props.current_financial_year ? $page.props.current_financial_year.name : 'N/A' }}) </template>

        <template #description>
            Create a new transaction for recording a budget allocation.
        </template>

        <template #form>
            <h3
                class="col-span-6 sm:col-span-4 text-lg font-medium text-gray-900">
                File Details
            </h3>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="fund_id" value="Head Of Account" />
                <Select v-model="form.fund_id" id="fund_id" required>
                    <option value="" disabled>Select</option>
                    <option
                        :value="fund.id"
                        v-for="fund in funds"
                        :key="fund.id">
                        {{ fund.name }}
                    </option>
                </Select>
                <JetInputError :message="form.errors.fund_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="file_number" value="File Number" />
                <JetInput
                    id="file_number"
                    v-model="form.file_number"
                    type="text"
                    class="block w-full mt-1"
                    required />
                <JetInputError
                    :message="form.errors.file_number"
                    class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="sanctioned_at" value="Dated" />
                <JetInput
                    id="sanctioned_at"
                    v-model="form.sanctioned_at"
                    type="date"
                    class="block w-full mt-1"
                    required />
                <JetInputError
                    :message="form.errors.sanctioned_at"
                    class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="amount" value="Amount" />
                <JetInput
                    id="amount"
                    v-model="form.amount"
                    type="number"
                    step="0.01"
                    class="block w-full mt-1"
                    required />
                <JetInputError :message="form.errors.amount" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <JetButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing">
                Submit
            </JetButton>
        </template>
    </JetFormSection>
</template>
