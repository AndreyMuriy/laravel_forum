<template>
    <li class=" nav-item dropdown" v-if="notifications.length">
        <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown">
            <i class="fas fa-bell"></i>
        </a>

        <ul class="dropdown-menu">
            <li class="dropdown-item" v-for="notification in notifications">
                <a :href="notification.data.link"
                   v-text="notification.data.message"
                   @click="markAsRead(notification)"
                ></a>
            </li>
        </ul>
    </li>
</template>

<script>
    export default {
        data() {
            return {
                notifications: false
            }
        },

        created() {
            axios.get('/profiles/' + window.App.user.name + '/notifications')
                .then(response => this.notifications = response.data)
                .catch(error => console.log(error));
        },

        methods: {
            markAsRead(notification) {
                axios.delete('/profiles/' + window.App.user.name + '/notifications/' + notification.id);
            }
        }
    }
</script>
