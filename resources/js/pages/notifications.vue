<template>

    <li class="nav-item dropdown">
        <a class="nav-link nav-icon pe-0 me-0" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge badge-number" v-if="count > 0">{{ count }}</span> </a><!-- End Notification Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
                You have {{ count }} unread notifications
                <router-link :to="generateNotificationRoute"><span class="badge rounded-pill bg-primary p-2 ms-2">View
                        all</span></router-link>
            </li>
            <!-- <li>
                <hr class="dropdown-divider" />
            </li>

            <li class="notification-item">
                <i class="bi bi-exclamation-circle text-warning"></i>
                <div>
                    <h4>Lorem Ipsum</h4>
                    <p>Quae dolorem earum veritatis oditseno</p>
                    <p>30 min. ago</p>
                </div>
            </li> -->
            <template v-for="notification in notifications" :key="notification.id">

                <li class="notification-item" :class="notificationItemClass(notification)">
                    <i class="bi bi-exclamation-circle" :class="iconClass(notification)"></i>
                    <div @click="handleNotificationClick(notification)" style="cursor: pointer;">
                        <strong>{{ notification.type }}</strong>
                        <p :class="messageClass(notification)">{{ notification.data['message'] }}</p>
                        <p class="fst-italic" :class="buttonClass(notification)">{{
                formatCreatedAt(notification.created_at) }}</p>
                    </div>
                    <hr class="dropdown-divider" />
                    <button class="btn btn-link d-flex align-items-center justify-content-end" title="Mark as read"
                        data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Tooltip on top"
                        @click="markAsRead(notification.id)" :class="buttonClass(notification)">
                        <i class="bi bi-check-circle"></i>
                    </button>
                </li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
            </template>


            <li class="dropdown-footer">
                <router-link :to="generateNotificationRoute">Show all notifications</router-link>
            </li>
        </ul>
        <!-- End Notification Dropdown Items -->
    </li>




    <!-- <div v-for="notification in notifications" :key="notification.id" class="notification">
            <strong>{{ notification.title }}</strong>
            <p>{{ notification.message }}</p>
        </div> -->
</template>

<script>
// import axios from 'axios';
import toastrs from 'toastr';
import Echo from 'laravel-echo';
import moment from 'moment';

export default {
    data() {
        return {
            notifications: [],
            count: '',
            interval: {},
        };
    },
    mounted() {

        this.fetchNotifications();
        this.interval.value = setInterval(() => {
            // console.log('notification fetched.');
            this.fetchNotifications();
        }, 30000);


    },
    beforeUnmount() {
        console.log('done');
        clearInterval(this.interval.value);
    },
    computed: {
        generateNotificationRoute() {
            console.log('User role:', this.$store.state.userRole);
            switch (this.$store.state.userRole) {
                case 'Admin':
                    return { name: 'adminAllNotifications' };
                case 'Internal':
                    return { name: 'adminAllNotifications' };
                case 'Buyer':
                    return { name: 'buyerAllNotifications' };
                case 'Supplier':
                    return { name: 'supplierAllNotifications' };
                default:
                    // Default route if the user role doesn't match any case
                    return { name: 'allnotifications' };
            }
        },
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
            return ['Price Inquiry Follow Up', 'Account Payable-Payment Reminder', 'Forgot Password','New Order','New Order Price Inquiry','New Price Inquiry'].includes(type);
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
        formatCreatedAt(createdAt) {
            return moment(createdAt).fromNow();
        },
        fetchNotifications() {
            axios.get('/api/notifications').then((response) => {
                this.notifications = response.data.msg;
                this.count = response.data.count;
                // console.log(this.notifications, this.count);
            });
        },
        markAsRead(notification) {
            axios.post(`/api/notifications/${notification}`)
                .then((response) => {
                    this.fetchNotifications();
                    console.log(response.data.message);
                    toastrs.success(response.data.message);
                });
        },
    },
};
</script>

<style>
.notification {
    background-color: #f9f9f9;
    border: 1px solid #ddd;
    margin-bottom: 10px;
    padding: 10px;
    border-radius: 5px;
}
</style>
