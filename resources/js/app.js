import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import GlobalLoadingIndicator from './Components/GlobalLoadingIndicator.vue';

// --- VUETIFY IMPORTS (MUST BE HERE) ---
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

// --- CONFIGURE VUETIFY ---
const vuetify = createVuetify({
    components,
    directives,
    theme: {
        defaultTheme: 'dark', // This makes it look "Cool" (Black/Dark mode)
    },
});

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({
            render: () => [
                h(App, props),
                h(GlobalLoadingIndicator)
            ]
        })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .use(vuetify); // <--- THIS IS THE MAGIC LINE. WITHOUT IT, NOTHING WORKS.

        return app.mount(el);
    },
    progress: {
        color: '#00704A', // Starbucks green
        showSpinner: false, // We have our own loading indicator
    },
});