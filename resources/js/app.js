import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/index.js'

const appName = document.querySelector('meta[name="app-name"]')?.content ?? 'RocketLog'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    progress: { color: '#8B5CF6' },
    setup({ el, App, props, plugin }) {
        const vue = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)

        Sentry.init({
            vue,
            dsn: import.meta.env.VITE_SENTRY_VUE_DSN,
            integrations: [new Integrations.BrowserTracing()],

            // We recommend adjusting this value in production, or using tracesSampler
            // for finer control
            tracesSampleRate: 1.0,

            logErrors: true,
        });

        vue.mount(el);

        return vue;
    },
})

router.on('navigate', () => {
    if (typeof window.fathom !== 'undefined') {
        window.fathom.trackPageview();
    }
});
