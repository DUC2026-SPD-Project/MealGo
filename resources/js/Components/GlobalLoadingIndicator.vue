<script setup>
import { router } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted } from 'vue';

const isLoading = ref(false);
const loadingMessage = ref('Loading...');

// Different messages for different types of requests
const messages = {
    post: 'Saving...',
    put: 'Updating...',
    patch: 'Updating...',
    delete: 'Deleting...',
    get: 'Loading...',
};

let startTime = null;
let minimumLoadingTime = 300; // Show loading for at least 300ms to avoid flicker

const startLoading = (event) => {
    startTime = Date.now();
    
    // Determine the message based on the HTTP method
    const method = event.detail?.visit?.method?.toLowerCase() || 'get';
    loadingMessage.value = messages[method] || 'Processing...';
    
    // Show loading immediately
    isLoading.value = true;
};

const finishLoading = () => {
    const elapsedTime = Date.now() - startTime;
    const remainingTime = Math.max(0, minimumLoadingTime - elapsedTime);
    
    // Ensure loading shows for minimum time to avoid flicker
    setTimeout(() => {
        isLoading.value = false;
    }, remainingTime);
};

onMounted(() => {
    // Listen to Inertia events
    router.on('start', startLoading);
    router.on('finish', finishLoading);
    router.on('error', finishLoading);
    router.on('exception', finishLoading);
});

onUnmounted(() => {
    // Clean up event listeners
    router.off('start', startLoading);
    router.off('finish', finishLoading);
    router.off('error', finishLoading);
    router.off('exception', finishLoading);
});
</script>

<template>
    <Transition name="fade">
        <div v-if="isLoading" class="global-loading-overlay">
            <!-- Backdrop -->
            <div class="loading-backdrop"></div>
            
            <!-- Loading Content -->
            <div class="loading-content">
                <!-- Starbucks-style Coffee Cup Animation -->
                <div class="coffee-cup-container">
                    <svg class="coffee-cup" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                        <!-- Cup -->
                        <path d="M20 30 L20 70 Q20 80 30 80 L70 80 Q80 80 80 70 L80 30 Z" 
                              fill="#00704A" 
                              stroke="#fff" 
                              stroke-width="2"/>
                        
                        <!-- Handle -->
                        <path d="M80 40 Q95 40 95 50 Q95 60 80 60" 
                              fill="none" 
                              stroke="#00704A" 
                              stroke-width="3"
                              stroke-linecap="round"/>
                        
                        <!-- Coffee -->
                        <ellipse cx="50" cy="35" rx="25" ry="8" 
                                 fill="#8B4513" 
                                 opacity="0.8">
                            <animate attributeName="ry" 
                                     values="8;10;8" 
                                     dur="1.5s" 
                                     repeatCount="indefinite"/>
                        </ellipse>
                        
                        <!-- Steam -->
                        <g class="steam">
                            <path d="M35 25 Q35 15 40 10" 
                                  stroke="#fff" 
                                  stroke-width="2" 
                                  fill="none" 
                                  opacity="0.6"
                                  stroke-linecap="round">
                                <animate attributeName="opacity" 
                                         values="0.6;0;0.6" 
                                         dur="2s" 
                                         repeatCount="indefinite"/>
                                <animateTransform attributeName="transform"
                                                  type="translate"
                                                  values="0,0; 0,-5; 0,-10"
                                                  dur="2s"
                                                  repeatCount="indefinite"/>
                            </path>
                            <path d="M50 25 Q50 15 55 10" 
                                  stroke="#fff" 
                                  stroke-width="2" 
                                  fill="none" 
                                  opacity="0.6"
                                  stroke-linecap="round">
                                <animate attributeName="opacity" 
                                         values="0.6;0;0.6" 
                                         dur="2s" 
                                         begin="0.3s"
                                         repeatCount="indefinite"/>
                                <animateTransform attributeName="transform"
                                                  type="translate"
                                                  values="0,0; 0,-5; 0,-10"
                                                  dur="2s"
                                                  begin="0.3s"
                                                  repeatCount="indefinite"/>
                            </path>
                            <path d="M65 25 Q65 15 60 10" 
                                  stroke="#fff" 
                                  stroke-width="2" 
                                  fill="none" 
                                  opacity="0.6"
                                  stroke-linecap="round">
                                <animate attributeName="opacity" 
                                         values="0.6;0;0.6" 
                                         dur="2s" 
                                         begin="0.6s"
                                         repeatCount="indefinite"/>
                                <animateTransform attributeName="transform"
                                                  type="translate"
                                                  values="0,0; 0,-5; 0,-10"
                                                  dur="2s"
                                                  begin="0.6s"
                                                  repeatCount="indefinite"/>
                            </path>
                        </g>
                    </svg>
                </div>
                
                <!-- Loading Text -->
                <div class="loading-text">
                    <h3 class="loading-title">{{ loadingMessage }}</h3>
                    <p class="loading-subtitle">Please wait a moment</p>
                </div>
                
                <!-- Progress Bar -->
                <div class="progress-bar-container">
                    <div class="progress-bar"></div>
                </div>
                
                <!-- Loading Dots -->
                <div class="loading-dots">
                    <span class="dot"></span>
                    <span class="dot"></span>
                    <span class="dot"></span>
                </div>
            </div>
        </div>
    </Transition>
</template>

<style scoped>
.global-loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loading-backdrop {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(8px);
}

.loading-content {
    position: relative;
    z-index: 10000;
    background: linear-gradient(135deg, #00704A 0%, #004d33 100%);
    border-radius: 24px;
    padding: 3rem 4rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    text-align: center;
    min-width: 320px;
    border: 2px solid rgba(255, 255, 255, 0.1);
}

.coffee-cup-container {
    margin-bottom: 1.5rem;
    display: flex;
    justify-content: center;
}

.coffee-cup {
    width: 120px;
    height: 120px;
    filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.3));
}

.loading-text {
    margin-bottom: 1.5rem;
}

.loading-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: white;
    margin: 0 0 0.5rem 0;
    font-family: 'SoDo Sans', Helvetica, Arial, sans-serif;
}

.loading-subtitle {
    font-size: 0.95rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
}

.progress-bar-container {
    width: 100%;
    height: 4px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #FFD180, #FFA726, #FFD180);
    background-size: 200% 100%;
    animation: progressAnimation 1.5s ease-in-out infinite;
    border-radius: 2px;
}

@keyframes progressAnimation {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

.loading-dots {
    display: flex;
    justify-content: center;
    gap: 0.5rem;
}

.dot {
    width: 10px;
    height: 10px;
    background: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
    animation: dotPulse 1.4s ease-in-out infinite;
}

.dot:nth-child(1) {
    animation-delay: 0s;
}

.dot:nth-child(2) {
    animation-delay: 0.2s;
}

.dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes dotPulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.6;
    }
    50% {
        transform: scale(1.3);
        opacity: 1;
    }
}

/* Fade transition */
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

/* Mobile Responsive */
@media (max-width: 640px) {
    .loading-content {
        padding: 2rem 2.5rem;
        min-width: 280px;
        margin: 1rem;
    }
    
    .coffee-cup {
        width: 100px;
        height: 100px;
    }
    
    .loading-title {
        font-size: 1.25rem;
    }
    
    .loading-subtitle {
        font-size: 0.875rem;
    }
}

/* Prevent body scroll when loading */
body:has(.global-loading-overlay) {
    overflow: hidden;
}
</style>
