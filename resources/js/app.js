require('./bootstrap');

import Vue from 'vue';
import {BootstrapVue, IconsPlugin} from 'bootstrap-vue';
import Application from './components/Application';

new Vue({
    el: '#app',
    components: {
        Application,
        BootstrapVue,
        IconsPlugin
    }
});
