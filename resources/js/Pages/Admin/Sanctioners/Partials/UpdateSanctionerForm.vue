<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import JetButton from "@/Jetstream/Button.vue";
import JetFormSection from "@/Jetstream/FormSection.vue";
import JetInput from "@/Jetstream/Input.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";

const props = defineProps({
    sanctioner: Object,
});

const form = useForm({
    name: props.sanctioner.name,
});

const submit = () => {
    form.put(route("admin.sanctioner.update", props.sanctioner.id), {
        errorBag: "updateSanctioner",
        preserveScroll: true,
    });
};
</script>

<template>
    <JetFormSection @submitted="submit">
        <template #title> Update Financial Year Details </template>

        <template #description>
            If set as active it will be the default financial year for the
            company.
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
