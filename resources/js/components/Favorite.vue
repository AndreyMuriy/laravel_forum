<template>
    <button :class="classes" type="submit" @click="toggle">
        <span class="far fa-heart"></span>
        <span v-text="count"></span>
    </button>
</template>

<script>
    export default {
        props: ['reply'],

        data() {
            return {
                count: this.reply.favoritesCount,
                active: this.reply.isFavorited
            }
        },

        computed: {
            classes() {
                return ['btn', this.active ? 'btn-primary' : 'btn-default'];
            },

            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },

        methods: {
            toggle() {
                this.active ? this.delete() : this.create();
                this.active = !this.active;
            },

            create() {
                axios.post(this.endpoint);
                this.count++;
            },

            delete() {
                axios.delete(this.endpoint);
                this.count--;
            }
        }
    }
</script>
