<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps({
    pagination: Object,
});

const excluded_labels = ["&laquo; Previous", "Next &raquo;"];

let paginator = {
    data_count: props.pagination.data.length,
    has_pages: props.pagination.last_page > 1,
    on_first_page: props.pagination.current_page === 1,
    on_last_page: props.pagination.current_page === props.pagination.last_page,
    has_more_pages: props.pagination.current_page < props.pagination.last_page,
    prev_page_url: props.pagination.prev_page_url,
    next_page_url: props.pagination.next_page_url,
    showing_from: props.pagination.from,
    showing_to: props.pagination.to,
    total: props.pagination.total,
    current_page: props.pagination.current_page,
    links: props.pagination.links,
};

// If JSON wrapping disabled then Laravel returns meta object
if(props.pagination.meta){
    paginator.has_pages = props.pagination.meta.last_page > 1;
    paginator.on_first_page = props.pagination.meta.current_page === 1;
    paginator.on_last_page = props.pagination.meta.current_page === props.pagination.meta.last_page;
    paginator.has_more_pages = props.pagination.meta.current_page < props.pagination.meta.last_page;
    paginator.prev_page_url = props.pagination.meta.prev_page_url;
    paginator.next_page_url = props.pagination.meta.next_page_url;
    paginator.showing_from = props.pagination.meta.from;
    paginator.showing_to = props.pagination.meta.to;
    paginator.total = props.pagination.meta.total;
    paginator.current_page = props.pagination.meta.current_page;
    paginator.links = props.pagination.meta.links;
}

</script>

<template>
    <nav
        v-if="paginator.has_pages"
        role="navigation"
        aria-label="Pagination Navigation"
        class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            <span
                v-if="paginator.on_first_page"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                {{ "&laquo; Previous" }}
            </span>
            <Link
                v-else
                :href="paginator.prev_page_url"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                &laquo; Previous
            </Link>
            <Link
                v-if="paginator.has_more_pages"
                :href="paginator.next_page_url"
                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                Next &raquo;
            </Link>
            <span
                v-else
                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                Next &raquo;
            </span>
        </div>

        <div
            class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5">
                    Showing

                    <span v-if="paginator.showing_from">
                        <span class="font-medium">
                            {{ paginator.showing_from }}
                        </span>
                        to
                        <span class="font-medium">
                            {{ paginator.showing_to }}
                        </span>
                    </span>

                    <span v-else>
                        {{ paginator.data_count }}
                    </span>

                    of

                    <span class="font-medium">{{ paginator.total }}</span>

                    results
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-md">
                    <!-- Previous Page Link -->

                    <span
                        v-if="paginator.on_first_page"
                        aria-disabled="true"
                        aria-label="pagination.previous">
                        <span
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5"
                            aria-hidden="true">
                            <svg
                                class="w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>

                    <Link
                        v-else
                        :href="paginator.prev_page_url"
                        rel="prev"
                        class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                        aria-label="pagination.previous">
                        <svg
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </Link>

                    <!-- Array Of Links -->
                    <span v-for="link in paginator.links" :key="link.label">
                        <span
                            v-if="excluded_labels.includes(link.label) != true">
                            <span
                                v-if="link.active == true"
                                aria-current="page">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-semibold text-white bg-gray-500 border border-gray-500 cursor-default leading-5"
                                    >{{ link.label }}</span
                                >
                            </span>
                            <span
                                v-else-if="link.label == '...'"
                                aria-current="page">
                                <span
                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5"
                                    >{{ link.label }}</span
                                >
                            </span>
                            <Link
                                v-else
                                :href="link.url ? link.url : ''"
                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150"
                                :aria-label="`Go to page :page ${link.label}`">
                                {{ link.label }}
                            </Link>
                        </span>
                    </span>

                    <!-- Next Page Link -->
                    <Link
                        v-if="paginator.has_more_pages"
                        :href="paginator.next_page_url"
                        rel="next"
                        class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150"
                        aria-label="pagination.next">
                        <svg
                            class="w-5 h-5"
                            fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </Link>
                    <span
                        v-else
                        aria-disabled="true"
                        aria-label="pagination.next">
                        <span
                            class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5"
                            aria-hidden="true">
                            <svg
                                class="w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20">
                                <path
                                    fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                </span>
            </div>
        </div>
    </nav>
</template>
