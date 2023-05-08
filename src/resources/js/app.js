


import './bootstrap';

import Alpine from 'alpinejs';

import Vue from 'vue';
import VueStarRating from 'vue-star-rating';

Vue.component('VueStarRating', VueStarRating);

const app = new Vue({
    el: '#app',
});


window.Alpine = Alpine;

Alpine.start();
