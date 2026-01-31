<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const showPassword = ref(false);

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />

    <div class="min-h-screen flex">
        <!-- Left Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-green-900 via-green-800 to-green-950 relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-20 left-20 w-72 h-72 bg-amber-400/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-20 right-20 w-96 h-96 bg-green-400/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse delay-2000"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
                <div class="max-w-md text-center">
                    <!-- Logo -->
                    <div class="mb-8 flex justify-center">
                        <div class="relative">
                            <v-icon icon="mdi-coffee" size="120" color="amber-lighten-2" class="drop-shadow-2xl"></v-icon>
                            <div class="absolute inset-0 bg-amber-400/30 blur-2xl rounded-full"></div>
                        </div>
                    </div>

                    <!-- Brand Name -->
                    <h1 class="text-5xl font-bold mb-4 drop-shadow-lg">
                        Nann's <span class="text-amber-300">Coffee</span>
                    </h1>
                    <p class="text-xl text-green-100 mb-8">
                        Premium Store Management System
                    </p>

                    <!-- Features -->
                    <div class="space-y-4 text-left">
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                            <v-icon icon="mdi-chart-line" size="32" color="amber-lighten-2"></v-icon>
                            <div>
                                <h3 class="font-semibold">Real-time Analytics</h3>
                                <p class="text-sm text-green-100">Track your business performance</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                            <v-icon icon="mdi-cart" size="32" color="amber-lighten-2"></v-icon>
                            <div>
                                <h3 class="font-semibold">Smart POS System</h3>
                                <p class="text-sm text-green-100">Fast and efficient checkout</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                            <v-icon icon="mdi-package-variant" size="32" color="amber-lighten-2"></v-icon>
                            <div>
                                <h3 class="font-semibold">Inventory Control</h3>
                                <p class="text-sm text-green-100">Never run out of stock</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-gray-50 to-gray-100">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <v-icon icon="mdi-coffee" size="64" color="green-darken-3"></v-icon>
                    <h1 class="text-3xl font-bold text-green-900 mt-2">
                        Nann's <span class="text-amber-600">Coffee</span>
                    </h1>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome Back!</h2>
                        <p class="text-gray-600">Sign in to continue to your dashboard</p>
                    </div>

                    <!-- Status Message -->
                    <v-alert
                        v-if="status"
                        type="success"
                        variant="tonal"
                        class="mb-6"
                        closable
                    >
                        {{ status }}
                    </v-alert>

                    <!-- Login Form -->
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- Email Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address
                            </label>
                            <v-text-field
                                v-model="form.email"
                                type="email"
                                variant="outlined"
                                density="comfortable"
                                placeholder="your.email@example.com"
                                prepend-inner-icon="mdi-email"
                                color="green-darken-3"
                                :error-messages="form.errors.email"
                                required
                                autofocus
                                autocomplete="username"
                                class="modern-input"
                            ></v-text-field>
                        </div>

                        <!-- Password Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                            </label>
                            <v-text-field
                                v-model="form.password"
                                :type="showPassword ? 'text' : 'password'"
                                variant="outlined"
                                density="comfortable"
                                placeholder="Enter your password"
                                prepend-inner-icon="mdi-lock"
                                :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="showPassword = !showPassword"
                                color="green-darken-3"
                                :error-messages="form.errors.password"
                                required
                                autocomplete="current-password"
                                class="modern-input"
                            ></v-text-field>
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="flex items-center justify-between">
                            <v-checkbox
                                v-model="form.remember"
                                label="Remember me"
                                color="green-darken-3"
                                density="compact"
                                hide-details
                            ></v-checkbox>

                            <Link
                                v-if="canResetPassword"
                                :href="route('password.request')"
                                class="text-sm font-medium text-green-700 hover:text-green-900 transition-colors"
                            >
                                Forgot password?
                            </Link>
                        </div>

                        <!-- Submit Button -->
                        <v-btn
                            type="submit"
                            :loading="form.processing"
                            :disabled="form.processing"
                            block
                            size="x-large"
                            color="green-darken-3"
                            class="text-white font-bold rounded-xl"
                            elevation="4"
                        >
                            <v-icon start>mdi-login</v-icon>
                            Sign In
                        </v-btn>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Don't have an account?</span>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <Link :href="route('register')">
                            <v-btn
                                block
                                size="large"
                                variant="outlined"
                                color="amber-darken-2"
                                class="font-bold rounded-xl"
                            >
                                <v-icon start>mdi-account-plus</v-icon>
                                Create Account
                            </v-btn>
                        </Link>
                    </form>
                </div>

                <!-- Footer -->
                <div class="text-center mt-8 text-sm text-gray-600">
                    <p>&copy; 2026 Nann's Coffee. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.modern-input :deep(.v-field) {
    border-radius: 12px;
    background: #f9fafb;
}

.modern-input :deep(.v-field--focused) {
    background: white;
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.delay-1000 {
    animation-delay: 1s;
}

.delay-2000 {
    animation-delay: 2s;
}
</style>