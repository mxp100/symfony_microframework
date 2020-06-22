<template>
    <div>
        <Navbar/>
        <div class="container">
            <Catalog></Catalog>
        </div>
    </div>
</template>

<script>
    import Catalog from "./Catalog";
    import Navbar from "./Navbar";

    export default {
        name: 'Application',
        components: {Navbar, Catalog},
        data() {
            return {};
        },
        mounted() {
        },
        methods: {}
    }
</script>