import './bootstrap'
import '../css/app.css'

import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { InertiaProgress } from '@inertiajs/progress'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import * as Sentry from '@sentry/vue';
import { Integrations } from '@sentry/tracing';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m'

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        const vue = createApp({ render: () => h(app, props) })
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

InertiaProgress.init({ color: '#8B5CF6' })

Inertia.on('navigate', () => {
    if (typeof window.fathom !== 'undefined') {
        window.fathom.trackPageview();
    }
});
