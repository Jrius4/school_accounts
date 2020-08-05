/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

import router from "./router";
import App from "./components/App";
// import Dashboard from './components/user/Dashboard.vue'
import { RestDataSource } from "./restDataSource/RestDataSource";
import store from "./store";
window.Vue = require("vue");
import Vuelidate from "vuelidate";
// import VueNativeStock from 'vue-native-websocket';

// Vue.use(VueNativeStock,'ws://schools.dev.com/8090', {
//    store:store,
//    format:'json'
//   });
Vue.use(Vuelidate);

import "animate.css/animate.min.css";
import "popmotion/dist/popmotion.global.min.js";
import Colorize from "./components/simple/directives/colorize";
import mixin from "./components/simple/mixins/numbersMixin";

import MathPlugin from "./plugins/maths";

import moment from "moment";
Vue.use(moment);

Vue.directive("colorize", Colorize);
Vue.mixin(mixin);
Vue.config.productionTip = true;
Vue.config.devtools = true;
Vue.use(MathPlugin);
let token = null;
token = localStorage.getItem("access_token");

// console.log({token})

if (token !== null) {
    store
        .dispatch("getUserTokenAcion")
        .then(response => {})
        .catch(err => {
            console.error(err);
        });
} else if (token === null) {
    console.log({ token });
}

import VueHtmlToPaper from "vue-html-to-paper";

const options = {
    name: "_blank",
    specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
    styles: [
        "./assets/pdf/bootstrap.css",
        "./assets/pdf/kidlat.css",
        "./assets/pdf/custom.css"
    ]
};

Vue.use(VueHtmlToPaper, options);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component(
//     'passport-clients',require('./components/passport/Clients.vue').default
// );
// Vue.component(
//     'passport-authorized-clients',require('./components/passport/AuthorizedClients.vue').default
// );
// Vue.component(
//     'passport-personal-access-tokens',require('./components/passport/PersonalAccessTokens.vue').default
// );

import vSelect from "vue-select";

Vue.component("v-select-field", vSelect);
Vue.component(
    "search-student",
    require("./components/admin/SearchStudent.vue").default
);
Vue.component("burser", require("./components/burser/burser.vue").default);
Vue.component(
    "make-expense-component",
    require("./components/burser/expenses/MakeExpense.vue").default
);

Vue.component("app-component", require("./components/App").default);
Vue.component(
    "dashboard-component",
    require("./components/user/Dashboard.vue").default
);
Vue.component(
    "user-dashboard-component",
    require("./components/user/UserDashboard.vue").default
);
Vue.component("test-pdf", require("./components/pdf/Test.vue").default);

Vue.component(
    "notification-bar",
    require("./components/common/NotificationBar.vue").default
);
Vue.component(
    "chat-room",
    require("./components/chatRoom/ChatRoom.vue").default
);
Vue.component(
    "make-expense",
    require("./components/burser/expenses/MakeExpense.vue").default
);
Vue.component(
    "selectfield-component",
    require("./components/common/SelectField.vue").default
);
//Vue.component('employees-component',require('./components/employees/search/Employees.vue').default);
Vue.component(
    "comment-component",
    require("./components/common/Comments.vue").default
);
// EmployeeSalary
Vue.component(
    "employee-salary",
    require("./components/headmaster/Salarys.vue").default
);
Vue.component(
    "upload-files",
    require("./components/common/UploadFiles.vue").default
);
// tasks
Vue.component(
    "task-calendar",
    require("./components/tasks/TaskCalendar.vue").default
);
// resources\js\components\super-admin\SuperAdmin.vue
Vue.component(
    "accounts-index",
    require("./components/accounts/AccountsIndex.vue").default
);
Vue.component(
    "super-admin",
    require("./components/super-admin/SuperAdmin.vue").default
);
Vue.component(
    "make-payment",
    require("./components/payments/MakePayment.vue").default
);
Vue.component(
    "view-payments",
    require("./components/payments/ViewPayments.vue").default
);
Vue.component(
    "view-expenses",
    require("./components/expenses/ViewExpenses.vue").default
);
Vue.component(
    "payments-overview",
    require("./components/income/PaymentsView.vue").default
);
Vue.component(
    "expenses-overview",
    require("./components/income/ExpensesView.vue").default
);
Vue.component(
    "overview-reports",
    require("./components/income/Overview.vue").default
);
Vue.component(
    "payments-graph",
    require("./components/financialGraphs/PaymentsGraph.vue").default
);
Vue.component(
    "expenses-graph",
    require("./components/financialGraphs/ExpensesGraph.vue").default
);
Vue.component(
    "income-statements-graph",
    require("./components/financialGraphs/IncomeStatementsCharts.vue").default
);
Vue.component(
    "financial-graphs",
    require("./components/financialGraphs/FinancialGraphs.vue").default
);
Vue.component(
    "ModalItem",
    require("./components/common/ModalItem.vue").default
);

import VueTextareaAutosize from "vue-textarea-autosize";

Vue.use(VueTextareaAutosize);

import VueChatScroll from "vue-chat-scroll";
// import { not } from 'vuelidate/lib/validators';
Vue.use(VueChatScroll);
/*
var notification = [];
const NOTIFICATION_TYPES = {
    follow:'App\\Notifications\\UserFollowed',
    newPost:'App\\Notifications\\NewPost',
}

$(document).ready(function() {
    // check if there's a logged in user
    if(Laravel.userId) {
        $.get('/follows/notifications', function (data) {

            addNotifications(data, "#notifications");

            Echo.private(`App.User.${Laravel.userId}`)
            .notification((notification) => {
                console.log({notification})
                addNotifications([notification], '#notifications');
            });
        });
    }
});

function addNotifications(newNotifications, target) {
    notifications = _.concat(notifications, newNotifications);
    // show only last 5 notifications
    notifications.slice(0, 5);
    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {

    if(notifications.length>1) {

        var htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $(target + 'Menu').html(htmlElements.join(''));
        $(target).addClass('has-notifications')
    }

    else {
        $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
        $(target).removeClass('has-notifications');
    }
}
// Make a single notification string
function makeNotification(notification) {
    var to = routeNotification(notification);
    var notificationText = makeNotificationText(notification);
    return '<li><a href="' + to + '">' + notificationText + '</a></li>';
}

// get the notification route based on it's type
function routeNotification(notification) {
    var to = `?read=${notification.id}`;
    if(notification.type === NOTIFICATION_TYPES.follow) {
        const userId = notification.data.follower_id;
        to = `follows/users/${userId}` + to;
    } else if(notification.type === NOTIFICATION_TYPES.newPost) {
        const postId = notification.data.post_id;
        to = `follows/comments/${postId}` + to;
    }
    return '/' + to;
}

function makeNotificationText(notification) {
    var text = '';
    if(notification.type === NOTIFICATION_TYPES.follow) {
        const name = notification.data.follower_name;
        text += `<strong>${name}</strong> followed you`;
    } else if(notification.type === NOTIFICATION_TYPES.newPost) {
        const name = notification.data.following_name;
        text += `<strong>${name}</strong> published a post`;
    }
    return text;
}
**/
import vuetify from "./plugins/vuetify";
import "./plugins/base";
import "./plugins/echarts";
import "./plugins/chartist";
import "./plugins/vee-validate";
import uuid from "./plugins/uuid";

export default new Vue({
    router,
    vuetify,
    // render:h =>h(App),
    data: {
        eventBus: new Vue(),
        uuid
    },
    store,
    provide: function() {
        return {
            eventBus: this.eventBus,
            restDataSource: new RestDataSource(this.eventBus)
        };
    }
}).$mount("#app");
