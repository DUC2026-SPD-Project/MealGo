<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head, Link, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import { useProductStore } from '@/Stores/productStore';

const store = useProductStore();
const page = usePage();

// Check if user is authenticated
const isAuthenticated = computed(() => page.props.auth.user !== null);

// Login prompt dialog
const showLoginDialog = ref(false);

// State for product details
const selectedProduct = ref(null);
const showDetailsDialog = ref(false);

// Notification system
const showNotification = ref(false);
const notificationMessage = ref('');
const notificationType = ref('success');

// Helper function to normalize image paths
const normalizeImagePath = (imagePath) => {
    console.log('normalizeImagePath called with:', imagePath);
    if (!imagePath) {
        console.log('No image path, returning fallback');
        return 'https://via.placeholder.com/120x120?text=No+Image';
    }
    
    // If it's already a full URL, return as is
    if (imagePath.startsWith('http')) {
        console.log('Image path is full URL, returning as is');
        return imagePath;
    }
    
    // If it starts with /storage/, return as is
    if (imagePath.startsWith('/storage/')) {
        console.log('Image path starts with /storage/, returning as is');
        return imagePath;
    }
    
    // Otherwise, prepend /storage/
    console.log('Prepending /storage/ to image path');
    return '/storage/' + imagePath;
};

// Computed properties
const cartItems = computed(() => {
    console.log('cartItems computed called');
    console.log('store.cart:', store.cart);
    const items = (store.cart || []).map(item => {
        console.log('Processing item:', item);
        return {
            ...item,
            // Use image_url if available, otherwise fallback to image with normalization
            image: item.image_url || normalizeImagePath(item.image)
        };
    });
    console.log('cartItems result:', items);
    return items;
});

const totalItems = computed(() => store.cartItemCount || 0);
const subtotal = computed(() => store.cartTotal || 0);
const tax = computed(() => subtotal.value * 0.10);
const total = computed(() => subtotal.value + tax.value);
const shippingCost = 9.99;

// Methods
const updateQuantity = (itemId, newQuantity) => {
    if (newQuantity > 0 && newQuantity <= 99) {
        store.updateQuantity(itemId, newQuantity);
    }
};

const removeFromCart = (itemId) => {
    store.removeFromCart(itemId);
};

const proceedToCheckout = () => {
    console.log('Checkout button clicked');
    console.log('Cart items:', cartItems.value);
    console.log('Cart count:', cartItems.value.length);
    
    if (cartItems.value.length === 0) {
        console.log('Cart is empty, showing notification');
        showNotificationMessage('Your cart is empty! Please add some items first.', 'warning');
        return;
    }
    
    console.log('Navigating to checkout...');
    
    try {
        // Use Inertia router for SPA navigation
        router.visit('/checkout', {
            method: 'get',
            preserveState: true,
            preserveScroll: false,
            onError: (errors) => {
                console.error('Checkout navigation error:', errors);
                // Fallback to direct navigation
                window.location.href = '/checkout';
            },
            onSuccess: () => {
                console.log('Successfully navigated to checkout');
            }
        });
    } catch (error) {
        console.error('Navigation error:', error);
        // Fallback to window.location
        window.location.href = '/checkout';
    }
};

const showProductDetails = (item) => {
    selectedProduct.value = {
        ...item,
        image: item.image_url || normalizeImagePath(item.image)
    };
    showDetailsDialog.value = true;
};

const closeProductDetails = () => {
    showDetailsDialog.value = false;
    selectedProduct.value = null;
};

const toggleFavorite = (item) => {
    // Check if user is logged in
    if (!isAuthenticated.value) {
        showLoginDialog.value = true;
        return;
    }

    if (store.isInFavorites(item.id)) {
        store.removeFromFavorites(item.id);
    } else {
        store.addToFavorites(item);
    }
};

const isItemFavorited = (itemId) => store.isInFavorites(itemId);

// Notification helper
const showNotificationMessage = (message, type = 'success') => {
    notificationMessage.value = message;
    notificationType.value = type;
    showNotification.value = true;
};
</script>

<template>
    <Head title="Shopping Cart" />

    <ShopLayout>
        <div class="cart-page">
            <!-- Header -->
            <div class="cart-header">
                <v-container>
                    <div class="header-content">
                        <div class="header-icon">
                            <v-icon icon="mdi-cart" size="48" color="primary"></v-icon>
                        </div>
                        <h1 class="header-title">Your Cart</h1>
                        <p class="header-subtitle">{{ totalItems }} items</p>
                    </div>
                </v-container>
            </div>

            <!-- Main Content -->
            <v-container>
                <div v-if="cartItems.length === 0" class="empty-state">
                    <v-icon icon="mdi-cart-outline" size="96" color="grey-lighten-1" class="mb-6"></v-icon>
                    <h2 class="empty-title">Your cart is empty</h2>
                    <p class="empty-subtitle">Start adding some delicious items to your cart!</p>
                    <Link :href="route('home')">
                        <v-btn color="primary" size="large" variant="flat" class="browse-btn">
                            Browse Menu
                        </v-btn>
                    </Link>
                </div>

                <div v-else class="cart-content">
                    <!-- Cart Items -->
                    <div class="cart-items">
                        <div 
                            v-for="item in cartItems" 
                            :key="item.id" 
                            class="cart-item"
                        >
                            <div class="item-image">
                                <v-img 
                                    :src="item.image" 
                                    height="120"
                                    width="120"
                                    cover
                                    @click="showProductDetails(item)"
                                    class="image"
                                    :alt="item.name"
                                    @load="console.log('Image loaded successfully:', item.image)"
                                    @error="console.log('Image failed to load:', item.image)"
                                ></v-img>
                            </div>
                            
                            <div class="item-details">
                                <h3 class="item-name">{{ item.name }}</h3>
                                <p class="item-description">{{ item.description || 'No description' }}</p>
                                <div class="item-attributes">
                                    <span class="attribute">Color: Black</span>
                                    <span class="attribute">Size: Medium</span>
                                </div>
                            </div>
                            
                            <div class="item-actions">
                                <div class="price-info">
                                    <div class="unit-price">${{ (typeof item.price === 'number' ? item.price : 0).toFixed(2) }}</div>
                                    <div class="total-price">${{ (typeof item.price === 'number' ? item.price * item.quantity : 0).toFixed(2) }}</div>
                                </div>
                                
                                <div class="quantity-selector">
                                    <span class="quantity-label">Qty:</span>
                                    <div class="quantity-controls">
                                        <v-btn 
                                            icon="mdi-minus"
                                            size="small"
                                            variant="text"
                                            @click="updateQuantity(item.id, item.quantity - 1)"
                                            :disabled="item.quantity <= 1"
                                            class="quantity-btn"
                                        ></v-btn>
                                        <span class="quantity-value">{{ item.quantity }}</span>
                                        <v-btn 
                                            icon="mdi-plus"
                                            size="small"
                                            variant="text"
                                            @click="updateQuantity(item.id, item.quantity + 1)"
                                            :disabled="item.quantity >= 99"
                                            class="quantity-btn"
                                        ></v-btn>
                                    </div>
                                </div>
                                
                                <v-btn 
                                    icon="mdi-delete"
                                    variant="text"
                                    color="error"
                                    size="small"
                                    @click="removeFromCart(item.id)"
                                    title="Remove item"
                                    class="remove-btn"
                                ></v-btn>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Order Summary -->
                    <div class="order-summary">
                        <v-card class="summary-card" elevation="1">
                            <v-card-title class="summary-title">Order Summary</v-card-title>
                            
                            <div class="summary-details">
                                <div class="summary-row">
                                    <span class="label">Subtotal ({{ totalItems }} items)</span>
                                    <span class="value">${{ subtotal.toFixed(2) }}</span>
                                </div>
                                <div class="summary-row">
                                    <span class="label">Shipping</span>
                                    <span class="value">${{ shippingCost.toFixed(2) }}</span>
                                </div>
                                <div class="summary-row">
                                    <span class="label">Tax</span>
                                    <span class="value">${{ tax.toFixed(2) }}</span>
                                </div>
                                <v-divider class="divider"></v-divider>
                                <div class="summary-row total">
                                    <span class="label">Total</span>
                                    <span class="value">${{ (total + shippingCost).toFixed(2) }}</span>
                                </div>
                            </div>

                            <v-btn 
                                color="primary" 
                                size="large" 
                                block 
                                class="checkout-btn"
                                @click="proceedToCheckout"
                                variant="flat"
                            >
                                Proceed to Checkout
                            </v-btn>

                            <!-- Alternative checkout link for testing -->
                            <Link href="/checkout" class="mt-2">
                                <v-btn 
                                    color="success" 
                                    size="large" 
                                    block 
                                    variant="outlined"
                                >
                                    Alternative Checkout (Link)
                                </v-btn>
                            </Link>

                            <Link :href="route('home')">
                                <v-btn 
                                    variant="text" 
                                    color="primary" 
                                    block
                                    class="continue-btn"
                                >
                                    Continue Shopping
                                </v-btn>
                            </Link>
                        </v-card>
                    </div>
                </div>
            </v-container>
        </div>
    </ShopLayout>
    
    <!-- Product Details Modal -->
    <v-dialog v-model="showDetailsDialog" max-width="600px">
        <v-card v-if="selectedProduct" class="bg-brown-darken-3">
            <v-card-title class="bg-amber-darken-2 text-brown-darken-4 d-flex justify-space-between align-center">
                <span>{{ selectedProduct.name }}</span>
                <v-btn icon="mdi-close" variant="text" @click="closeProductDetails"></v-btn>
            </v-card-title>
            
            <v-card-text class="pa-6">
                <v-row>
                    <v-col cols="5">
                        <v-img 
                            :src="selectedProduct.image" 
                            height="200"
                            cover
                            class="rounded-lg"
                            @load="console.log('Product details image loaded successfully:', selectedProduct.image)"
                            @error="console.log('Product details image failed to load:', selectedProduct.image)"
                        ></v-img>
                    </v-col>
                    
                    <v-col cols="7">
                        <div class="mb-4">
                            <h3 class="text-h6 font-weight-bold mb-2">Price</h3>
                            <p class="text-h5 text-amber-lighten-2">${{ selectedProduct.price.toFixed(2) }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-h6 font-weight-bold mb-2">Category</h3>
                            <p>{{ selectedProduct.category?.name || 'N/A' }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-h6 font-weight-bold mb-2">Description</h3>
                            <p>{{ selectedProduct.description || 'No description available.' }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-h6 font-weight-bold mb-2">Quantity in Cart</h3>
                            <p>{{ selectedProduct.quantity }}</p>
                        </div>
                    </v-col>
                </v-row>
            </v-card-text>
            
            <v-card-actions class="pa-4">
                <v-btn 
                    :icon="isItemFavorited(selectedProduct.id) ? 'mdi-heart' : 'mdi-heart-outline'"
                    :color="isItemFavorited(selectedProduct.id) ? 'red' : 'grey'"
                    @click="toggleFavorite(selectedProduct)"
                    variant="text"
                >
                    {{ isItemFavorited(selectedProduct.id) ? 'Remove from Favorites' : 'Add to Favorites' }}
                </v-btn>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="closeProductDetails">Close</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <!-- Login Required Dialog -->
    <v-dialog v-model="showLoginDialog" max-width="500px">
        <v-card class="bg-brown-darken-4">
            <v-card-title class="text-h5 bg-amber-darken-2 text-brown-darken-4 d-flex align-center">
                <v-icon icon="mdi-lock" class="mr-2"></v-icon>
                Authentication Required
            </v-card-title>
            
            <v-card-text class="pa-6 text-center">
                <v-icon icon="mdi-account-lock" size="80" color="amber-darken-2" class="mb-4"></v-icon>
                <h3 class="text-h6 font-weight-bold mb-3 text-white">Please Log In to Continue</h3>
                <p class="text-body-1 text-grey-lighten-2 mb-4">
                    You need to be logged in to add items to your favorites. 
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
                        class="text-black font-weight-bold px-6 mr-2"
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

    <!-- Notification Snackbar -->
    <v-snackbar
        v-model="showNotification"
        :color="notificationType"
        timeout="4000"
        location="top right"
    >
        {{ notificationMessage }}
        <template #actions>
            <v-btn icon="mdi-close" variant="text" @click="showNotification = false" />
        </template>
    </v-snackbar>
</template>

<style scoped>
.cart-page {
    min-height: 100vh;
    background-color: #fafafa;
}

/* Header Styles */
.cart-header {
    background: white;
    border-bottom: 1px solid #e0e0e0;
    padding: 2rem 0;
}

.header-content {
    text-align: center;
}

.header-icon {
    margin-bottom: 1rem;
}

.header-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
}

.header-subtitle {
    font-size: 1.125rem;
    color: #666666;
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
    font-weight: 500;
    text-transform: none;
    border-radius: 8px;
}

/* Cart Content */
.cart-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 2rem;
    padding: 2rem 0;
}

/* Cart Items */
.cart-items {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.cart-item {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    gap: 1.5rem;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.2s ease;
    border: 1px solid #f0f0f0;
}

.cart-item:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.item-image {
    flex-shrink: 0;
}

.image {
    border-radius: 8px;
    border: 1px solid #f0f0f0;
}

.item-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.item-name {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.item-description {
    font-size: 0.875rem;
    color: #666666;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.item-attributes {
    display: flex;
    gap: 1rem;
    font-size: 0.875rem;
    color: #666666;
}

.attribute {
    background: #f5f5f5;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-weight: 500;
}

.item-actions {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 1rem;
    min-width: 200px;
}

.price-info {
    text-align: right;
    margin-bottom: 0.5rem;
}

.unit-price {
    font-size: 0.875rem;
    color: #666666;
    margin-bottom: 0.25rem;
}

.total-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #1a1a1a;
}

.quantity-selector {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.5rem;
}

.quantity-label {
    font-size: 0.875rem;
    color: #666666;
    font-weight: 500;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background: #f5f5f5;
    border-radius: 8px;
    padding: 0.25rem;
}

.quantity-btn {
    width: 32px !important;
    height: 32px !important;
    min-width: 32px !important;
    border-radius: 6px !important;
    color: #1a1a1a;
}

.quantity-value {
    font-size: 1rem;
    font-weight: 600;
    min-width: 2rem;
    text-align: center;
    color: #1a1a1a;
}

.remove-btn {
    align-self: flex-end;
}

/* Order Summary */
.order-summary {
    position: sticky;
    top: 2rem;
    height: fit-content;
}

.summary-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #f0f0f0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.summary-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a1a;
    padding: 0 !important;
    margin-bottom: 1.5rem !important;
}

.summary-details {
    margin-bottom: 1.5rem;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    font-size: 0.875rem;
}

.summary-row .label {
    color: #666666;
}

.summary-row .value {
    color: #1a1a1a;
    font-weight: 500;
}

.summary-row.total {
    font-size: 1.125rem;
    font-weight: 700;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
}

.summary-row.total .label,
.summary-row.total .value {
    color: #1a1a1a;
    font-weight: 700;
}

.divider {
    margin: 1rem 0 !important;
}

.checkout-btn {
    height: 48px !important;
    font-weight: 500 !important;
    text-transform: none !important;
    border-radius: 8px !important;
    margin-bottom: 1rem !important;
    font-size: 1rem !important;
}

.continue-btn {
    height: 48px !important;
    font-weight: 500 !important;
    text-transform: none !important;
    border-radius: 8px !important;
    font-size: 1rem !important;
}

/* Responsive Design */
@media (max-width: 1024px) {
    .cart-content {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .order-summary {
        position: static;
    }
}

@media (max-width: 768px) {
    .cart-item {
        flex-direction: column;
        gap: 1rem;
    }
    
    .item-actions {
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        min-width: auto;
    }
    
    .price-info {
        text-align: left;
    }
    
    .quantity-selector {
        align-items: flex-start;
    }
    
    .remove-btn {
        align-self: center;
    }
}

@media (max-width: 480px) {
    .header-title {
        font-size: 2rem;
    }
    
    .cart-item {
        padding: 1rem;
    }
    
    .item-name {
        font-size: 1.125rem;
    }
    
    .summary-card {
        padding: 1.25rem;
    }
}
</style>