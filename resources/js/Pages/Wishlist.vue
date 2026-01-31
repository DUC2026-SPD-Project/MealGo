<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { useProductStore } from '@/Stores/productStore';

const store = useProductStore();
const page = usePage();

// Debug: Log component load
console.log('Wishlist page loaded');
console.log('Favorites from store:', store.favorites);
console.log('Store state:', store);

// Check if user is authenticated
const isAuthenticated = computed(() => page.props.auth.user !== null);

// Login prompt dialog
const showLoginDialog = ref(false);

// Get favorite items from the Pinia store
const favoriteItems = computed(() => store.favorites);

const removeFromFavorites = (itemId) => {
    const item = favoriteItems.value.find(item => item.id === itemId);
    store.removeFromFavorites(itemId);
    if (item) {
        showNotification(`💔 ${item.name || item.name_en} removed from wishlist!`, 'warning');
    }
};

// Show temporary notification
const showNotification = (message, type = 'success') => {
    const colors = {
        success: '#4CAF50',
        warning: '#FF9800',
        error: '#F44336'
    };
    
    // Create notification element
    const notification = document.createElement('div');
    notification.innerHTML = `
        <div style="
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: ${colors[type] || colors.success};
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            z-index: 9999;
            font-weight: 500;
            min-width: 250px;
            text-align: center;
        ">
            ${message}
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.parentNode.removeChild(notification);
        }
    }, 3000);
};

const addToCart = (item) => {
    // Check if user is logged in
    if (!isAuthenticated.value) {
        showLoginDialog.value = true;
        return;
    }

    store.addToCart(item);
    // Show success notification
    showNotification(`☕ ${item.name || item.name_en} added to cart!`, 'success');
};

const totalItems = computed(() => favoriteItems.value?.length || 0);
const totalPrice = computed(() => {
    if (!favoriteItems.value || favoriteItems.value.length === 0) {
        return 0;
    }
    return favoriteItems.value.reduce((sum, item) => {
        const price = parseFloat(item.price || item.sale_price || 0);
        return sum + price;
    }, 0);
});
</script>

<template>
    <Head title="My Wishlist" />

    <ShopLayout>
        <div class="wishlist-page">
            <!-- Header -->
            <div class="wishlist-header">
                <v-container>
                    <div class="header-content">
                        <v-icon icon="mdi-heart" size="64" color="red-lighten-2" class="mb-4"></v-icon>
                        <h1 class="header-title">Your Wishlist</h1>
                        <p class="header-subtitle">{{ totalItems }} items you love</p>
                    </div>
                </v-container>
            </div>

            <!-- Main Content -->
            <v-container class="py-12">
                <div v-if="favoriteItems.length === 0" class="empty-state">
                    <v-icon icon="mdi-heart-outline" size="128" color="grey" class="mb-6"></v-icon>
                    <h2 class="empty-title">Your Wishlist is Empty</h2>
                    <p class="empty-subtitle">Start adding items you love to your wishlist!</p>
                    <Link :href="route('home')">
                        <v-btn color="amber-darken-2" size="x-large" class="browse-btn">
                            Browse Menu
                        </v-btn>
                    </Link>
                </div>

                <div v-else>
                    <!-- Summary -->
                    <v-row class="mb-8">
                        <v-col cols="12" md="8">
                            <v-card class="summary-card pa-6" elevation="2">
                                <div class="d-flex justify-space-between align-center">
                                    <div>
                                        <h3 class="summary-title">Wishlist Summary</h3>
                                        <p class="summary-text">{{ totalItems }} items</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="total-label">Total</p>
                                        <p class="total-price">
                                            ${{ Number(totalPrice).toFixed(2) }}
                                        </p>
                                    </div>
                                </div>
                            </v-card>
                        </v-col>
                        <v-col cols="12" md="4">
                            <v-card class="action-card pa-6 h-100" elevation="2">
                                <div class="d-flex flex-column fill-height">
                                    <h3 class="action-title mb-4">Quick Actions</h3>
                                    <Link :href="route('home')">
                                        <v-btn color="amber-darken-2" variant="outlined" block class="mb-3">
                                            Add More Items
                                        </v-btn>
                                    </Link>
                                    <Link :href="route('cart.index')">
                                        <v-btn color="amber-darken-2" block>
                                            View Cart
                                        </v-btn>
                                    </Link>
                                </div>
                            </v-card>
                        </v-col>
                    </v-row>

                    <!-- Wishlist Items Grid -->
                    <v-row>
                        <v-col 
                            cols="12" 
                            md="6" 
                            lg="4" 
                            v-for="item in favoriteItems" 
                            :key="item.id"
                            class="mb-6"
                        >
                            <v-card class="wishlist-item h-100" elevation="2">
                                <v-img 
                                    :src="item.image_url" 
                                    height="200"
                                    cover
                                >
                                    <div class="d-flex justify-end pa-2">
                                        <v-btn 
                                            icon="mdi-heart"
                                            color="red"
                                            size="small"
                                            @click="removeFromFavorites(item.id)"
                                            title="Remove from wishlist"
                                        ></v-btn>
                                    </div>
                                </v-img>
                                
                                <v-card-text>
                                    <h3 class="item-name">{{ item.name || item.name_en }}</h3>
                                    <p class="item-description">{{ item.description || '' }}</p>
                                    <div class="d-flex justify-space-between align-center">
                                        <span class="item-price">
                                            ${{ Number(item.price || item.sale_price || 0).toFixed(2) }}
                                        </span>
                                        <v-btn 
                                            color="amber-darken-2"
                                            @click="addToCart(item)"
                                            prepend-icon="mdi-cart-plus"
                                        >
                                            Add to Cart
                                        </v-btn>
                                    </div>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                </div>
            </v-container>
        </div>
    </ShopLayout>

    <!-- Login Required Dialog -->
    <v-dialog v-model="showLoginDialog" max-width="500px">
        <v-card class="dialog-card">
            <v-card-title class="dialog-header d-flex align-center">
                <v-icon icon="mdi-lock" class="mr-2"></v-icon>
                Authentication Required
            </v-card-title>
            
            <v-card-text class="pa-6 text-center">
                <v-icon icon="mdi-account-lock" size="80" color="amber-darken-2" class="mb-4"></v-icon>
                <h3 class="dialog-title mb-3">Please Log In to Continue</h3>
                <p class="dialog-text mb-4">
                    You need to be logged in to add items to your cart. 
                    Create an account or log in to continue!
                </p>
            </v-card-text>
            
            <v-card-actions class="pa-6 pt-0 justify-center">
                <v-btn 
                    variant="text" 
                    color="grey-lighten-2" 
                    @click="showLoginDialog = false"
                    class="mr-2"
                >
                    Cancel
                </v-btn>
                <Link :href="route('login')">
                    <v-btn 
                        color="amber-darken-2" 
                        variant="flat"
                        prepend-icon="mdi-login"
                        class="font-weight-bold px-6 mr-2"
                    >
                        Log In
                    </v-btn>
                </Link>
                <Link :href="route('register')">
                    <v-btn 
                        color="white" 
                        variant="outlined"
                        prepend-icon="mdi-account-plus"
                        class="font-weight-bold px-6"
                    >
                        Sign Up
                    </v-btn>
                </Link>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<style scoped>
/* Page Styles */
.wishlist-page {
    min-height: 100vh;
    background-color: #fafafa;
}

/* Header Styles */
.wishlist-header {
    background: linear-gradient(135deg, #d32f2f 0%, #1a1a1a 100%);
    padding: 3rem 0;
}

.header-content {
    text-align: center;
}

.header-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #ffffff;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
}

.header-subtitle {
    font-size: 1.25rem;
    color: #ffcdd2;
    font-weight: 400;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 0;
}

.empty-title {
    font-size: 2rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 1rem;
}

.empty-subtitle {
    font-size: 1.125rem;
    color: #666666;
    margin-bottom: 2rem;
}

.browse-btn {
    padding: 0 2rem;
    height: 48px;
    font-weight: 600;
    text-transform: none;
    border-radius: 8px;
}

/* Summary Cards */
.summary-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
}

.summary-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.25rem;
}

.summary-text {
    font-size: 1rem;
    color: #666666;
}

.total-label {
    font-size: 1rem;
    color: #666666;
    margin-bottom: 0.25rem;
}

.total-price {
    font-size: 1.75rem;
    font-weight: 700;
    color: #FFA726;
}

/* Action Card */
.action-card {
    background: white;
    border-radius: 12px;
    border: 1px solid #f0f0f0;
}

.action-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #1a1a1a;
}

/* Wishlist Items */
.wishlist-item {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #f0f0f0;
}

.wishlist-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
}

.item-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.item-description {
    font-size: 0.875rem;
    color: #666666;
    margin-bottom: 1rem;
    min-height: 2.5rem;
}

.item-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #FFA726;
}

/* Dialog Styles */
.dialog-card {
    background: #424242;
    color: white;
}

.dialog-header {
    background: #FFA726;
    color: #1a1a1a;
    font-weight: 700;
    font-size: 1.25rem;
}

.dialog-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: white;
}

.dialog-text {
    font-size: 1rem;
    color: #e0e0e0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .header-title {
        font-size: 2rem;
    }
    
    .header-subtitle {
        font-size: 1rem;
    }
    
    .summary-title {
        font-size: 1.25rem;
    }
    
    .total-price {
        font-size: 1.5rem;
    }
}
</style>