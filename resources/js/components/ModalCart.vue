<template>
    <div>
        <div class="modal d-block" v-if="this.show" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-click-outside="hideModal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cart</h5>
                        <button type="button" class="close" aria-label="Close" @click="hideModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-hover table-striped" v-if="CART.length">
                            <thead>
                            <tr>
                                <th class="col">Item</th>
                                <th class="col">Price</th>
                                <th class="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="good in CART">
                                <td scope="row">{{ good.name }}</td>
                                <td>{{ good.price }}$</td>
                                <td><button class="btn btn-danger d-inline" @click="removeFromCart(good)">&times;</button></td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">Total: {{ CART_TOTAL }}$</td>
                            </tr>
                            </tfoot>
                        </table>
                        <h3 v-else>Empty cart</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="hideModal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" @click="sendOrder" v-if="CART.length">
                            Send order
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-if="this.show"></div>
    </div>
</template>
<script>
    import vClickOutside from 'v-click-outside'
    import {mapGetters} from "vuex";

    export default {
        name: 'ModalCart',
        directives: {
            clickOutside: vClickOutside.directive
        },
        computed: {
            ...mapGetters([
                'CART',
                'CART_TOTAL',
            ])
        },
        data() {
            return {
                show: false,
            }
        },
        methods: {
            async sendOrder() {
                let {data} = await axios.post('/api/orders', {
                    good_ids: _.map(this.CART, 'id')
                });
                await this.$store.dispatch('CART_CLEAR');

                this.hideModal();
                this.$parent.$refs.modalPayment.showModal(data.order_id);
            },
            removeFromCart(good) {
                this.$store.dispatch('CART_REMOVE', good);
            },
            showModal() {
                this.show = true;
            },
            hideModal() {
                this.show = false;
            }
        },
    }
</script>