<template>
    <div class="row row-cols-1 row-cols-md-3">
        <Good v-for="good in goods" v-bind:key="good.id" v-bind:good="good" v-bind:in-box="CART_IDS.includes(good.id)"/>
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
                'CART_IDS'
            ]),
        },
        data() {
            return {
                goods: [],
                offset: 0,
                limit: 100,
            };
        },
        mounted() {
            this.loadGood()
            this.scrollBind();
        },
        beforeDestroy() {
            this.scrollUnbind();
        },
        methods: {
            scrollBind() {
                window.addEventListener('scroll', this.scroll)
            },
            scrollUnbind() {
                window.removeEventListener('scroll', this.scroll);
            },
            scroll() {
                let bottomOfWindow = Math.max(window.pageYOffset, document.documentElement.scrollTop, document.body.scrollTop) + window.innerHeight === document.documentElement.offsetHeight

                if (bottomOfWindow) {
                    this.offset += this.limit;
                    this.loadGood()
                }
            },
            async loadGood() {
                let {data} = await axios.get('/api/goods', {
                    params: {
                        offset: this.offset,
                        limit: this.limit
                    }
                });
                this.goods.push(...data.goods);
                if (this.goods.length === data.total) {
                    this.scrollUnbind()
                }
            }
        }
    }
</script>