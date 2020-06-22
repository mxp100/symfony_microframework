require('./bootstrap');

import Vue from 'vue';
import {store} from './store';
import Application from './components/Application';

new Vue({
    el: '#app',
    store,
    components: {
        Application,
    }
});
