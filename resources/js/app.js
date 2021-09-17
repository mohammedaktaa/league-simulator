require('./bootstrap');
require('bootstrap/dist/js/bootstrap');
import Vue from 'vue/dist/vue.js';

Vue.prototype.$axios = window.axios;

Vue.filter("ordinal", function (number) {
    switch (number) {
        case 1:
            return 'st';
        case 2:
            return 'nd';
        case 3:
            return 'rd';
        default:
            return 'th'
    }

    return moment(date).format("dd mm YYYY");
});

window.Vue = Vue;
