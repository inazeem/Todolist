<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Link, Head,useForm,usePage} from '@inertiajs/vue3';
import { defineProps, onMounted,reactive ,ref} from 'vue';


const props = defineProps({
    todos: {
        type: Object,
        default: () => ({}),
    },
    can: {
        type: Object,
        default: () => ({}),
    },
});

let todo_id = '';
let show_upt_btn = false;

const form = useForm({
    task: ''
});

const submit = () => {
    form.post(route('todos.store'));
};

const updateStatus = (todo) => {
    form.put('/app/todos/'+todo.id+'/update');
}

const deleteTodo = (todo) => {
    form.delete('/app/todos/'+todo.id);
}

const editTask = (todo) => {
    todo_id=todo.id;
    form.task = todo.task;
    show_upt_btn = true;
}

const updateTask = () => {

    console.log(todo_id);
    form.put('/app/todos/'+todo_id+'/updatetask');
    form.task = '';
    show_upt_btn = false;
}


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todo
            </h2>
        </template>

         <!-- component -->
        <div class="h-100 w-full flex items-center justify-center bg-teal-lightest font-sans">
            <div class="bg-white rounded shadow p-6 m-4 w-full lg:w-3/4 lg:max-w-lg">
                <div class="mb-4">
                    <h1 class="text-grey-darkest">Todo List</h1>
                    <div class="flex mt-4">

                        <input class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker" placeholder="Add Todo" v-model="form.task">

                        <button v-if="!show_upt_btn" class="flex-no-shrink p-2 border-2 rounded-lg text-teal border-teal text-white bg-blue-500 hover:bg-blue-700" @click="submit">Add</button>
                        <button v-if="show_upt_btn" class="flex-no-shrink p-2 border-2 rounded-lg text-teal border-teal text-white bg-blue-500 hover:bg-blue-700" @click="updateTask()">Update</button>

                    </div>
                </div>
                <div>
                    <div class="flex mb-4 items-center" v-for="todo in todos" :key="todo.id">
                        <p class="w-full text-grey-darkest">{{ todo.task }}</p>
                        <button v-if="can.edit" class="flex-no-shrink p-2 ml-2 mr-1 border-2 rounded-lg border-green text-white bg-purple-500 hover:bg-purple-700" @click="editTask(todo)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z" />
                                <path d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z" />
                            </svg>
                        </button>

                        <button v-if="todo.is_done" class="flex-no-shrink p-2 ml-2 mr-1 border-2 rounded-lg border-green text-white bg-green-500 hover:bg-green-700 " @click="updateStatus(todo)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M3 3.5A1.5 1.5 0 0 1 4.5 2h6.879a1.5 1.5 0 0 1 1.06.44l4.122 4.12A1.5 1.5 0 0 1 17 7.622V16.5a1.5 1.5 0 0 1-1.5 1.5h-11A1.5 1.5 0 0 1 3 16.5v-13Zm10.857 5.691a.75.75 0 0 0-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 0 0-1.06 1.061l2.5 2.5a.75.75 0 0 0 1.137-.089l4-5.5Z" clip-rule="evenodd" />
                            </svg>

                        </button>

                        <button v-else class="flex-no-shrink p-2 ml-2 mr-1 border-2 rounded-lg border-green text-white bg-gray-500 hover:bg-gray-700" @click="updateStatus(todo)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM6.75 9.25a.75.75 0 0 0 0 1.5h6.5a.75.75 0 0 0 0-1.5h-6.5Z" clip-rule="evenodd" />
                            </svg>


                        </button>

                        <button class="flex-no-shrink p-2 ml-1 border-2 rounded-lg text-red border-red text-white bg-red-500 hover:bg-red-700"  @click="deleteTodo(todo)">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                                <path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd" />
                            </svg>

                        </button>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
