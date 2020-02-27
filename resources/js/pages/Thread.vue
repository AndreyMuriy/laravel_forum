<script>
    import Replies from '../components/Replies';
    import SubscribeButton from '../components/SubscribeButton';

    export default {
        props: ['data'],

        components: { Replies, SubscribeButton },

        data() {
            return {
                repliesCount: this.data.replies_count
            }
        }
    }
</script>
