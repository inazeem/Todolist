<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, Head,router, usePage,useForm} from '@inertiajs/vue3';
import { ref} from "vue";
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import Checkbox from '@/Components/Checkbox.vue';


//Props & Emit
const props = defineProps({
    permissions: {
        type:Object,
        default:({}),
    },
    roles:{
        type:Object,
        default:({}),
    },
});


const permissions = ref({
    data: props.permissions,
});

const assigingRoles = ref(false);
const assignRoles = (permission) =>{
    assigingRoles.value = true;
    form.pid = permission;
}

const form = useForm({
    pid : ref(''),
    role454: [],
});

const closeModal = () => {
    assigingRoles.value = false;
    form.reset();
};

const assignPermissionRole = () => {
    form.post(route('permission.assignrole'), {
        form,
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};


</script>



<template>
    <Head title="Permissions" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class=" font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight px-4 py-2 ">Permissions</h2>
            <div class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4 ">
                <Link :href="route('permission.create')"  >
                    Create Permission
                </Link>
            </div>

        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                        <div
                        v-if="$page.props.flash.message"
                        :class="$page.props.flash.class"
                        role="alert"
                    >
                        <span class="font-medium">
                            {{$page.props.flash.message}}
                        </span>
                    </div>
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                        <tr class="text-left">
                            <th class=" text-left font-medium text-gray-900 px-6 py-4">
                                ID
                            </th>
                            <th  class="text-start text-sm font-medium text-gray-900 px-6 py-4 ">
                                Name
                            </th>

                            <th class="text-start text-sm font-medium text-gray-900 px-6 py-4 ">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>

                            <tr v-for="permission of permissions.data" :key="permission.id">
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 ">
                                {{ permission.id }}
                                </td>
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 ">
                                    {{ permission.name }}
                                </td>
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 ">
                                    <button  @click="assignRoles(permission.id)" class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" fdprocessedid="nwhhb">Assign Roles</button> &nbsp;
                                    <Modal :show="assigingRoles" @close="closeModal">
                                        <div class="p-6">
                                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                Are you sure you want to delete your account?
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                                Once your account is deleted, all of its resources and data will be permanently deleted. Please
                                                enter your password to confirm you would like to permanently delete your account.
                                            </p>

                                            <div class="mt-3 w-1/4 ">
                                                <label v-for="role of roles" :key="role.id"  class="flex items-center mt-2">
                                                    <Checkbox name="role454" :id="role.name " v-model:checked="form.role454" :value="role.id" />
                                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{role.name}}</span>
                                                </label>
                                            </div>

                                            <div class="mt-6 flex justify-end">
                                                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                                                <SecondaryButton
                                                    class="ms-3"
                                                    :class="{ 'opacity-25': form.processing }"
                                                    :disabled="form.processing"
                                                    @click="assignPermissionRole"
                                                >
                                                    Assign Roles
                                                </SecondaryButton>
                                            </div>
                                        </div>
                                    </Modal>
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
