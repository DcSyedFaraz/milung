<template>
    <div class="row">
        <div class="col-md-6 offset-md-3 notifications-container">
            <div class="notifications-header">
                Notifications
                <span class="badge bg-primary rounded-pill">{{ unreadNotificationsCount }}</span>
            </div>
            <div class="notifications-list">
                <div class="card shadow-sm" v-for="notification in notifications" :key="notification.id" >
                    <div class="card-body" >
                        <div class="notification-item p-4" :class="notificationItemClass(notification)">
                            <i class="fs-8 bi bi-exclamation-circle" :class="iconClass(notification)" v-if="!notification.read_at"></i>
                            <i class="fs-8 bi bi-check-circle text-success" v-else></i>
                            <div @click="handleNotificationClick(notification)" style="cursor: pointer;">
                                <strong class="text-black">{{ notification.type }}</strong>
                                <p :class="messageClass(notification)">{{ notification.data.message }}</p>
                                <p class="fst-italic" :class="buttonClass(notification)">{{ formatCreatedAt(notification.created_at) }}</p>
                            </div>
                            <button class="btn btn-link " :class="buttonClass(notification)" v-if="!notification.read_at"
                                @click="markAsRead(notification.id)" title="Mark as read"> <i
                                    class="bi bi-check-circle"></i> Mark as read</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
import toastrs from 'toastr';

export default {

    data() {
        return {
            notifications: [],
        };
    },
    computed: {
        unreadNotificationsCount() {
            return this.notifications.filter(notification => !notification.read_at).length;
        },
    },
    created() {
        // Get the notifications from the database
        this.fetchNotifications();

        // Listen for new notifications
        //   Echo.private('user.' + this.userId)
        //    .listen('NewNotification', (e) => {
        //       if (e.notification.type === 'Post') {
        //         toastr.success(e.notification.message);

        //         // Add the new notification to the list
        //         this.notifications.unshift(e.notification);
        //       }
        //     });
    },
    methods: {
        notificationItemClass(notification) {
            return {
                'bg-danger text-white': this.isCriticalNotification(notification.type)
            };
        },
        iconClass(notification) {
            return {
                'text-white': this.isCriticalNotification(notification.type),
                'text-warning': !this.isCriticalNotification(notification.type)
            };
        },
        messageClass(notification) {
            return {
                'text-white': this.isCriticalNotification(notification.type)
            };
        },
        buttonClass(notification) {
            return {
                'text-white': this.isCriticalNotification(notification.type),
                'text-secondary': !this.isCriticalNotification(notification.type)
            };
        },
        isCriticalNotification(type) {
            return ['Price Inquiry Follow Up', 'Account Payable-Payment Reminder', 'Forgot Password', 'New Order', 'New Order Price Inquiry', 'New Price Inquiry'].includes(type);
        },
        handleNotificationClick(notification) {
            const route = notification.data.route;
            const params = notification.data.routeParams || {};
            if (route) {
                this.$router.push({ name: route, params: params });
            } else {
                toastrs.error('No route information found for this notification.');
            }
        },
        fetchNotifications() {
            axios.get('/api/all-notifications').then((response) => {
                this.notifications = response.data.msg;
                console.log('dd', this.notifications);
            });
        },
        formatCreatedAt(createdAt) {
            return moment(createdAt).fromNow();
        },
        markAsRead(notificationId) {
            // Send a PATCH request to the Laravel backend to mark the notification as read
            axios.post('/api/notifications/' + notificationId)
                .then(response => {
                    // Remove the notification from the list
                    this.fetchNotifications();
                    toastrs.success(response.data.message);
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
}
</script>

<style scoped>
.notifications-container {
    width: 600px;
    color: #000;
    padding: 30px;
    margin: 30px auto;
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.fs-8 {
    font-size: 55px;
}

.notifications-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.notifications-list {
    display: flex;
    flex-direction: column;

}

.notification-item {
    display: flex;
    align-items: center;
    gap: 20px;
    text-align: left;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
    margin-bottom: 10px;
}
</style>
