<script setup>
import { useForm } from "@inertiajs/inertia-vue3";
import { computed } from "vue";

import AppLayout from "@/Layouts/AppLayout.vue";
import ButtonLink from "@/Jetstream/ButtonLink.vue";
import DownloadButton from "@/Jetstream/DownloadButton.vue";
import SimpleLink from "@/Jetstream/SimpleLink.vue";
import Pagination from "@/Jetstream/Pagination.vue";
import SuccessBadge from "@/Icons/SuccessBadge.vue";
import Cart from "@/Icons/Cart.vue";
import UpTrend from "@/Icons/UpTrend.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import JetLabel from "@/Jetstream/Label.vue";
import Select from "@/Jetstream/Select.vue";

const props = defineProps({
    transactions: Object,
    users: Object,
    funds: Object,
    financialYears: Object,
    current_financial_year: Object,
    request: Object,
});

const sortables = [
    { key: "sanctioned_at", label: "Sanctioned At" },
    { key: "amount", label: "Amount" },
    { key: "fund.name", label: "Head Of Account" },
    { key: "user", label: "User" },
];
const sort_directions = ["asc", "desc"];

const form = useForm({
    financial_year_id: props.current_financial_year.id,
    fund_id: props.request.fund_id ?? "",
    user_id: props.request.user_id ?? "",
    sort_by: props.request.sort_by ?? "sanctioned_at",
    sort_direction: props.request.sort_direction ?? "desc",
});

const submit = () => {
    form.get(route("admin.transaction.index"), {
        errorBag: "indexTransactions",
    });
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <span class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Transactions
                </h2>
                <ButtonLink :href="route('admin.transaction.create')"
                    >Create</ButtonLink
                >
            </span>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex p-4 gap-4">
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="financial_year_id" value="Financial Year" />
                <Select
                    v-model="form.financial_year_id"
                    id="financial_year_id"
                    required>
                    <option value="">All</option>
                    <option
                        :value="financial_year.id"
                        v-for="financial_year in financialYears"
                        :key="financial_year.id">
                        {{ financial_year.name }}
                    </option>
                </Select>
                <JetInputError
                    :message="form.errors.financial_year_id"
                    class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="fund_id" value="Head Of Account" />
                <Select v-model="form.fund_id" id="fund_id" required>
                    <option value="">All</option>
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
                <JetLabel for="user_id" value="User" />
                <Select v-model="form.user_id" id="user_id" required>
                    <option value="">All</option>
                    <option
                        :value="user.id"
                        v-for="user in users"
                        :key="user.id">
                        {{ user.name }}
                    </option>
                </Select>
                <JetInputError :message="form.errors.user_id" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="sort_by" value="Sort By" />
                <Select v-model="form.sort_by" id="sort_by" required>
                    <option value="" disabled>Select</option>
                    <option
                        :value="sortable.key"
                        v-for="sortable in sortables"
                        :key="sortable.key">
                        {{ sortable.label }}
                    </option>
                </Select>
                <JetInputError :message="form.errors.sort_by" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <JetLabel for="sort_direction" value="Sort Direction" />
                <Select
                    v-model="form.sort_direction"
                    id="sort_direction"
                    required>
                    <option value="" disabled>Select</option>
                    <option
                        :value="sort_direction"
                        v-for="sort_direction in sort_directions"
                        :key="sort_direction">
                        {{ sort_direction }}
                    </option>
                </Select>
                <JetInputError
                    :message="form.errors.sort_direction"
                    class="mt-2" />
            </div>
            <ButtonLink href="#" class="h-10 mt-5" @click.prevent="submit">
                Submit
            </ButtonLink>
            <DownloadButton :href="route('admin.transaction.download-report')" class="h-10 mt-5">
                Download All
            </DownloadButton>
        </div>

        <div class="">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="">
                        <div class="flex flex-col">
                            <div
                                class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div
                                    class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div
                                        class="shadow overflow-x-auto border-b border-gray-200 sm:rounded-lg">
                                        <table
                                            class="min-w-full divide-y divide-gray-200 table-auto border-b">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th
                                                        scope="col"
                                                        class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                        Team/Office
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="truncate px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                        H.O.A
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="truncate px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                                        Amount
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="truncate px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                                        Sanction Date
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="truncate px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                        User
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="relative px-6 py-3">
                                                        <span class="sr-only">
                                                            Edit
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white divide-y divide-gray-200">
                                                <tr
                                                    v-for="item in transactions.data"
                                                    :key="item.id"
                                                    class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100">
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <SuccessBadge
                                                            v-if="
                                                                item.is_active ==
                                                                true
                                                            " />
                                                        {{ item.team.name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ item.fund.name }}

                                                        <Cart
                                                            v-if="
                                                                item.type ==
                                                                'utilization'
                                                            "
                                                            class="ml-2" />
                                                        <UpTrend
                                                            v-else
                                                            class="ml-2" />
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                                        ₹ {{ item.amount }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                        {{ item.sanctioned_at }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ item.user.name }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <SimpleLink
                                                            :href="
                                                                route(
                                                                    'admin.transaction.edit',
                                                                    item.id
                                                                )
                                                            ">
                                                            Edit </SimpleLink
                                                        >/
                                                        <SimpleLink
                                                            :href="
                                                                route(
                                                                    'admin.transaction.show',
                                                                    item.id
                                                                )
                                                            ">
                                                            View
                                                        </SimpleLink>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div
                                            v-if="
                                                transactions.meta.last_page > 1
                                            "
                                            class="py-6 px-6">
                                            <Pagination
                                                :pagination="transactions" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
