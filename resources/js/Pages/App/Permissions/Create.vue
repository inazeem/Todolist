<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, Head,router,useForm, usePage} from '@inertiajs/vue3';
import { ref} from "vue";
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

//Props & Emit

const form = useForm({
    name: ''
});

const submit = () => {
    form.post(route('permission.store'));
};



</script>



<template>
    <Head title="Create Role" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class=" font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight px-4 py-2 ">Create Permission</h2>
            <div class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4 ">
                <Link :href="route('permissions.index')"  >
                    Permissions
                </Link>
            </div>

        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="name" value="Name" />

                            <TextInput
                                id="name"
                                type="text"
                                name="name"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                            />

                            <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                        </div>
                        <div class="flex items-center justify-end mt-4">

                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create Permission
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
