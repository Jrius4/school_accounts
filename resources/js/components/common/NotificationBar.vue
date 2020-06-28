<template>
        <div>
            <a class="nav-link" href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="far fa-bell"></i>
                <span class="badge badge-warning navbar-badge">{{numberNotification}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right animated flipInX" aria-labelledby="notificationsMenu" id="notificationsMenu"

            >
                <li id="Elements" v-for="(htmlElement,index) in htmlElements" :key="index">
                    <div  v-html="htmlElement"></div>
                </li>
                <li class="dropdown-divider"></li>
                <li>
                    <a href="/all-notifications" class="dropdown-item dropdown-footer">See All Notifications</a>
                </li>

                <!-- <li class="dropdown-header">No notifications</li> -->
            </ul>
        </div>
</template>

<script>

    export default {

        data(){
            return{
                notifications:[],
                NOTIFICATION_TYPES:{
                    follow:'App\\Notifications\\UserFollowed',
                    newPost:'App\\Notifications\\NewPost',
                },
                htmlElements:[],
                numberNotification:'',
            }
        },

        mounted(){
            this.getNotifications();
            this.listen();
        },

        computed:{

        },

        methods:{
            getNotifications(){
                axios.get('/follows/notifications').then((result) => {
                        this.notifications = result.data.data;
                        this.numberNotification = result.data.total;
                        var notifications = this.notifications;
                        if(notifications.length>0){
                            let classes = ["has-notifications"];
                            var element = this.$el.querySelector('#notifications')
                            element.classList.add(...classes)
                            var htmlElements = notifications.map((notification)=>{
                                return this.makeNotification(notification);
                            });

                            this.htmlElements = htmlElements;
                            // document.querySelector('#Elements').appendChild(htmlElements)
                        }

                        else{
                            let classes = ["has-notifications"];
                            var element = this.$el.querySelector('#notifications')
                            element.classList.remove(...classes)
                              var  htmlElements = '<div class="dropdown-divider"></div> <li><a href="#" class="dropdown-item">No notifications</a></li>';
                              this.htmlElements = [];
                              this.htmlElements.push(htmlElements);
                            //  document.querySelector('#Elements').appendChild(htmlElements)
                        }



                }).catch((err) => {
                    console.log(err)
                });
            },
            listen(){
                // if(Laravel.following_admin){
                    console.log({Laravel});
                Echo.private('new-notification.'+Laravel.userId)
                .listen('NotificationEvent',(notifications)=>{
                    console.log(notifications);
                    var notifications = {...notifications}[0];
                    console.log({notifications});

                    this.notifications = notifications.data;
                    this.numberNotification = notifications.total;
                    notifications = this.notifications

                    if(notifications.length>0){
                            let classes = ["has-notifications"];
                            var element = this.$el.querySelector('#notifications')
                            element.classList.add(...classes)
                            var htmlElements = notifications.map((notification)=>{
                                return this.makeNotification(notification);
                            });

                            this.htmlElements = htmlElements;
                            // document.querySelector('#Elements').appendChild(htmlElements)
                        }

                        else{
                            let classes = ["has-notifications"];
                            var element = this.$el.querySelector('#notifications')
                            element.classList.remove(...classes)
                              var  htmlElements = '<div class="dropdown-divider"></div> <li><a href="#" class="dropdown-item">No notifications</a></li>';
                              this.htmlElements = [];
                              this.htmlElements.push(htmlElements);
                            //  document.querySelector('#Elements').appendChild(htmlElements)
                        }


                });
                // }
            },

            makeNotification(notification) {
                var to = this.routeNotification(notification);
                var notificationText = this.makeNotificationText(notification);
                var dataText = {
                    to:to,notificationText:notificationText
                }
                return '<div class="dropdown-divider"></div> <li><a href="' + to + '" class="dropdown-item"><i class="fas fa-file mr-2"></i> ' + notificationText + '</a></li>';
                // return dataText;
            },

            routeNotification(notification) {
                var to = `?read=${notification.id}`;
                if(notification.type === this.NOTIFICATION_TYPES.follow) {
                    const userId = notification.data.follower_id;
                    to = `follows/users/${userId}` + to;
                } else if(notification.type === this.NOTIFICATION_TYPES.newPost) {
                    const postId = notification.data.post_id;
                    to = `follows/comments/${postId}` + to;
                }
                return '/' + to;
            },

            makeNotificationText(notification) {
            var text = '';
            if(notification.type === this.NOTIFICATION_TYPES.follow) {
                const name = notification.data.follower_name;
                text += `<strong>${name}</strong> followed you`;
            } else if(notification.type === this.NOTIFICATION_TYPES.newPost) {
                const name = notification.data.following_name;
                text += `<strong>${name}</strong> published a post`;
            }
            return text;
        }



        }

    }
</script>

<style lang="scss" scoped>

</style>
