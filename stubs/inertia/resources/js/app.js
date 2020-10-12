require('./bootstrap');
import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';

import {Ziggy} from './route';
import route from '../../vendor/tightenco/ziggy/src/js/route';
import LaravelPermission from 'laravel-permission';

Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(LaravelPermission);
Vue.mixin({
    methods: {
        route: function ( name, params, absolute ) { return route(name, params, absolute, Ziggy); }
    }
});

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

