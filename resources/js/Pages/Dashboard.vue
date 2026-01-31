<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed, nextTick } from 'vue';
import { Line, Doughnut, Bar, Pie } from 'vue-chartjs';
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  BarElement,
  Filler
} from 'chart.js';

// Register Chart.js components
ChartJS.register(
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend,
  ArcElement,
  BarElement,
  Filler
);

const props = defineProps({
  stats: Array,
  charts: Object,
  tables: Object,
  activities: Array,
  insights: Object
});

// Reactive state
const realTimeData = ref({});
const notifications = ref([]);
const isLoading = ref(false);
const connectionStatus = ref('connecting');
const lastUpdate = ref(null);
const showNotifications = ref(false);

// Intervals
let updateInterval = null;
let notificationInterval = null;

// Chart configurations
const salesChartData = computed(() => ({
  labels: props.charts.sales.map(item => item.date),
  datasets: [
    {
      label: 'Sales ($)',
      data: props.charts.sales.map(item => item.sales),
      borderColor: '#1976D2',
      backgroundColor: 'rgba(25, 118, 210, 0.1)',
      tension: 0.4,
      fill: true,
      pointBackgroundColor: '#1976D2',
      pointBorderColor: '#fff',
      pointBorderWidth: 2,
      pointRadius: 4
    },
    {
      label: 'Orders',
      data: props.charts.sales.map(item => item.orders),
      borderColor: '#FF9800',
      backgroundColor: 'rgba(255, 152, 0, 0.1)',
      tension: 0.4,
      fill: false,
      yAxisID: 'y1'
    }
  ]
}));

const categoryChartData = computed(() => ({
  labels: props.charts.categories.map(item => item.name),
  datasets: [{
    data: props.charts.categories.map(item => item.revenue),
    backgroundColor: [
      '#FF6384',
      '#36A2EB', 
      '#FFCE56',
      '#4BC0C0',
      '#9966FF'
    ],
    borderWidth: 0,
    hoverBorderWidth: 3,
    hoverBorderColor: '#fff'
  }]
}));

const topProductsChartData = computed(() => ({
  labels: props.charts.topProducts.map(item => item.name_en),
  datasets: [{
    label: 'Revenue ($)',
    data: props.charts.topProducts.map(item => item.revenue),
    backgroundColor: [
      'rgba(255, 99, 132, 0.8)',
      'rgba(54, 162, 235, 0.8)',
      'rgba(255, 206, 86, 0.8)',
      'rgba(75, 192, 192, 0.8)',
      'rgba(153, 102, 255, 0.8)'
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)'
    ],
    borderWidth: 2,
    borderRadius: 8
  }]
}));

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  interaction: {
    intersect: false,
    mode: 'index'
  },
  plugins: {
    legend: {
      labels: {
        color: '#fff',
        usePointStyle: true,
        padding: 20
      }
    },
    tooltip: {
      backgroundColor: 'rgba(0,0,0,0.8)',
      titleColor: '#fff',
      bodyColor: '#fff',
      borderColor: 'rgba(255,255,255,0.2)',
      borderWidth: 1
    }
  },
  scales: {
    x: {
      ticks: { color: '#fff' },
      grid: { color: 'rgba(255,255,255,0.1)' }
    },
    y: {
      ticks: { color: '#fff' },
      grid: { color: 'rgba(255,255,255,0.1)' }
    },
    y1: {
      type: 'linear',
      display: true,
      position: 'right',
      ticks: { color: '#fff' },
      grid: { drawOnChartArea: false }
    }
  }
};

const doughnutOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'bottom',
      labels: {
        color: '#fff',
        padding: 20,
        usePointStyle: true
      }
    },
    tooltip: {
      backgroundColor: 'rgba(0,0,0,0.8)',
      titleColor: '#fff',
      bodyColor: '#fff'
    }
  }
};

// Real-time functions
const fetchRealTimeData = async () => {
  try {
    isLoading.value = true;
    connectionStatus.value = 'connecting';
    
    const response = await fetch('/dashboard/realtime');
    if (!response.ok) throw new Error('Network error');
    
    const data = await response.json();
    
    // Check for changes and trigger notifications
    if (realTimeData.value.recent_sale?.id !== data.recent_sale?.id && data.recent_sale) {
      addNotification({
        type: 'success',
        title: 'New Sale! 🎉',
        message: `Order #${data.recent_sale.order_number} - $${data.recent_sale.total}`,
        icon: 'mdi-cash-register'
      });
    }
    
    if (data.low_stock_count > (realTimeData.value.low_stock_count || 0)) {
      addNotification({
        type: 'warning',
        title: 'Low Stock Alert ⚠️',
        message: `${data.low_stock_count} products need restocking`,
        icon: 'mdi-alert-circle'
      });
    }
    
    realTimeData.value = data;
    lastUpdate.value = new Date();
    connectionStatus.value = 'connected';
    
  } catch (error) {
    console.error('Real-time update failed:', error);
    connectionStatus.value = 'error';
    addNotification({
      type: 'error',
      title: 'Connection Error',
      message: 'Failed to fetch real-time data',
      icon: 'mdi-wifi-off'
    });
  } finally {
    isLoading.value = false;
  }
};

const fetchNotifications = async () => {
  try {
    const response = await fetch('/dashboard/notifications');
    if (response.ok) {
      const data = await response.json();
      // Merge with existing notifications, avoiding duplicates
      data.notifications.forEach(notification => {
        if (!notifications.value.find(n => n.id === notification.id)) {
          notifications.value.unshift(notification);
        }
      });
      // Keep only last 20 notifications
      notifications.value = notifications.value.slice(0, 20);
    }
  } catch (error) {
    console.error('Failed to fetch notifications:', error);
  }
};

const addNotification = (notification) => {
  const id = Date.now() + Math.random();
  const newNotification = {
    id,
    timestamp: new Date().toLocaleTimeString(),
    autoRemove: true,
    ...notification
  };
  
  notifications.value.unshift(newNotification);
  
  // Auto remove after 5 seconds
  setTimeout(() => {
    removeNotification(id);
  }, 5000);
};

const removeNotification = (id) => {
  const index = notifications.value.findIndex(n => n.id === id);
  if (index > -1) {
    notifications.value.splice(index, 1);
  }
};

// Utility functions
const formatCurrency = (amount) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD'
  }).format(amount || 0);
};

const formatNumber = (number) => {
  return new Intl.NumberFormat('en-US').format(number || 0);
};

const getTimeAgo = (date) => {
  const now = new Date();
  const past = new Date(date);
  const diffInMinutes = Math.floor((now - past) / (1000 * 60));
  
  if (diffInMinutes < 1) return 'Just now';
  if (diffInMinutes < 60) return `${diffInMinutes}m ago`;
  if (diffInMinutes < 1440) return `${Math.floor(diffInMinutes / 60)}h ago`;
  return `${Math.floor(diffInMinutes / 1440)}d ago`;
};

const getStatusColor = (status) => {
  const colors = {
    'completed': 'success',
    'pending': 'warning', 
    'cancelled': 'error',
    'processing': 'info'
  };
  return colors[status] || 'grey';
};

const getActivityIcon = (type) => {
  const icons = {
    'sale': 'mdi-cash-register',
    'product': 'mdi-package-variant',
    'customer': 'mdi-account-plus',
    'employee': 'mdi-account-clock'
  };
  return icons[type] || 'mdi-information';
};

// Computed properties
const connectionStatusColor = computed(() => {
  const colors = {
    'connected': 'success',
    'connecting': 'warning',
    'error': 'error'
  };
  return colors[connectionStatus.value] || 'grey';
});

const connectionStatusIcon = computed(() => {
  const icons = {
    'connected': 'mdi-wifi',
    'connecting': 'mdi-loading mdi-spin',
    'error': 'mdi-wifi-off'
  };
  return icons[connectionStatus.value] || 'mdi-help';
});

const unreadNotifications = computed(() => {
  return notifications.value.filter(n => !n.read).length;
});

// Lifecycle
onMounted(() => {
  // Initial data fetch
  fetchRealTimeData();
  fetchNotifications();
  
  // Set up intervals
  updateInterval = setInterval(fetchRealTimeData, 30000); // Every 30 seconds
  notificationInterval = setInterval(fetchNotifications, 60000); // Every minute
  
  // Welcome notification
  setTimeout(() => {
    addNotification({
      type: 'info',
      title: 'Welcome Back! 👋',
      message: 'Dashboard loaded successfully',
      icon: 'mdi-view-dashboard'
    });
  }, 1000);
});

onUnmounted(() => {
  if (updateInterval) clearInterval(updateInterval);
  if (notificationInterval) clearInterval(notificationInterval);
});
</script>

<template>
  <Head title="Super Admin Dashboard" />

  <AdminLayout>
    <!-- Header Section -->
    <div class="mb-6">
      <v-row align="center" justify="space-between">
        <v-col cols="12" md="6">
          <h1 :class="$vuetify.display.mobile ? 'text-h5' : 'text-h3'" class="font-weight-bold text-white mb-2 d-flex align-center">
            <v-icon class="mr-2" color="primary" :size="$vuetify.display.mobile ? 28 : 40">mdi-view-dashboard</v-icon>
            <span v-if="!$vuetify.display.xs">Super Admin Dashboard</span>
            <span v-else>Dashboard</span>
          </h1>
          <p class="text-grey-400" :class="$vuetify.display.mobile ? 'text-body-2' : 'text-h6'">
            Real-time business insights
          </p>
        </v-col>
        
        <v-col cols="12" md="6" class="d-flex align-center justify-end ga-2">
          <!-- Connection Status -->
          <v-chip 
            :color="connectionStatusColor" 
            variant="flat" 
            :size="$vuetify.display.mobile ? 'small' : 'default'"
          >
            <v-icon start :size="$vuetify.display.mobile ? 16 : 20">{{ connectionStatusIcon }}</v-icon>
            <span v-if="!$vuetify.display.xs">
              {{ connectionStatus === 'connected' ? 'Live' : connectionStatus === 'connecting' ? 'Updating...' : 'Offline' }}
            </span>
          </v-chip>
          
          <!-- Notifications -->
          <v-menu v-model="showNotifications" :close-on-content-click="false" location="bottom end">
            <template #activator="{ props }">
              <v-btn
                v-bind="props"
                icon
                variant="outlined"
                color="primary"
                :size="$vuetify.display.mobile ? 'small' : 'default'"
              >
                <v-badge :content="unreadNotifications" :model-value="unreadNotifications > 0" color="error">
                  <v-icon :size="$vuetify.display.mobile ? 20 : 24">mdi-bell</v-icon>
                </v-badge>
              </v-btn>
            </template>
            
            <v-card :width="$vuetify.display.mobile ? 300 : 400" max-height="500" class="notification-card">
              <v-card-title class="d-flex align-center">
                <v-icon class="mr-2">mdi-bell</v-icon>
                Notifications
                <v-spacer />
                <v-btn icon="mdi-close" variant="text" size="small" @click="showNotifications = false" />
              </v-card-title>
              
              <v-divider />
              
              <v-card-text class="pa-0" style="max-height: 400px; overflow-y: auto;">
                <v-list v-if="notifications.length > 0" class="bg-transparent">
                  <v-list-item
                    v-for="notification in notifications.slice(0, 10)"
                    :key="notification.id"
                    class="border-b"
                  >
                    <template #prepend>
                      <v-avatar :color="notification.type" :size="$vuetify.display.mobile ? 32 : 40">
                        <v-icon color="white" :size="$vuetify.display.mobile ? 16 : 20">{{ notification.icon }}</v-icon>
                      </v-avatar>
                    </template>
                    
                    <v-list-item-title class="font-weight-medium" :class="$vuetify.display.mobile ? 'text-body-2' : ''">
                      {{ notification.title }}
                    </v-list-item-title>
                    <v-list-item-subtitle :class="$vuetify.display.mobile ? 'text-caption' : ''">
                      {{ notification.message }}
                    </v-list-item-subtitle>
                    
                    <template #append>
                      <div class="text-caption text-grey-400">
                        {{ getTimeAgo(notification.time || notification.timestamp) }}
                      </div>
                    </template>
                  </v-list-item>
                </v-list>
                
                <div v-else class="pa-6 text-center text-grey-400">
                  <v-icon size="48" class="mb-2">mdi-bell-outline</v-icon>
                  <div>No notifications</div>
                </div>
              </v-card-text>
            </v-card>
          </v-menu>
          
          <!-- Refresh Button -->
          <v-btn 
            icon="mdi-refresh" 
            variant="outlined" 
            color="primary"
            :size="$vuetify.display.mobile ? 'small' : 'default'"
            @click="fetchRealTimeData"
            :loading="isLoading"
          />
        </v-col>
      </v-row>
    </div>

    <!-- Live Notifications -->
    <div class="notification-container">
      <v-slide-y-transition group>
        <v-alert
          v-for="notification in notifications.filter(n => n.autoRemove).slice(0, 3)"
          :key="notification.id"
          :type="notification.type"
          variant="tonal"
          closable
          class="mb-3 notification-alert"
          @click:close="removeNotification(notification.id)"
        >
          <template #prepend>
            <v-icon>{{ notification.icon }}</v-icon>
          </template>
          <div class="d-flex justify-space-between align-center">
            <div>
              <div class="font-weight-bold">{{ notification.title }}</div>
              <div class="text-body-2">{{ notification.message }}</div>
            </div>
            <div class="text-caption text-grey-400">
              {{ notification.timestamp }}
            </div>
          </div>
        </v-alert>
      </v-slide-y-transition>
    </div>

    <!-- Stats Cards -->
    <v-row class="mb-6">
      <v-col 
        v-for="(stat, index) in stats" 
        :key="index"
        cols="12" 
        sm="6" 
        md="4"
        lg="3"
      >
        <v-card 
          class="stat-card" 
          :color="stat.color"
          variant="flat"
          :height="$vuetify.display.mobile ? 140 : 160"
        >
          <v-card-text :class="$vuetify.display.mobile ? 'pa-3' : 'pa-4'">
            <div class="d-flex justify-space-between align-start mb-3">
              <div class="flex-grow-1">
                <div :class="$vuetify.display.mobile ? 'text-h5' : 'text-h4'" class="font-weight-bold text-white mb-1">
                  {{ stat.value }}
                </div>
                <div :class="$vuetify.display.mobile ? 'text-body-2' : 'text-body-1'" class="text-white mb-1">
                  {{ stat.title }}
                </div>
                <div class="text-caption text-grey-300">
                  {{ stat.subtitle }}
                </div>
              </div>
              <v-avatar :size="$vuetify.display.mobile ? 48 : 60" :color="stat.color" variant="tonal">
                <v-icon :size="$vuetify.display.mobile ? 24 : 30" :color="stat.color">{{ stat.icon }}</v-icon>
              </v-avatar>
            </div>
            
            <!-- Trend/Additional Info -->
            <div class="d-flex align-center justify-space-between">
              <div v-if="stat.trend !== undefined">
                <v-chip 
                  size="x-small" 
                  :color="stat.trend > 0 ? 'success' : stat.trend < 0 ? 'error' : 'grey'"
                  variant="flat"
                >
                  <v-icon start size="12">
                    {{ stat.trend > 0 ? 'mdi-trending-up' : stat.trend < 0 ? 'mdi-trending-down' : 'mdi-minus' }}
                  </v-icon>
                  {{ stat.change || (Math.abs(stat.trend) + '%') }}
                </v-chip>
              </div>
              
              <div v-if="stat.percentage !== undefined">
                <v-progress-circular
                  :model-value="stat.percentage"
                  :size="$vuetify.display.mobile ? 32 : 40"
                  width="3"
                  :color="stat.color"
                >
                  <span class="text-caption text-white">{{ stat.percentage }}%</span>
                </v-progress-circular>
              </div>
              
              <div v-if="stat.alert">
                <v-icon color="warning" :size="$vuetify.display.mobile ? 16 : 20">mdi-alert-circle</v-icon>
              </div>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Charts Section -->
    <v-row class="mb-6">
      <!-- Sales Trend Chart -->
      <v-col cols="12" lg="8">
        <v-card class="chart-card" :height="$vuetify.display.mobile ? 350 : 450">
          <v-card-title class="d-flex align-center flex-wrap">
            <v-icon class="mr-2" color="primary" :size="$vuetify.display.mobile ? 20 : 24">mdi-chart-line</v-icon>
            <span :class="$vuetify.display.mobile ? 'text-body-1' : 'text-h6'">
              Sales & Orders Trend
              <span v-if="!$vuetify.display.xs">(Last 30 Days)</span>
            </span>
            <v-spacer />
            <v-chip size="x-small" color="success" variant="flat">
              <v-icon start size="12">mdi-trending-up</v-icon>
              Live
            </v-chip>
          </v-card-title>
          <v-card-text :style="{ height: $vuetify.display.mobile ? '280px' : '380px' }">
            <Line 
              :data="salesChartData" 
              :options="chartOptions"
            />
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Category Performance -->
      <v-col cols="12" lg="4">
        <v-card class="chart-card" :height="$vuetify.display.mobile ? 350 : 450">
          <v-card-title class="d-flex align-center">
            <v-icon class="mr-2" color="warning" :size="$vuetify.display.mobile ? 20 : 24">mdi-chart-pie</v-icon>
            <span :class="$vuetify.display.mobile ? 'text-body-1' : 'text-h6'">Category Performance</span>
          </v-card-title>
          <v-card-text :style="{ height: $vuetify.display.mobile ? '280px' : '380px' }">
            <Doughnut 
              :data="categoryChartData" 
              :options="doughnutOptions"
            />
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Second Charts Row -->
    <v-row class="mb-6">
      <!-- Top Products -->
      <v-col cols="12" lg="6">
        <v-card class="chart-card" :height="$vuetify.display.mobile ? 350 : 400">
          <v-card-title class="d-flex align-center">
            <v-icon class="mr-2" color="success" :size="$vuetify.display.mobile ? 20 : 24">mdi-trophy</v-icon>
            <span :class="$vuetify.display.mobile ? 'text-body-1' : 'text-h6'">Top Products</span>
          </v-card-title>
          <v-card-text :style="{ height: $vuetify.display.mobile ? '280px' : '330px' }">
            <Bar 
              :data="topProductsChartData" 
              :options="{ ...chartOptions, indexAxis: 'y' }"
            />
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Recent Activities -->
      <v-col cols="12" lg="6">
        <v-card class="data-card" :height="$vuetify.display.mobile ? 350 : 400">
          <v-card-title class="d-flex align-center">
            <v-icon class="mr-2" color="info" :size="$vuetify.display.mobile ? 20 : 24">mdi-timeline</v-icon>
            <span :class="$vuetify.display.mobile ? 'text-body-1' : 'text-h6'">Recent Activities</span>
            <v-spacer />
            <v-chip size="x-small" color="info" variant="flat">
              {{ activities.length }}
            </v-chip>
          </v-card-title>
          <v-card-text class="pa-0" :style="{ height: $vuetify.display.mobile ? '280px' : '330px', overflowY: 'auto' }">
            <v-timeline density="compact" :class="$vuetify.display.mobile ? 'pa-2' : 'pa-4'">
              <v-timeline-item
                v-for="activity in activities"
                :key="activity.type + activity.time"
                :dot-color="activity.color"
                size="small"
              >
                <template #icon>
                  <v-icon :size="$vuetify.display.mobile ? 12 : 16">{{ getActivityIcon(activity.type) }}</v-icon>
                </template>
                
                <div class="d-flex justify-space-between align-center flex-wrap">
                  <div class="flex-grow-1">
                    <div :class="$vuetify.display.mobile ? 'text-body-2' : 'font-weight-medium'">{{ activity.title }}</div>
                    <div :class="$vuetify.display.mobile ? 'text-caption' : 'text-body-2'" class="text-grey-400">{{ activity.description }}</div>
                  </div>
                  <div class="text-caption text-grey-500">
                    {{ getTimeAgo(activity.time) }}
                  </div>
                </div>
              </v-timeline-item>
            </v-timeline>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Data Tables Row -->
    <v-row>
      <!-- Recent Sales -->
      <v-col cols="12" lg="6">
        <v-card class="data-card">
          <v-card-title class="d-flex align-center flex-wrap">
            <v-icon class="mr-2" color="success" :size="$vuetify.display.mobile ? 20 : 24">mdi-receipt</v-icon>
            <span :class="$vuetify.display.mobile ? 'text-body-1' : 'text-h6'">Recent Sales</span>
            <v-spacer />
            <v-chip size="x-small" color="success" variant="flat">
              {{ tables.recentSales.length }}
            </v-chip>
          </v-card-title>
          <v-card-text class="pa-0">
            <div :style="{ height: $vuetify.display.mobile ? '300px' : '400px', overflowX: 'auto', overflowY: 'auto' }">
              <v-table class="bg-transparent">
                <thead>
                  <tr>
                    <th class="text-white" :class="$vuetify.display.mobile ? 'text-caption' : ''">Order</th>
                    <th class="text-white" :class="$vuetify.display.mobile ? 'text-caption' : ''" v-if="!$vuetify.display.xs">Customer</th>
                    <th class="text-white" :class="$vuetify.display.mobile ? 'text-caption' : ''">Total</th>
                    <th class="text-white" :class="$vuetify.display.mobile ? 'text-caption' : ''">Status</th>
                    <th class="text-white" :class="$vuetify.display.mobile ? 'text-caption' : ''" v-if="!$vuetify.display.xs">Time</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="sale in tables.recentSales.slice(0, 8)" :key="sale.id">
                    <td :class="['font-weight-medium', $vuetify.display.mobile ? 'text-caption' : '']">#{{ sale.order_number }}</td>
                    <td :class="$vuetify.display.mobile ? 'text-caption' : ''" v-if="!$vuetify.display.xs">{{ sale.customer_name || 'Walk-in' }}</td>
                    <td :class="['text-success font-weight-bold', $vuetify.display.mobile ? 'text-caption' : '']">${{ sale.total }}</td>
                    <td>
                      <v-chip 
                        size="x-small" 
                        :color="getStatusColor(sale.status)"
                        variant="flat"
                      >
                        {{ sale.status }}
                      </v-chip>
                    </td>
                    <td :class="['text-grey-400', $vuetify.display.mobile ? 'text-caption' : '']" v-if="!$vuetify.display.xs">{{ getTimeAgo(sale.created_at) }}</td>
                  </tr>
                </tbody>
              </v-table>
            </div>
          </v-card-text>
        </v-card>
      </v-col>

      <!-- Low Stock & Attendance -->
      <v-col cols="12" lg="6">
        <v-row>
          <!-- Low Stock Alerts -->
          <v-col cols="12">
            <v-card class="data-card mb-4">
              <v-card-title class="d-flex align-center flex-wrap">
                <v-icon class="mr-2" color="warning" :size="$vuetify.display.mobile ? 20 : 24">mdi-alert-circle</v-icon>
                <span :class="$vuetify.display.mobile ? 'text-body-1' : 'text-h6'">Low Stock</span>
                <v-spacer />
                <v-chip 
                  size="x-small" 
                  :color="tables.lowStock.length > 0 ? 'warning' : 'success'" 
                  variant="flat"
                >
                  {{ tables.lowStock.length }}
                </v-chip>
              </v-card-title>
              <v-card-text class="pa-0" :style="{ maxHeight: $vuetify.display.mobile ? '150px' : '180px', overflowY: 'auto' }">
                <v-list v-if="tables.lowStock.length > 0" class="bg-transparent">
                  <v-list-item
                    v-for="product in tables.lowStock"
                    :key="product.id"
                    class="border-b"
                  >
                    <template #prepend>
                      <v-avatar color="warning" :size="$vuetify.display.mobile ? 28 : 32">
                        <v-icon color="white" :size="$vuetify.display.mobile ? 14 : 16">mdi-package-variant</v-icon>
                      </v-avatar>
                    </template>

                    <v-list-item-title :class="$vuetify.display.mobile ? 'text-caption' : 'text-body-2'">
                      {{ product.name_en }}
                    </v-list-item-title>

                    <template #append>
                      <v-chip size="x-small" color="warning" variant="flat">
                        {{ product.qty }}/{{ product.alert_qty }}
                      </v-chip>
                    </template>
                  </v-list-item>
                </v-list>
                <div v-else :class="['text-center text-grey-400', $vuetify.display.mobile ? 'pa-3' : 'pa-4']">
                  <v-icon :size="$vuetify.display.mobile ? 32 : 48" class="mb-2">mdi-check-circle</v-icon>
                  <div :class="$vuetify.display.mobile ? 'text-caption' : ''">All products well stocked!</div>
                </div>
              </v-card-text>
            </v-card>
          </v-col>

          <!-- Today's Attendance -->
          <v-col cols="12">
            <v-card class="data-card">
              <v-card-title class="d-flex align-center flex-wrap">
                <v-icon class="mr-2" color="info" :size="$vuetify.display.mobile ? 20 : 24">mdi-clock-check</v-icon>
                <span :class="$vuetify.display.mobile ? 'text-body-1' : 'text-h6'">Today's Attendance</span>
                <v-spacer />
                <v-chip size="x-small" color="info" variant="flat">
                  {{ tables.attendance.length }}
                </v-chip>
              </v-card-title>
              <v-card-text class="pa-0" :style="{ maxHeight: $vuetify.display.mobile ? '150px' : '180px', overflowY: 'auto' }">
                <v-list v-if="tables.attendance.length > 0" class="bg-transparent">
                  <v-list-item
                    v-for="attendance in tables.attendance"
                    :key="attendance.id"
                    class="border-b"
                  >
                    <template #prepend>
                      <v-avatar 
                        :color="attendance.clock_out ? 'success' : 'primary'" 
                        :size="$vuetify.display.mobile ? 28 : 32"
                      >
                        <v-icon color="white" :size="$vuetify.display.mobile ? 14 : 16">
                          {{ attendance.clock_out ? 'mdi-check' : 'mdi-clock' }}
                        </v-icon>
                      </v-avatar>
                    </template>

                    <v-list-item-title :class="$vuetify.display.mobile ? 'text-caption' : 'text-body-2'">
                      {{ attendance.user?.name }}
                    </v-list-item-title>
                    <v-list-item-subtitle class="text-caption">
                      In: {{ attendance.clock_in }} 
                      {{ attendance.clock_out ? `| Out: ${attendance.clock_out}` : '| Working' }}
                    </v-list-item-subtitle>
                  </v-list-item>
                </v-list>
                <div v-else :class="['text-center text-grey-400', $vuetify.display.mobile ? 'pa-3' : 'pa-4']">
                  <v-icon :size="$vuetify.display.mobile ? 32 : 48" class="mb-2">mdi-account-clock</v-icon>
                  <div :class="$vuetify.display.mobile ? 'text-caption' : ''">No attendance today</div>
                </div>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-col>
    </v-row>

    <!-- Last Update Info -->
    <div class="text-center mt-6">
      <v-chip variant="outlined" color="grey">
        <v-icon start>mdi-update</v-icon>
        Last updated: {{ lastUpdate ? lastUpdate.toLocaleTimeString() : 'Never' }}
      </v-chip>
    </div>
  </AdminLayout>
</template>

<style scoped>
.stat-card {
  background: linear-gradient(135deg, var(--v-theme-surface) 0%, rgba(255,255,255,0.05) 100%);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.1);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.stat-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 3px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
  animation: shimmer 2s infinite;
}

.stat-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 35px rgba(0,0,0,0.4);
}

.chart-card, .data-card {
  background: rgba(255,255,255,0.02);
  backdrop-filter: blur(15px);
  border: 1px solid rgba(255,255,255,0.1);
  transition: all 0.3s ease;
}

.chart-card:hover, .data-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.notification-container {
  position: fixed;
  top: 80px;
  right: 20px;
  z-index: 9999;
  max-width: 400px;
  width: 100%;
}

.notification-alert {
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255,255,255,0.1);
  box-shadow: 0 8px 25px rgba(0,0,0,0.3);
}

.notification-card {
  backdrop-filter: blur(15px);
  border: 1px solid rgba(255,255,255,0.1);
}

.border-b {
  border-bottom: 1px solid rgba(255,255,255,0.1);
}

.mdi-spin {
  animation: spin 1s linear infinite;
}

@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

@keyframes shimmer {
  0% { transform: translateX(-100%); }
  100% { transform: translateX(100%); }
}

@media (max-width: 768px) {
  .notification-container {
    left: 10px;
    right: 10px;
    top: 70px;
    max-width: none;
  }
  
  .notification-alert {
    font-size: 0.875rem;
  }
  
  .stat-card {
    margin-bottom: 0.5rem;
  }
  
  .chart-card, .data-card {
    margin-bottom: 1rem;
  }
}

@media (max-width: 600px) {
  .v-table {
    font-size: 0.75rem;
  }
  
  .v-table th,
  .v-table td {
    padding: 8px 4px !important;
  }
  
  .v-chip {
    font-size: 0.65rem;
  }
}

@media (max-width: 480px) {
  .notification-container {
    top: 60px;
    left: 5px;
    right: 5px;
  }
}
</style>