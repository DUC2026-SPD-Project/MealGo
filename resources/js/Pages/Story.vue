<script setup>
import ShopLayout from '@/Layouts/ShopLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Our Story" />

    <ShopLayout>
        <div class="bg-black text-white">
            <!-- Hero Section -->
            <div class="py-16 bg-gradient-to-r from-brown-darken-4 to-black">
                <v-container>
                    <v-row justify="center">
                        <v-col cols="12" md="8" class="text-center">
                            <v-icon icon="mdi-coffee" size="64" color="amber-lighten-4" class="mb-4"></v-icon>
                            <h1 class="text-h2 font-weight-bold mb-4">Our Story</h1>
                            <p class="text-h5 text-amber-lighten-2">Brewing passion, one cup at a time</p>
                        </v-col>
                    </v-row>
                </v-container>
            </div>

            <!-- Story Content -->
            <v-container class="py-16">
                <v-row>
                    <v-col cols="12" md="6">
                        <h2 class="text-h3 font-weight-bold mb-6 text-amber-lighten-4">The Beginning</h2>
                        <p class="text-body-1 mb-4">
                            Nann's Coffee began as a simple dream in a small kitchen. What started as a passion for perfecting the art of coffee brewing has grown into a beloved community gathering place.
                        </p>
                        <p class="text-body-1 mb-4">
                            Founded in 2010 by coffee enthusiast Sarah Nann, our journey began with a single espresso machine and an unwavering commitment to quality. Every bean is carefully selected, every roast is meticulously timed, and every cup is crafted with love.
                        </p>
                    </v-col>
                    <v-col cols="12" md="6">
                        <v-img 
                            src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                            aspect-ratio="1.5"
                            class="rounded-lg"
                        ></v-img>
                    </v-col>
                </v-row>

                <v-row class="mt-12">
                    <v-col cols="12" md="6" order="2" order-md="1">
                        <v-img 
                            src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                            aspect-ratio="1.5"
                            class="rounded-lg"
                        ></v-img>
                    </v-col>
                    <v-col cols="12" md="6" order="1" order-md="2">
                        <h2 class="text-h3 font-weight-bold mb-6 text-amber-lighten-4">Our Mission</h2>
                        <p class="text-body-1 mb-4">
                            We believe that great coffee brings people together. Our mission is to create a space where community, conversation, and exceptional coffee intersect.
                        </p>
                        <p class="text-body-1 mb-4">
                            From sourcing the finest beans from sustainable farms to creating a welcoming atmosphere, every detail matters. We're not just serving coffee – we're crafting experiences.
                        </p>
                    </v-col>
                </v-row>

                <v-row class="mt-12">
                    <v-col cols="12">
                        <div class="text-center py-8">
                            <h2 class="text-h3 font-weight-bold mb-6 text-amber-lighten-4">Join Our Community</h2>
                            <p class="text-h5 mb-8">
                                Visit us today and become part of the Nann's Coffee family
                            </p>
                            <Link :href="route('home')">
                                <v-btn 
                                    color="amber-darken-2" 
                                    size="x-large" 
                                    class="text-black font-weight-bold px-8"
                                >
                                    Explore Our Menu
                                </v-btn>
                            </Link>
                        </div>
                    </v-col>
                </v-row>
            </v-container>
        </div>
    </ShopLayout>
</template>