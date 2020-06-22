<template>
    <div class="col mb-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ good.name }}</h5>
            </div>
            <div class="card-footer">
                <button v-if="inBox" @click.prevent="removeFromCart" class="btn btn-primary float-right">
                    REMOVE FROM CART
                </button>
                <button v-else @click.prevent="addToCart" class="btn btn-primary float-right">
                    {{ good.price }} $
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapActions} from "vuex";

    export default {
        name: 'Good',
        props: {
            good: {
                type: Object,
                required: true
            },
            inBox: false
        },
        methods: {
            addToCart() {
                this.$store.dispatch('CART_ADD', this.good);
            },
            removeFromCart() {
                this.$store.dispatch('CART_REMOVE', this.good);
            }
        }
    }
</script>