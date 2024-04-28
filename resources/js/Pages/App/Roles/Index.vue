<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, Head,router, usePage,useForm} from '@inertiajs/vue3';
import { ref} from "vue";
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Checkbox from '@/Components/Checkbox.vue';

//Props & Emit
const props = defineProps({
    roles:{
        type:Object,
        default:({}),
    },
    permissions: {
        type:Object,
        default:({}),
    }

});

let role1 = ref('');

const assigningPermissions = ref(false);

const roles = ref({
    data: props.roles,
});

const form = useForm({
    role : role1.id,
    permission1: [],
});

const assignPermissions = (role) => {
    assigningPermissions.value =true;
    role1 = ref(role);
    form.role = role.id,
    console.log(role.name);

}

const closeModal = () => {
    assigningPermissions.value = false;
    form.reset();
};

const assignPermissionRole = () => {

    form.post(route('role.updatepermissions'), {
        form,
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
}



</script>



<template>
    <Head title="Roles" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class=" font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight px-4 py-2 ">Roles</h2>
            <div class=" inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ml-4 ">
                <Link :href="route('role.create')"  >
                    Create Role
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
                    <table class="w-full">
                        <thead class="bg-gray-100 border-b">
                        <tr class="text-left">
                            <th class="text-left font-medium text-gray-900 px-6 py-4">
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
                            <tr v-for="role of roles.data" :key="role.id">
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 ">
                                {{ role.id }}
                                </td>
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 ">
                                    {{ role.name }}
                                </td>
                                <td class="px-6 py-4 max-w-[40px] text-sm font-medium text-gray-900 ">
                                    <button  @click="assignPermissions(role)" class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" fdprocessedid="nwhhb">Permissions</button> &nbsp;
                                    <Modal :show="assigningPermissions" @close="closeModal">
                                        <div class="p-6">

                                            <div class="mt-3 w-1/4 ">
                                                <div v-for="rpermission of role1.permissions" :key="rpermission.id"  class="flex items-center mt-2">
                                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{rpermission.name}}</span>
                                                </div>
                                            </div>

                                            <div class="mt-3 w-1/4 ">
                                                <label v-for="permission of permissions" :key="permission.id"  class="flex items-center mt-2">
                                                    <Checkbox name="permission1" :id="permission.name " v-model:checked="form.permission1" :value="permission.name" />
                                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{permission.name}}</span>
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
                                                    Update Permissions
                                                </SecondaryButton>
                                            </div>
                                        </div>
                                    </Modal>
                                    <Link :href="'/app/role/'+role.id+'/edit'" class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Edit </Link>&nbsp;
                                    <Link :href="'/app/role/'+role.id+'/delete'" class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">Delete </Link>

                                    <!-- <button class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" fdprocessedid="nwhhb">Assign Permissions</button> &nbsp;
                                    <button class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" fdprocessedid="nwhhb">Edit</button> &nbsp;
                                    <button class="inline-flex items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150" fdprocessedid="o2py5y">Delete</button> -->
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
