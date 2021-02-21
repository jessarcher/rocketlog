require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import { InertiaProgress } from '@inertiajs/progress'
import PortalVue from 'portal-vue';
import dayjs from 'dayjs';
import utc from 'dayjs/plugin/utc';

InertiaProgress.init({
    color: '#8B5CF6',
})

dayjs.extend(utc);

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
Vue.mixin({ methods: {
    date(date) {
        return dayjs.utc(date);
    }
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
