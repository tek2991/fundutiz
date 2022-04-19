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
    funds: Object,
    sanctioners: Object,
});

const form = useForm({
    fund_id: "",
    type: "utilization",
    status: "incured",
    sanctioned_at: "",
    amount: "",
    item: "",
    vendor_name: "",
    file_number: "",
    is_gem: "1",
    non_gem_remark: "",
    gem_non_availability: "",
    gem_non_availability_remark: "",
    sanctioner_id: "",
});

const submit = () => {
    form.post(route("admin.transaction.store"), {
        errorBag: "createUtilizationTransaction",
    });
};

const isGEM = computed(() => form.is_gem === "1");
const isNotAvailableInGEM = computed(() => form.gem_non_availability === "1");
const isOtherReason = computed(() => form.gem_non_availability === "0");

watch(isGEM, (value) => {
    if (value === true) {
        form.non_gem_remark = "";
        form.gem_non_availability = "";
        form.gem_non_availability_remark = "";
    }
});

watch(isNotAvailableInGEM, (value) => {
    value === true
        ? (form.gem_non_availability_remark = "")
        : (form.non_gem_remark = "");
});
</script>

<template>
    <JetFormSection @submitted="submit">
        <template #title> Budget Utilization Entry (FY: {{ $page.props.current_financial_year ? $page.props.current_financial_year.name : 'N/A' }}) </template>

        <template #description>
            Create a new transaction for recording a budget utilization.
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
                <JetLabel for="sanctioned_at" value="Sanctioned At" />
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
                <JetLabel for="amount" value="Sanctioned Amount" />
                <JetInput
                    id="amount"
                    v-model="form.amount"
                    type="number"
                    step="0.01"
                    class="block w-full mt-1"
                    required />
                <JetInputError :message="form.errors.amount" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="status" value="Utilization Status" />
                <Select
                    v-model="form.status"
                    id="status"
                    required>
                    <option value="incured">Incured</option>
                    <option value="proposed">Proposed</option>
                </Select>
                <JetInputError :message="form.errors.status" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="sanctioner_id" value="Sanctioning Authority" />
                <Select
                    v-model="form.sanctioner_id"
                    id="sanctioner_id"
                    required>
                    <option value="" disabled>Select</option>
                    <option
                        :value="sanctioner.id"
                        v-for="sanctioner in sanctioners"
                        :key="sanctioner.id">
                        {{ sanctioner.name }}
                    </option>
                </Select>
                <JetInputError
                    :message="form.errors.sanctioner_id"
                    class="mt-2" />
            </div>

            <h3
                class="mt-6 col-span-6 sm:col-span-4 text-lg font-medium text-gray-900">
                Item & Vendor Details
            </h3>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel
                    for="item_with_description"
                    value="Item With Description" />
                <JetTextarea
                    id="item_with_description"
                    v-model="form.item"
                    class="block w-full mt-1"
                    rows="4"
                    required>
                </JetTextarea>
                <JetInputError :message="form.errors.item" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="vendor_name" value="Vendor Name" />
                <JetInput
                    id="vendor_name"
                    v-model="form.vendor_name"
                    type="text"
                    class="block w-full mt-1"
                    required />
                <JetInputError
                    :message="form.errors.vendor_name"
                    class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="is_gem" value="Purchased From GEM ?" />
                <Select v-model="form.is_gem" id="is_gem">
                    <option value="1" :selected="form.is_gem == '1'">
                        Yes
                    </option>
                    <option value="0" :selected="form.is_gem == '0'">
                        No
                    </option>
                </Select>
                <JetInputError :message="form.errors.is_gem" class="mt-2" />
            </div>
            <div v-if="!isGEM" class="col-span-6 sm:col-span-4">
                <JetLabel
                    for="gem_non_availability"
                    value="Reason For Local Purchase" />
                <Select
                    v-model="form.gem_non_availability"
                    id="gem_non_availability">
                    <option value="" selected disabled>Select</option>
                    <option
                        value="1"
                        :selected="form.gem_non_availability == '1'">
                        Non Availability
                    </option>
                    <option
                        value="0"
                        :selected="form.gem_non_availability == '0'">
                        Other
                    </option>
                </Select>
                <JetInputError
                    :message="form.errors.gem_non_availability"
                    class="mt-2" />
            </div>
            <div v-if="isNotAvailableInGEM" class="col-span-6 sm:col-span-4">
                <JetLabel
                    for="gem_non_availability_remark"
                    value="GEM Non Availability Report" />
                <JetInput
                    id="gem_non_availability_remark"
                    v-model="form.gem_non_availability_remark"
                    type="text"
                    class="block w-full mt-1" />
                <JetInputError
                    :message="form.errors.gem_non_availability_remark"
                    class="mt-2" />
            </div>
            <div v-if="isOtherReason" class="col-span-6 sm:col-span-4">
                <JetLabel for="non_gem_remark" value="Reason.." />
                <JetInput
                    id="non_gem_remark"
                    v-model="form.non_gem_remark"
                    type="text"
                    class="block w-full mt-1" />
                <JetInputError
                    :message="form.errors.non_gem_remark"
                    class="mt-2" />
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
