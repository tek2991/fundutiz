<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
// import JetCheckbox from "@/Jetstream/Checkbox.vue";
import WarningBadge from "@/Icons/WarningBadge.vue";

const props = defineProps({
    fund: Object,
});

const form = useForm({
    name: props.fund.name,
});

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
            <!-- <div class="col-span-6 sm:col-span-4">
                <JetLabel
                    for="name"
                    value="Set as active (All transancations will be created in this financial year.)" />
                <JetCheckbox
                    id="is_active"
                    v-model:checked="form.is_active"
                    name="is_active" />
            </div> -->
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
