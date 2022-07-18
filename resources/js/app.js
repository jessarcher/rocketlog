import './bootstrap';

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress'
import PortalVue from 'portal-vue';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';
import * as Sentry from '@sentry/vue';
import {Integrations} from '@sentry/tracing';
import { Inertia } from '@inertiajs/inertia';

Sentry.init({
    Vue,
    dsn: import.meta.env.VITE_SENTRY_VUE_DSN,
    integrations: [new Integrations.BrowserTracing()],

    // We recommend adjusting this value in production, or using tracesSampler
    // for finer control
    tracesSampleRate: 1.0,

    logErrors: true,
});

InertiaProgress.init({
    color: '#8B5CF6',
})

dayjs.extend(utc);

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.mixin({ methods: {
    $utc(date) {
        return dayjs.utc(date)
    },
    $date(date) {
        return dayjs(date)
    },
    $today() {
        return dayjs().startOf('day')
    },
}});

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);

Inertia.on('navigate', () => {
    if (typeof window.fathom !== 'undefined') {
        window.fathom.trackPageview();
    }
});
