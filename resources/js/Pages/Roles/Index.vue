<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ 
    roles: Array,
    permissions: Array 
});

const dialog = ref(false);
const isEditing = ref(false);

const form = useForm({
    id: null,
    name: '',
    permissions: [] // Array of permission names
});

const openCreate = () => {
    form.reset();
    isEditing.value = false;
    dialog.value = true;
};

const openEdit = (role) => {
    form.id = role.id;
    form.name = role.name;
    // Extract permission names from the role object
    form.permissions = role.permissions.map(p => p.name);
    isEditing.value = true;
    dialog.value = true;
};

const submit = () => {
    if (isEditing.value) {
        form.put(route('roles.update', form.id), {
            onSuccess: () => dialog.value = false
        });
    } else {
        form.post(route('roles.store'), {
            onSuccess: () => dialog.value = false
        });
    }
};

const deleteRole = (id) => {
    if(confirm('Delete this role?')) {
        form.delete(route('roles.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="d-flex justify-space-between align-center mb-6">
            <h1 class="text-h4 font-weight-bold text-white">Position (Roles)</h1>
            <v-btn color="primary" prepend-icon="mdi-shield-account" @click="openCreate">
                Add Position
            </v-btn>
        </div>

        <v-card elevation="10" class="rounded-lg" color="surface">
            <v-table theme="dark">
                <thead>
                    <tr>
                        <th class="text-left">Position Name</th>
                        <th class="text-left">Permissions</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="role in roles" :key="role.id">
                        <td class="font-weight-bold text-uppercase">{{ role.name }}</td>
                        <td>
                            <v-chip-group>
                                <v-chip v-for="perm in role.permissions" :key="perm.id" size="x-small" color="info">
                                    {{ perm.name }}
                                </v-chip>
                            </v-chip-group>
                        </td>
                        <td class="text-right">
                            <v-btn icon="mdi-pencil" color="info" variant="text" @click="openEdit(role)"></v-btn>
                            <v-btn icon="mdi-delete" color="error" variant="text" @click="deleteRole(role.id)"></v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <v-dialog v-model="dialog" max-width="600px">
            <v-card theme="dark">
                <v-card-title class="bg-primary pa-4">
                    {{ isEditing ? 'Edit Position' : 'New Position' }}
                </v-card-title>
                <v-card-text class="pa-4">
                    <v-form @submit.prevent="submit">
                        <v-text-field 
                            v-model="form.name" 
                            label="Position Name (e.g. Manager)" 
                            variant="outlined"
                        ></v-text-field>

                        <div class="text-subtitle-1 mb-2 font-weight-bold">Permissions Access</div>
                        <v-divider class="mb-3"></v-divider>

                        <v-row dense>
                            <v-col v-for="perm in permissions" :key="perm.id" cols="6">
                                <v-checkbox 
                                    v-model="form.permissions" 
                                    :label="perm.name" 
                                    :value="perm.name"
                                    density="compact"
                                    hide-details
                                ></v-checkbox>
                            </v-col>
                        </v-row>
                        
                        <v-btn block color="success" size="large" type="submit" :loading="form.processing" class="mt-4">
                            Save Position
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

    </AdminLayout>
</template>