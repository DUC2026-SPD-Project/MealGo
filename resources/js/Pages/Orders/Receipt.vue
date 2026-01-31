<template>
  <Head :title="`Receipt - ${order.order_number}`" />

  <div class="min-h-screen bg-gradient-to-br from-grey-900 to-black">
    <!-- Navigation -->
    <nav class="bg-black/50 backdrop-blur-lg border-b border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <Link href="/" class="text-white font-bold text-xl">
              SMS Store
            </Link>
          </div>
          
          <div class="flex items-center space-x-4">
            <v-btn
              variant="outlined"
              color="white"
              @click="downloadReceipt"
            >
              <v-icon start>mdi-download</v-icon>
              Download PDF
            </v-btn>
            
            <v-btn
              variant="outlined"
              color="white"
              @click="printReceipt"
            >
              <v-icon start>mdi-printer</v-icon>
              Print
            </v-btn>
          </div>
        </div>
      </div>
    </nav>

    <!-- Receipt Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
        <!-- Header -->
        <div class="bg-gradient-to-r from-primary to-blue-600 text-white p-8">
          <div class="text-center">
            <h1 class="text-3xl font-bold mb-2">SMS Store</h1>
            <p class="text-blue-100">123 Business Street, City, State 12345</p>
            <p class="text-blue-100">Phone: +1 (555) 123-4567 | Email: info@smsstore.com</p>
          </div>
        </div>

        <!-- Receipt Title -->
        <div class="text-center py-6 border-b">
          <h2 class="text-2xl font-bold text-grey-800">SALES RECEIPT</h2>
        </div>

        <!-- Order Information -->
        <div class="p-8">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Order Details -->
            <div class="bg-grey-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-grey-800 mb-4">Order Information</h3>
              <div class="space-y-2">
                <div class="flex justify-between">
                  <span class="text-grey-600">Order #:</span>
                  <span class="font-semibold">{{ order.order_number }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-grey-600">Date:</span>
                  <span class="font-semibold">{{ formatDate(order.created_at) }}</span>
                </div>
                <div class="flex justify-between">
                  <span class="text-grey-600">Status:</span>
                  <v-chip 
                    :color="getStatusColor(order.status)" 
                    size="small" 
                    variant="flat"
                  >
                    {{ order.status.charAt(0).toUpperCase() + order.status.slice(1) }}
                  </v-chip>
                </div>
                <div class="flex justify-between">
                  <span class="text-grey-600">Payment:</span>
                  <v-chip color="primary" size="small" variant="flat">
                    {{ formatPaymentMethod(order.payment_method) }}
                  </v-chip>
                </div>
              </div>
            </div>

            <!-- Customer Details -->
            <div class="bg-grey-50 p-6 rounded-lg">
              <h3 class="text-lg font-semibold text-grey-800 mb-4">Customer Information</h3>
              <div class="space-y-2">
                <div>
                  <span class="text-grey-600">Name:</span>
                  <span class="font-semibold ml-2">{{ order.customer_name }}</span>
                </div>
                <div>
                  <span class="text-grey-600">Email:</span>
                  <span class="font-semibold ml-2">{{ order.customer_email }}</span>
                </div>
                <div>
                  <span class="text-grey-600">Phone:</span>
                  <span class="font-semibold ml-2">{{ order.customer_phone }}</span>
                </div>
                <div>
                  <span class="text-grey-600">Address:</span>
                  <span class="font-semibold ml-2">
                    {{ order.shipping_address }}<br>
                    {{ order.city }}{{ order.postal_code ? ', ' + order.postal_code : '' }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Items Table -->
          <div class="mb-8">
            <h3 class="text-lg font-semibold text-grey-800 mb-4">Order Items</h3>
            <div class="overflow-x-auto">
              <table class="w-full border-collapse bg-white shadow-sm rounded-lg overflow-hidden">
                <thead>
                  <tr class="bg-grey-100">
                    <th class="text-left p-4 font-semibold text-grey-700">Product</th>
                    <th class="text-center p-4 font-semibold text-grey-700">Qty</th>
                    <th class="text-right p-4 font-semibold text-grey-700">Unit Price</th>
                    <th class="text-right p-4 font-semibold text-grey-700">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <tr 
                    v-for="item in order.sale_items" 
                    :key="item.id"
                    class="border-b border-grey-100"
                  >
                    <td class="p-4">
                      <div class="font-semibold text-grey-800">{{ item.product_name }}</div>
                    </td>
                    <td class="p-4 text-center">{{ item.quantity }}</td>
                    <td class="p-4 text-right">${{ item.price.toFixed(2) }}</td>
                    <td class="p-4 text-right font-semibold">
                      ${{ (item.quantity * item.price).toFixed(2) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <!-- Totals -->
          <div class="flex justify-end">
            <div class="w-full max-w-md">
              <div class="bg-grey-50 p-6 rounded-lg">
                <div class="space-y-3">
                  <div class="flex justify-between">
                    <span class="text-grey-600">Subtotal:</span>
                    <span class="font-semibold">${{ order.subtotal.toFixed(2) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-grey-600">Tax (10%):</span>
                    <span class="font-semibold">${{ order.tax.toFixed(2) }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-grey-600">Shipping:</span>
                    <span class="font-semibold">${{ order.shipping.toFixed(2) }}</span>
                  </div>
                  <div class="border-t pt-3">
                    <div class="flex justify-between text-xl font-bold text-primary">
                      <span>TOTAL:</span>
                      <span>${{ order.total.toFixed(2) }}</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Order Notes -->
          <div v-if="order.notes" class="mt-8 bg-blue-50 p-6 rounded-lg">
            <h3 class="text-lg font-semibold text-grey-800 mb-2">Order Notes:</h3>
            <p class="text-grey-700">{{ order.notes }}</p>
          </div>

          <!-- Footer -->
          <div class="mt-12 text-center text-grey-500 border-t pt-8">
            <div class="text-xl font-bold text-primary mb-2">Thank you for your business!</div>
            <p class="mb-2">This is a computer-generated receipt. No signature required.</p>
            <p class="mb-4">For questions about this order, please contact us at info@smsstore.com or +1 (555) 123-4567</p>
            <p class="text-sm text-grey-400">
              Generated on {{ formatDate(new Date()) }} | Receipt ID: {{ order.id }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
  order: Object
});

// Methods
const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

const formatPaymentMethod = (method) => {
  return method.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
};

const getStatusColor = (status) => {
  const colors = {
    'completed': 'success',
    'pending': 'warning',
    'processing': 'info',
    'cancelled': 'error'
  };
  return colors[status] || 'grey';
};

const downloadReceipt = () => {
  window.open(`/orders/${props.order.id}/receipt`, '_blank');
};

const printReceipt = () => {
  window.print();
};
</script>

<style scoped>
@media print {
  nav {
    display: none !important;
  }
  
  .min-h-screen {
    min-height: auto;
  }
  
  .bg-gradient-to-br {
    background: white !important;
  }
  
  .shadow-2xl {
    box-shadow: none !important;
  }
}
</style>