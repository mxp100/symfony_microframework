<template>
    <div>
        <div class="modal d-block" v-if="this.show" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content" v-click-outside="hideModal">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pay</h5>
                        <button type="button" class="close" aria-label="Close" @click="hideModal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div v-if="error" class="alert alert-danger">
                            {{ error }}
                        </div>
                        <input v-model="sum" class="form-control">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="hideModal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" @click="pay">
                            PAY
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show" v-if="this.show"></div>
    </div>
</template>

<script>
    import vClickOutside from "v-click-outside";

    export default {
        name: "ModalPayment",
        directives: {
            clickOutside: vClickOutside.directive
        },
        data() {
            return {
                error: false,
                show: false,
                orderId: null,
                sum: 0
            }
        },
        methods: {
            async pay() {
                try {
                    await axios.post('/api/orders/' + this.orderId + '/pay', {
                        sum: this.sum
                    })

                    this.error = false;
                    this.hideModal();
                } catch (e) {
                    this.error = e.response.data.error;
                }
            },
            showModal(orderId) {
                console.log(orderId);
                this.orderId = orderId;
                this.show = true;
            },
            hideModal() {
                this.show = false;
            }
        },
    }
</script>

<style scoped>

</style>