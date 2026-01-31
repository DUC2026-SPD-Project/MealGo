<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ attendances: Array });

const form = useForm({});

const toggleClock = () => {
    form.post(route('attendance.store'));
};
</script>

<template>
    <AdminLayout>
        <div class="d-flex justify-space-between align-center mb-6">
            <h1 class="text-h4 font-weight-bold text-white">Staff Attendance</h1>
            
            <v-btn 
                color="primary" 
                size="x-large" 
                prepend-icon="mdi-clock-outline" 
                @click="toggleClock"
                :loading="form.processing"
            >
                Clock In / Out
            </v-btn>
        </div>

        <v-card elevation="10" class="rounded-lg" color="surface">
            <v-table theme="dark">
                <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Employee</th>
                        <th class="text-left">Clock In</th>
                        <th class="text-left">Clock Out</th>
                        <th class="text-left">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in attendances" :key="item.id">
                        <td>{{ item.date }}</td>
                        <td class="font-weight-bold">{{ item.user.name }}</td>
                        <td class="text-success">{{ item.clock_in }}</td>
                        <td class="text-warning">{{ item.clock_out || 'Working...' }}</td>
                        <td>
                            <v-chip size="small" :color="item.clock_out ? 'success' : 'info'">
                                {{ item.clock_out ? 'Completed' : 'Active' }}
                            </v-chip>
                        </td>
                    </tr>
                    <tr v-if="attendances.length === 0">
                        <td colspan="5" class="text-center text-grey py-4">No attendance records found.</td>
                    </tr>
                </tbody>
            </v-table>
        </v-card>
    </AdminLayout>
</template>