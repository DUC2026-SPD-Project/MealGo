<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const drawer = ref(true);
const page = usePage();
const user = page.props.auth.user;

const menuItems = [
    { title: 'Dashboard', icon: 'mdi-view-dashboard', route: 'dashboard' },
    { title: 'POS', icon: 'mdi-cart-outline', route: 'pos.index' },
    { title: 'Products', icon: 'mdi-package-variant', route: 'products.index' },
    { title: 'Employees', icon: 'mdi-account-group', route: 'employees.index' },
];
</script>

<template>
  <v-app>
    <v-navigation-drawer v-model="drawer" color="surface" elevation="2">
      <v-list>
        <v-list-item 
            prepend-avatar="https://cdn.vuetifyjs.com/images/john.jpg" 
            :title="user.name" 
            subtitle="Admin"
        ></v-list-item>
      </v-list>
      <v-divider></v-divider>
      <v-list density="compact" nav>
        <v-list-item 
            v-for="item in menuItems" 
            :key="item.title" 
            :prepend-icon="item.icon" 
            :title="item.title"
            :href="route(item.route)" 
            @click.prevent="$inertia.visit(route(item.route))"
            :active="route().current(item.route)"
            color="primary"
        ></v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar elevation="1">
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
      <v-app-bar-title>Vin's Tech Shop</v-app-bar-title>
      <v-spacer></v-spacer>
      <v-btn icon="mdi-translate"></v-btn> </v-app-bar>

    <v-main class="bg-background">
      <v-container fluid>
         <transition name="fade" mode="out-in">
           <slot />
         </transition>
      </v-container>
    </v-main>
  </v-app>
</template>

<style>
.fade-enter-active, .fade-leave-active { transition: opacity 0.3s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
</style>