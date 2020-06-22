<template>
    <nav class="navbar fixed-top navbar-light bg-light">
        <a class="navbar-brand" href="#">CATALOG</a>
        <span class="navbar-text">
            <button class="btn btn-primary" @click.prevent="showCart">CART ({{ CART_COUNT }})</button>
        </span>
        <ModalCart ref="modalCart"/>
        <ModalPayment ref="modalPayment"/>
    </nav>
</template>
<script>
    import {mapGetters} from "vuex";
    import ModalCart from "./ModalCart";
    import ModalPayment from "./ModalPayment";

    export default {
        name: 'Navbar',
        components: {ModalPayment, ModalCart},
        computed: {
            ...mapGetters([
                'CART_COUNT'
            ])
        },
        methods: {
            showCart() {
                this.$refs.modalCart.showModal();
            }
        }
    }
</script>