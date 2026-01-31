<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ employees: Array });
const dialog = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('employees.store'), {
        onSuccess: () => {
            dialog.value = false;
            form.reset();
        }
    });
};

const deleteUser = (id) => {
    if(confirm('Are you sure you want to remove this employee?')) {
        form.delete(route('employees.destroy', id));
    }
}
</script>

<template>
    <AdminLayout>
        <div class="d-flex justify-space-between align-center mb-6">
            <h1 class="text-h4 font-weight-bold text-white">Employee Management</h1>
            <v-btn color="primary" prepend-icon="mdi-account-plus" @click="dialog = true">
                New Employee
            </v-btn>
        </div>

        <v-card elevation="10" class="rounded-lg" color="surface">
            <v-table theme="dark">
                <thead>
                    <tr>
                        <th class="text-left">Name</th>
                        <th class="text-left">Email</th>
                        <th class="text-left">Joined Date</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in employees" :key="user.id">
                        <td>
                            <div class="d-flex align-center">
                                <v-avatar color="primary" size="36" class="mr-3">
                                    <span class="text-white font-weight-bold">{{ user.name.charAt(0) }}</span>
                                </v-avatar>
                                {{ user.name }}
                            </div>
                        </td>
                        <td>{{ user.email }}</td>
                        <td>{{ new Date(user.created_at).toLocaleDateString() }}</td>
                        <td class="text-right">
                            <v-btn icon="mdi-delete" color="error" variant="text" @click="deleteUser(user.id)"></v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card theme="dark">
                <v-card-title class="bg-primary pa-4">Add New Employee</v-card-title>
                <v-card-text class="pa-4">
                    <v-form @submit.prevent="submit">
                        <v-text-field v-model="form.name" label="Full Name" variant="outlined" class="mb-2"></v-text-field>
                        <v-text-field v-model="form.email" label="Email Address" type="email" variant="outlined" class="mb-2"></v-text-field>
                        <v-text-field v-model="form.password" label="Password" type="password" variant="outlined" class="mb-2"></v-text-field>
                        <v-text-field v-model="form.password_confirmation" label="Confirm Password" type="password" variant="outlined" class="mb-4"></v-text-field>
                        
                        <v-btn block color="success" size="large" type="submit" :loading="form.processing">
                            Create Account
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

    </AdminLayout>
</template>