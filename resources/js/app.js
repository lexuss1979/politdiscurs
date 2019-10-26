/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import vClickOutside from 'v-click-outside';
Vue.use(vClickOutside);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import AdvancedSelect from './components/AdvancedSelect.vue';
import CheckBox from './components/CheckBox.vue';
import SearchInput from './components/SearchInput.vue';
import MainMenu from './components/MainMenu.vue';
import TopicFilters from './components/TopicFilters.vue';
import BookFilter from './components/BookFilter.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    components:{BookFilter, MainMenu, AdvancedSelect, CheckBox, SearchInput, TopicFilters},
    methods:{
        doSearch(searchStr) {
            window.location.href='/search?q='+searchStr;
        }
    }
});
