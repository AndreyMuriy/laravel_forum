<template>
    <div v-if="signedIn">
        <div class="form-group mt-3">
        <textarea id="body"
                  name="body"
                  class="form-control"
                  placeholder="Have something to say?"
                  rows="5"
                  required
                  v-model="body"></textarea>

            <button type="submit"
                    class="btn btn-primary mt-3"
                    @click="addReply">Post
            </button>
        </div>
    </div>
    <p class="text-center" v-else>Please <a href="/login">sign in</a> to participate in this
        discussion</p>
</template>

<script>
    import 'at.js';
    import 'jquery.caret';

    export default {
        data() {
            return {
                body: ''
            }
        },

        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },

        mounted() {
            $('#body').atwho({
                at: '@',
                delay: 500,
                callbacks: {
                    remoteFilter: function(query, callback) {
                        $.getJSON('/api/users', {name: query}, function (usernames) {
                            callback(usernames);
                        });
                    }
                }
            });
        },

        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', { body: this.body })
                    .catch(error => {
                        flash(error.response.data, 'danger')
                    })
                    .then(({ data }) => {
                        this.body = '';

                        flash('Your reply has been posted.');

                        this.$emit('created', data);
                    });
            }
        }
    }
</script>
