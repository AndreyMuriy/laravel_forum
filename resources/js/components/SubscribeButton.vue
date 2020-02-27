<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        props: ['active'],

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-light' : 'btn-primary'];
            }
        },

        methods: {
            subscribe() {
                const method = this.active ? 'delete' : 'post';
                axios[method](location.pathname + '/subscriptions');
                this.active = ! this.active;
            }
        }
    }
</script>
