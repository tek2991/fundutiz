<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import ButtonLink from "@/Jetstream/ButtonLink.vue";
import SimpleLink from "@/Jetstream/SimpleLink.vue";
import Pagination from "@/Jetstream/Pagination.vue";
import SuccessBadge from "@/Icons/SuccessBadge.vue";

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
                <ButtonLink :href="route('admin.transaction.create')">Create</ButtonLink>
            </span>
        </template>

        <div class="pt-12 sm:py-12">
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
                                                        Type
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="truncate px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                                        Created at
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
                                                        <SuccessBadge v-if="item.is_active == true" />
                                                        {{ item.type }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        {{ item.created_at }}
                                                    </td>
                                                    <td
                                                        class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <SimpleLink :href="route('admin.transaction.edit', item.id)">
                                                            Edit
                                                        </SimpleLink>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div v-if="transactions.meta.last_page > 1" class="py-6 px-6">
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
