<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ categories: Array });
const dialog = ref(false);
const isEditing = ref(false);

const form = useForm({
    id: null,
    name: ''
});

const openCreate = () => {
    form.reset();
    isEditing.value = false;
    dialog.value = true;
};

const openEdit = (item) => {
    form.id = item.id;
    form.name = item.name;
    isEditing.value = true;
    dialog.value = true;
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('categories.update', form.id), {
            onSuccess: () => dialog.value = false
        });
    } else {
        form.post(route('categories.store'), {
            onSuccess: () => dialog.value = false
        });
    }
};

const deleteCategory = (id) => {
    if(confirm('Delete this category?')) {
        form.delete(route('categories.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="d-flex justify-space-between align-center mb-6">
            <h1 class="text-h4 font-weight-bold text-white">Category Management</h1>
            <v-btn color="primary" prepend-icon="mdi-shape" @click="openCreate">
                Add Category
            </v-btn>
        </div>

        <v-card elevation="10" class="rounded-lg" color="surface">
            <v-table theme="dark">
                <thead>
                    <tr>
                        <th class="text-left">Category Name</th>
                        <th class="text-left">Created At</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in categories" :key="item.id">
                        <td class="font-weight-bold">{{ item.name }}</td>
                        <td>{{ new Date(item.created_at).toLocaleDateString() }}</td>
                        <td class="text-right">
                            <v-btn icon="mdi-pencil" color="info" variant="text" @click="openEdit(item)"></v-btn>
                            <v-btn icon="mdi-delete" color="error" variant="text" @click="deleteCategory(item.id)"></v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <v-dialog v-model="dialog" max-width="400px">
            <v-card theme="dark">
                <v-card-title class="bg-primary pa-4">
                    {{ isEditing ? 'Edit Category' : 'New Category' }}
                </v-card-title>
                <v-card-text class="pa-4">
                    <v-form @submit.prevent="submit">
                        <v-text-field 
                            v-model="form.name" 
                            label="Category Name" 
                            variant="outlined" 
                            autofocus
                        ></v-text-field>
                        
                        <v-btn block color="success" size="large" type="submit" :loading="form.processing" class="mt-2">
                            Save
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

    </AdminLayout>
</template>