<template>
    <div class="col mb-4 card-deck">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ good.name }}</h5>
            </div>
            <div class="card-footer">
                <button v-if="inBox" @click.prevent="removeFromCart" class="btn btn-warning float-right">
                    REMOVE
                </button>
                <button v-else @click.prevent="addToCart" class="btn btn-primary float-right">
                    {{ good.price }} $
                </button>
            </div>
        </div>
    </div>
</template>
<script>
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