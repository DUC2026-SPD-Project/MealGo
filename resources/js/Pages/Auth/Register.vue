<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head title="Register" />

    <div class="min-h-screen flex">
        <!-- Left Side - Registration Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gradient-to-br from-gray-50 to-gray-100">
            <div class="w-full max-w-md">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <v-icon icon="mdi-coffee" size="64" color="green-darken-3"></v-icon>
                    <h1 class="text-3xl font-bold text-green-900 mt-2">
                        Nann's <span class="text-amber-600">Coffee</span>
                    </h1>
                </div>

                <!-- Register Card -->
                <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-10">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-2">Create Account</h2>
                        <p class="text-gray-600">Join us and start managing your store</p>
                    </div>

                    <!-- Registration Form -->
                    <form @submit.prevent="submit" class="space-y-5">
                        <!-- Name Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Full Name
                            </label>
                            <v-text-field
                                v-model="form.name"
                                type="text"
                                variant="outlined"
                                density="comfortable"
                                placeholder="John Doe"
                                prepend-inner-icon="mdi-account"
                                color="green-darken-3"
                                :error-messages="form.errors.name"
                                required
                                autofocus
                                autocomplete="name"
                                class="modern-input"
                            ></v-text-field>
                        </div>

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
                                placeholder="Create a strong password"
                                prepend-inner-icon="mdi-lock"
                                :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="showPassword = !showPassword"
                                color="green-darken-3"
                                :error-messages="form.errors.password"
                                required
                                autocomplete="new-password"
                                class="modern-input"
                            ></v-text-field>
                        </div>

                        <!-- Confirm Password Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm Password
                            </label>
                            <v-text-field
                                v-model="form.password_confirmation"
                                :type="showPasswordConfirmation ? 'text' : 'password'"
                                variant="outlined"
                                density="comfortable"
                                placeholder="Re-enter your password"
                                prepend-inner-icon="mdi-lock-check"
                                :append-inner-icon="showPasswordConfirmation ? 'mdi-eye-off' : 'mdi-eye'"
                                @click:append-inner="showPasswordConfirmation = !showPasswordConfirmation"
                                color="green-darken-3"
                                :error-messages="form.errors.password_confirmation"
                                required
                                autocomplete="new-password"
                                class="modern-input"
                            ></v-text-field>
                        </div>

                        <!-- Terms Notice -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                            <p class="text-xs text-gray-600 text-center">
                                By creating an account, you agree to our 
                                <a href="#" class="text-green-700 font-semibold hover:underline">Terms of Service</a> 
                                and 
                                <a href="#" class="text-green-700 font-semibold hover:underline">Privacy Policy</a>
                            </p>
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
                            <v-icon start>mdi-account-plus</v-icon>
                            Create Account
                        </v-btn>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Already have an account?</span>
                            </div>
                        </div>

                        <!-- Login Link -->
                        <Link :href="route('login')">
                            <v-btn
                                block
                                size="large"
                                variant="outlined"
                                color="amber-darken-2"
                                class="font-bold rounded-xl"
                            >
                                <v-icon start>mdi-login</v-icon>
                                Sign In Instead
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

        <!-- Right Side - Branding -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-amber-600 via-amber-700 to-orange-800 relative overflow-hidden">
            <!-- Animated Background Elements -->
            <div class="absolute inset-0">
                <div class="absolute top-20 right-20 w-72 h-72 bg-green-400/20 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute bottom-20 left-20 w-96 h-96 bg-yellow-400/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-pulse delay-2000"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 flex flex-col justify-center items-center w-full p-12 text-white">
                <div class="max-w-md text-center">
                    <!-- Logo -->
                    <div class="mb-8 flex justify-center">
                        <div class="relative">
                            <v-icon icon="mdi-coffee" size="120" color="white" class="drop-shadow-2xl"></v-icon>
                            <div class="absolute inset-0 bg-white/30 blur-2xl rounded-full"></div>
                        </div>
                    </div>

                    <!-- Brand Name -->
                    <h1 class="text-5xl font-bold mb-4 drop-shadow-lg">
                        Join Nann's <span class="text-green-100">Coffee</span>
                    </h1>
                    <p class="text-xl text-amber-100 mb-8">
                        Start your journey to better business management
                    </p>

                    <!-- Benefits -->
                    <div class="space-y-4 text-left">
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                            <v-icon icon="mdi-check-circle" size="32" color="green-lighten-2"></v-icon>
                            <div>
                                <h3 class="font-semibold">Easy Setup</h3>
                                <p class="text-sm text-amber-100">Get started in minutes</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                            <v-icon icon="mdi-shield-check" size="32" color="green-lighten-2"></v-icon>
                            <div>
                                <h3 class="font-semibold">Secure & Reliable</h3>
                                <p class="text-sm text-amber-100">Your data is safe with us</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                            <v-icon icon="mdi-headset" size="32" color="green-lighten-2"></v-icon>
                            <div>
                                <h3 class="font-semibold">24/7 Support</h3>
                                <p class="text-sm text-amber-100">We're here to help anytime</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 bg-white/10 backdrop-blur-sm rounded-lg p-4">
                            <v-icon icon="mdi-rocket-launch" size="32" color="green-lighten-2"></v-icon>
                            <div>
                                <h3 class="font-semibold">Grow Your Business</h3>
                                <p class="text-sm text-amber-100">Scale with confidence</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="mt-12 grid grid-cols-3 gap-6">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">500+</div>
                            <div class="text-sm text-amber-100">Active Users</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">99.9%</div>
                            <div class="text-sm text-amber-100">Uptime</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-white">24/7</div>
                            <div class="text-sm text-amber-100">Support</div>
                        </div>
                    </div>
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