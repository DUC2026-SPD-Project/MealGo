<script setup>
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps({ products: Array }); // Passed from Controller
const cart = ref([]);
const search = ref('');

// Computed Property for instant search filtering
const filteredProducts = computed(() => {
    return props.products.filter(p => 
        p.name_en.toLowerCase().includes(search.value.toLowerCase()) || 
        p.barcode.includes(search.value)
    );
});

const addToCart = (product) => {
    const existing = cart.value.find(item => item.id === product.id);
    if (existing) {
        existing.qty++;
    } else {
        cart.value.push({ ...product, qty: 1 });
    }
    // Play a "beep" sound effect here for the cool factor
    new Audio('/sounds/beep.mp3').play();
};

const total = computed(() => {
    return cart.value.reduce((acc, item) => acc + (item.price * item.qty), 0);
});

const form = useForm({
    items: [],
    total: 0,
    payment_method: 'cash'
});

const submitSale = () => {
    form.items = cart.value;
    form.total = total.value;
    form.post(route('pos.store'), {
        onSuccess: () => {
            cart.value = []; // Reset cart
            // Show Success Snackbar
        }
    });
};
</script>

<template>
  <v-row>
    <v-col cols="8">
      <v-text-field v-model="search" label="Scan Barcode / Search" prepend-inner-icon="mdi-magnify" variant="solo" autofocus></v-text-field>
      <v-row>
        <v-col v-for="product in filteredProducts" :key="product.id" cols="3">
          <v-card @click="addToCart(product)" class="cursor-pointer hover-scale" elevation="4">
            <v-img :src="product.image_path || '/placeholder.png'" height="120" cover></v-img>
            <v-card-title class="text-subtitle-2">{{ product.name_en }}</v-card-title>
            <v-card-subtitle class="text-primary font-weight-bold">${{ product.price }}</v-card-subtitle>
          </v-card>
        </v-col>
      </v-row>
    </v-col>

    <v-col cols="4">
      <v-card height="85vh" class="d-flex flex-column">
        <v-card-title class="bg-surface">Current Order</v-card-title>
        <v-list class="flex-grow-1 overflow-y-auto">
             </v-list>
        <div class="pa-4 bg-surface-light">
            <div class="text-h4 mb-4 text-right">${{ total.toFixed(2) }}</div>
            <v-btn block color="success" size="x-large" @click="submitSale" :loading="form.processing">
                PAY NOW
            </v-btn>
        </div>
      </v-card>
    </v-col>
  </v-row>
</template>

<style>
.hover-scale:active { transform: scale(0.95); }
</style>