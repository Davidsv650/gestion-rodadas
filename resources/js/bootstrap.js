import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

/**
 * Axios
 */
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

document.addEventListener('DOMContentLoaded', () => {
    const dropdownElementList = document.querySelectorAll('.dropdown-toggle');

    dropdownElementList.forEach(el => {
        new bootstrap.Dropdown(el);
    });
});