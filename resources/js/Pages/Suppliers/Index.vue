<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ suppliers: Array });
const dialog = ref(false);
const isEditing = ref(false);

const form = useForm({
    id: null,
    name: '',
    phone: '',
    address: ''
});

const openCreate = () => {
    form.reset();
    isEditing.value = false;
    dialog.value = true;
};

const openEdit = (item) => {
    form.id = item.id;
    form.name = item.name;
    form.phone = item.phone;
    form.address = item.address;
    isEditing.value = true;
    dialog.value = true;
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('suppliers.update', form.id), {
            onSuccess: () => dialog.value = false
        });
    } else {
        form.post(route('suppliers.store'), {
            onSuccess: () => dialog.value = false
        });
    }
};

const deleteSupplier = (id) => {
    if(confirm('Delete this supplier?')) {
        form.delete(route('suppliers.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="d-flex justify-space-between align-center mb-6">
            <h1 class="text-h4 font-weight-bold text-white">Supplier Management</h1>
            <v-btn color="primary" prepend-icon="mdi-truck-delivery" @click="openCreate">
                Add Supplier
            </v-btn>
        </div>

        <v-card elevation="10" class="rounded-lg" color="surface">
            <v-table theme="dark">
                <thead>
                    <tr>
                        <th class="text-left">Company Name</th>
                        <th class="text-left">Phone</th>
                        <th class="text-left">Address</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in suppliers" :key="item.id">
                        <td class="font-weight-bold">{{ item.name }}</td>
                        <td>{{ item.phone || '-' }}</td>
                        <td>{{ item.address || '-' }}</td>
                        <td class="text-right">
                            <v-btn icon="mdi-pencil" color="info" variant="text" @click="openEdit(item)"></v-btn>
                            <v-btn icon="mdi-delete" color="error" variant="text" @click="deleteSupplier(item.id)"></v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card theme="dark">
                <v-card-title class="bg-primary pa-4">
                    {{ isEditing ? 'Edit Supplier' : 'New Supplier' }}
                </v-card-title>
                <v-card-text class="pa-4">
                    <v-form @submit.prevent="submit">
                        <v-text-field v-model="form.name" label="Supplier Name" variant="outlined" class="mb-2"></v-text-field>
                        <v-text-field v-model="form.phone" label="Phone Number" variant="outlined" class="mb-2"></v-text-field>
                        <v-textarea v-model="form.address" label="Address" variant="outlined" rows="2"></v-textarea>
                        
                        <v-btn block color="success" size="large" type="submit" :loading="form.processing" class="mt-2">
                            Save Supplier
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

    </AdminLayout>
</template>