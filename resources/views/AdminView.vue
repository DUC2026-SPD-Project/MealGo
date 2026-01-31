<template>
    <v-row class="fill-height">
        <v-col cols="8" class="pa-4">
            <v-text-field label="Scan Barcode / Search" v-model="search" prepend-inner-icon="mdi-magnify" variant="solo" rounded></v-text-field>
            <v-row>
                <v-col v-for="product in products" :key="product.id" cols="3">
                    <v-card @click="store.addToCart(product)" class="hover-card">
                        <v-img :src="product.image_url" height="150" cover></v-img>
                        <v-card-title>{{ product.name }}</v-card-title>
                        <v-card-subtitle>${{ product.sale_price }}</v-card-subtitle>
                    </v-card>
                </v-col>
            </v-row>
        </v-col>

        <v-col cols="4" class="bg-white elevation-4 d-flex flex-column">
             <h2 class="text-h5 pa-4">Current Order</h2>
             <v-list class="flex-grow-1 overflow-y-auto">
                <v-list-item v-for="item in store.cart" :key="item.id">
                    <template v-slot:prepend>{{ item.qty }}x</template>
                    <v-list-item-title>{{ item.name }}</v-list-item-title>
                    <template v-slot:append>${{ (item.qty * item.sale_price).toFixed(2) }}</template>
                </v-list-item>
             </v-list>
             
             <div class="pa-4 bg-grey-lighten-4">
                <div class="d-flex justify-space-between text-h6">
                    <span>Total:</span>
                    <span>${{ store.calculateTotal() }}</span>
                </div>
                <v-btn block color="primary" size="large" class="mt-4" @click="checkout">
                    Checkout ({{ store.cart.length }} items)
                </v-btn>
             </div>
        </v-col>
    </v-row>
</template>

<script setup>
import { useProductStore } from '@/Stores/productStore'; // Matches image structure
const store = useProductStore();
const checkout = () => {
    // Send data to Laravel via Inertia
    router.post('/sales', { items: store.cart });
}
</script>

<style scoped>
.hover-card:hover { transform: translateY(-5px); transition: 0.3s; cursor: pointer; }
</style>