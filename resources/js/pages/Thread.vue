<script>
    import Replies from '../components/Replies';

    export default {
        props: ['data'],

        components: { Replies },

        data() {
            return {
                repliesCount: this.data.replies_count
            }
        }
    }
</script>
