<template>
    <v-app>
        <v-main class="bg-grey-lighten-3">
            <v-container>
                <h1 class="text-h4 font-weight-bold mb-5">Dashboard Overview</h1>
                
                <v-row>
                    <v-col cols="12" md="4" v-for="stat in stats" :key="stat.title">
                        <v-card class="rounded-lg" elevation="2">
                            <v-card-item>
                                <div class="text-overline mb-1">{{ stat.title }}</div>
                                <div class="text-h4 mb-1">{{ stat.value }}</div>
                                <div clas   ="text-caption text-success" v-if="stat.trend > 0">
                                    <v-icon icon="mdi-arrow-up" size="small"></v-icon>
                                    {{ stat.trend }}% since last month
                                </div>
                            </v-card-item>
                        </v-card>
                    </v-col>
                </v-row>

                <v-card class="mt-5 pa-4 rounded-lg">
                    <h2 class="text-h6">Sales Performance</h2>
                    <div class="h-[300px] bg-grey-lighten-4 d-flex align-center justify-center">
                        [Graph Placeholder] 
                    </div>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
// Props come directly from Laravel Controller!
defineProps({ stats: Array });
</script>