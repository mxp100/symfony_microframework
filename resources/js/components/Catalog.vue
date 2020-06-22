<template>
    <div class="row row-cols-1 row-cols-md-3">
        <Good v-for="good in GOODS" v-bind:key="good.id" v-bind:good="good" v-bind:in-box="CART_IDS.includes(good.id)"/>
    </div>
</template>

<script>
    import Good from "./Good";
    import {mapGetters} from "vuex";

    export default {
        name: 'Catalog',
        components: {
            Good
        },
        computed: {
            ...mapGetters([
                'GOODS',
                'CART_IDS'
            ]),
        },
        data() {
            return {};
        },
        mounted() {
            this.$store.dispatch('GET_GOODS');
        },
        methods: {}
    }
</script>