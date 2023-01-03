import axios from 'axios';

window.api = axios.create({
    baseURL: '//' + window.location.hostname + '/api/',
});

window.api.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.api.defaults.withCredentials = true;