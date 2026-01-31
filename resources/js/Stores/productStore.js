// resources/js/Stores/productStore.js
import { defineStore } from 'pinia';

export const useProductStore = defineStore('product', {
    state: () => ({
        cart: [],
        products: [], // Loaded from API
        favorites: [],
    }),

    // Initialize store with persisted data
    hydrate(storeState, initialState) {
        console.log('Hydrating store with:', storeState);
        Object.assign(storeState, initialState);
    },

    persist: {
        key: 'product-store',
        storage: localStorage,
        pick: ['cart', 'favorites'],
    },
    getters: {
        cartItemCount: (state) => {
            return state.cart.reduce((total, item) => total + item.quantity, 0);
        },
        cartTotal: (state) => {
            return state.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        },
        favoriteCount: (state) => {
            return state.favorites.length;
        }
    },
    actions: {
        addToCart(product) {
            console.log('Adding to cart:', product);
            console.log('Current cart before adding:', this.cart);
            const found = this.cart.find(item => item.id === product.id);
            if (found) {
                found.quantity++;
            } else {
                // Use image_url from the product model accessor, fallback to manual handling
                const imageUrl = product.image_url || product.image || '/images/no-image.svg';

                this.cart.push({
                    id: product.id,
                    name: product.name_en || product.name || '',
                    price: parseFloat(product.sale_price) || parseFloat(product.price) || 0,
                    image: imageUrl,
                    image_url: imageUrl, // Store both for compatibility
                    description: product.description || '',
                    category: product.category || {},
                    barcode: product.barcode || '',
                    quantity: 1
                });
            }
            console.log('Cart after adding:', this.cart);
        },
        removeFromCart(productId) {
            this.cart = this.cart.filter(item => item.id !== productId);
        },
        updateQuantity(productId, newQuantity) {
            if (newQuantity <= 0) {
                this.removeFromCart(productId);
                return;
            }
            const item = this.cart.find(item => item.id === productId);
            if (item) {
                item.quantity = newQuantity;
            }
        },
        addToFavorites(product) {
            const found = this.favorites.find(item => item.id === product.id);
            if (!found) {
                this.favorites.push({ ...product });
            }
        },
        removeFromFavorites(productId) {
            this.favorites = this.favorites.filter(item => item.id !== productId);
        },
        isInFavorites(productId) {
            return this.favorites.some(item => item.id === productId);
        },
        isInCart(productId) {
            return this.cart.some(item => item.id === productId);
        },
        clearCart() {
            this.cart = [];
        },
        calculateTotal() {
            return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        }
    }
});