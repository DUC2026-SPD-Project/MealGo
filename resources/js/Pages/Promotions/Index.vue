<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({ promotions: Array });
const dialog = ref(false);

const form = useForm({
    name: '',
    discount_percent: 10,
    start_date: '',
    end_date: '',
    status: 'active'
});

const submit = () => {
    form.post(route('promotions.store'), {
        onSuccess: () => {
            dialog.value = false;
            form.reset();
        }
    });
};

const deletePromo = (id) => {
    if(confirm('Delete this promotion?')) {
        form.delete(route('promotions.destroy', id));
    }
};
</script>

<template>
    <AdminLayout>
        <div class="d-flex justify-space-between align-center mb-6">
            <h1 class="text-h4 font-weight-bold text-white">Promotions & Discounts</h1>
            <v-btn color="primary" prepend-icon="mdi-ticket-percent" @click="dialog = true">
                Create Promotion
            </v-btn>
        </div>

        <v-card elevation="10" class="rounded-lg" color="surface">
            <v-table theme="dark">
                <thead>
                    <tr>
                        <th class="text-left">Promo Name</th>
                        <th class="text-left">Discount</th>
                        <th class="text-left">Duration</th>
                        <th class="text-left">Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in promotions" :key="item.id">
                        <td class="font-weight-bold">{{ item.name }}</td>
                        <td class="text-error font-weight-bold">-{{ item.discount_percent }}%</td>
                        <td>{{ item.start_date }} to {{ item.end_date }}</td>
                        <td>
                            <v-chip size="small" :color="item.status === 'active' ? 'success' : 'grey'">
                                {{ item.status }}
                            </v-chip>
                        </td>
                        <td class="text-right">
                            <v-btn icon="mdi-delete" color="error" variant="text" @click="deletePromo(item.id)"></v-btn>
                        </td>
                    </tr>
                    <tr v-if="promotions.length === 0">
                        <td colspan="5" class="text-center text-grey py-4">No active promotions.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

        <v-dialog v-model="dialog" max-width="500px">
            <v-card theme="dark">
                <v-card-title class="bg-primary pa-4">New Promotion</v-card-title>
                <v-card-text class="pa-4">
                    <v-form @submit.prevent="submit">
                        <v-text-field v-model="form.name" label="Promotion Name" variant="outlined" class="mb-2"></v-text-field>
                        <v-text-field v-model="form.discount_percent" label="Discount (%)" type="number" variant="outlined" class="mb-2"></v-text-field>
                        
                        <v-row>
                            <v-col cols="6">
                                <v-text-field v-model="form.start_date" label="Start Date" type="date" variant="outlined"></v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field v-model="form.end_date" label="End Date" type="date" variant="outlined"></v-text-field>
                            </v-col>
                        </v-row>
                        
                        <v-btn block color="success" size="large" type="submit" :loading="form.processing" class="mt-2">
                            Save Promotion
                        </v-btn>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

    </AdminLayout>
</template>