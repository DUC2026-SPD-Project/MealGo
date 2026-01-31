<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    sales: Array,
    totalRevenue: Number,
    totalTransactions: Number,
    filters: Object
});

// State for Date Filters
const startDate = ref(props.filters.start_date);
const endDate = ref(props.filters.end_date);

// Filter Button Action
const applyFilter = () => {
    router.get(route('reports.index'), { 
        start_date: startDate.value, 
        end_date: endDate.value 
    }, { 
        preserveState: true,
        preserveScroll: true 
    });
};
</script>

<template>
    <AdminLayout>
        <h1 class="text-h4 font-weight-bold text-white mb-6">Sales Report</h1>

        <v-card class="mb-6 pa-4" color="surface" elevation="4">
            <div class="d-flex align-center flex-wrap gap-4">
                <v-text-field 
                    type="date" 
                    label="Start Date" 
                    v-model="startDate" 
                    variant="outlined" 
                    hide-details
                    style="max-width: 200px;"
                ></v-text-field>
                
                <v-text-field 
                    type="date" 
                    label="End Date" 
                    v-model="endDate" 
                    variant="outlined" 
                    hide-details
                    style="max-width: 200px;"
                    class="mx-4"
                ></v-text-field>

                <v-btn color="primary" size="large" prepend-icon="mdi-filter" @click="applyFilter">
                    Filter Data
                </v-btn>
            </div>
        </v-card>

        <v-row class="mb-6">
            <v-col cols="12" md="6">
                <v-card color="success" class="pa-4" elevation="6">
                    <div class="text-subtitle-1">Total Revenue</div>
                    <div class="text-h3 font-weight-bold">${{ totalRevenue.toFixed(2) }}</div>
                </v-card>
            </v-col>
            <v-col cols="12" md="6">
                <v-card color="info" class="pa-4" elevation="6">
                    <div class="text-subtitle-1">Total Transactions</div>
                    <div class="text-h3 font-weight-bold">{{ totalTransactions }}</div>
                </v-card>
            </v-col>
        </v-row>

        <v-card elevation="10" color="surface">
            <v-card-title>Transaction History</v-card-title>
            <v-table theme="dark">
                <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Cashier</th>
                        <th class="text-left">Payment</th>
                        <th class="text-right">Total ($)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="sale in sales" :key="sale.id">
                        <td>{{ new Date(sale.created_at).toLocaleString() }}</td>
                        <td>{{ sale.user ? sale.user.name : 'Unknown' }}</td>
                        <td>
                            <v-chip size="small" color="primary" class="text-uppercase">{{ sale.payment_method }}</v-chip>
                        </td>
                        <td class="text-right font-weight-bold text-success">
                            ${{ parseFloat(sale.total_price).toFixed(2) }}
                        </td>
                    </tr>
                    <tr v-if="sales.length === 0">
                        <td colspan="4" class="text-center text-grey py-4">No sales found for this date.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>

    </AdminLayout>
</template>