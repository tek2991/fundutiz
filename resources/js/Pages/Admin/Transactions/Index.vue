<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ButtonLink from "@/Jetstream/ButtonLink.vue";
import SimpleLink from "@/Jetstream/SimpleLink.vue";
import Pagination from "@/Jetstream/Pagination.vue";
import SuccessBadge from "@/Icons/SuccessBadge.vue";
import Cart from "@/Icons/Cart.vue";
import UpTrend from "@/Icons/UpTrend.vue";

defineProps({
    transactions: Object,
});
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

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex p-4">
            <ButtonLink :href="route('admin.transaction.download-report')"
                >Download</ButtonLink
            >
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
                                                        class="truncate px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider text-right">
                                                        Amount
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="truncate px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">
                                                        Dated
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
