import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const apiClient = axios.create({
    baseURL: `${import.meta.env.VITE_APP_URL}/api`,
    withCredentials: true,
    headers:{
        'X-Requested-With': 'XMLHttpRequest',
    },
});

const getCsrfToken = async () => {
    await axios.get('/sanctum/csrf-cookie');
};

export { apiClient, getCsrfToken };