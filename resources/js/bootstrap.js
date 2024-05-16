import axios from 'axios';
import _ from 'lodash';
import Popper from 'popper.js';
import jquery from 'jquery';
import bootstrap from 'bootstrap';
import datatables from 'datatables.net-bs4';

try {
    window._ = _;
    window.axios = axios;
    window.Popper = Popper;
    window.$ = window.jQuery = jquery;

} catch (e) {}

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
