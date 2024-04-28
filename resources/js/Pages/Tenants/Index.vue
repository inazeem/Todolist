
<script setup>
// Imports

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {router, useForm,Head, usePage} from "@inertiajs/vue3";
import {Link} from '@inertiajs/vue3'
import {computed, onMounted, onUpdated, ref} from "vue";


// Uses
const page = usePage();

// Refs
const allSelected = ref(false);
const onlyFavourites = ref(false);
const selected = ref({});
const loadMoreIntersect = ref(null)
let search = ref('');

// Props & Emit
const props = defineProps({
    tenants: Object,
})

const tenants = ref({
    data: props.tenants,
})
let params = null;



</script>
<template>
    <Head title="Tenants" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class=" font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight px-4 py-2 ">Tenants</h2>
            <div class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4 ">
                <Link :href="route('tenant.create')"  >
                    Create Tenant
                </Link>
            </div>

        </template>



        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Name
                            </th>
                            <th  class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Domains
                            </th>

                            <th class="text-sm font-medium text-gray-900 px-6 py-4 text-left">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="tenant of tenants.data" :key="tenant.id">
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 text-yellow-500">
                                {{ tenant.id }}
                                </td>
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 text-yellow-500">
                                    <div v-for="domain of tenant.domains">{{ domain.domain }}</div>
                                </td>
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 text-yellow-500">
                                    <button class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" fdprocessedid="nwhhb">Edit</button> &nbsp;
                                    <button class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" fdprocessedid="o2py5y">Delete</button>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


