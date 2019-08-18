require('./bootstrap');

window.Vue = require('vue');

import iosAlertView from 'vue-ios-alertview';
Vue.use(iosAlertView);

import UsersComponent from './components/UsersComponent';
import ProfileComponent from './components/ProfileComponent';
import AdduserComponent from './components/AdduserComponent';
Vue.component('users-component', UsersComponent);
Vue.component('profile-component', ProfileComponent);
Vue.component('adduser-component', AdduserComponent);

const app = new Vue({
    el: '#app',
    data() {
        return {
            user: AuthUser
        }
    },
    methods: {
        MakeUrl(path) {
            return BaseUrl(path);
        }
    }
});
