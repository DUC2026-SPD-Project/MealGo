<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ customers: Array });
const dialog = ref(false);

const form = useForm({
    name: '',
    phone: '',
    address: ''
});

const submit = () => {
    form.post(route('customers.store'), {
        onSuccess: () => {
            dialog.value = false;
            form.reset();
        }
    });
};

const deleteCustomer = (id) => {
    if(confirm('Delete this member?')) {
        form.delete(route('customers.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="d-flex justify-space-between align-center mb-6">
            <h1 class="text-h4 font-weight-bold text-white">Member Management</h1>
            <v-btn color="primary" prepend-icon="mdi-account-star" @click="dialog = true">
                Add New Member
            </v-btn>
        </div>

        <v-card elevation="10" class="rounded-lg" color="surface">
            <v-table theme="dark">
                <thead>
                    <tr>
                        <th class="text-left">Name</th>
                        <th class="text-left">Phone</th>
                        <th class="text-left">Address</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in customers" :key="item.id">
                        <td class="font-weight-bold">{{ item.name }}</td>
                        <td><v-chip color="info" size="small">{{ item.phone }}</v-chip></td>
                        <td>{{ item.address || '-' }}</td>
                        <td class="text-right">
                            <v-btn icon="mdi-delete" color="error" variant="text" @click="deleteCustomer(item.id)"></v-btn>
                        </td>
                    </tr>
                    <tr v-if="customers.length === 0">
                        <td colspan="4" class="text-center text-grey py-4">No members found.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card theme="dark">
                <v-card-title class="bg-primary pa-4">New Member</v-card-title>
                <v-card-text class="pa-4">
                    <v-form @submit.prevent="submit">
                        <v-text-field v-model="form.name" label="Member Name" variant="outlined" class="mb-2"></v-text-field>
                        <v-text-field v-model="form.phone" label="Phone Number" variant="outlined" class="mb-2"></v-text-field>
                        <v-textarea v-model="form.address" label="Address (Optional)" variant="outlined" rows="2"></v-textarea>
                        
                        <v-btn block color="success" size="large" type="submit" :loading="form.processing" class="mt-2">
                            Save Member
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

    </AdminLayout>
</template>