import Vue from 'vue';
import Vuex from 'vuex';
import VuexPersist from 'vuex-persist'
import cart from './modules/cart';

Vue.use(Vuex);

const vuexPersist = new VuexPersist({
    key: 'test-app',
    storage: window.sessionStorage
})

export const store = new Vuex.Store({
    state: {},
    getters: {},
    mutations: {},
    actions: {},
    modules: {
        cart
    },
    plugins: [vuexPersist.plugin]
});