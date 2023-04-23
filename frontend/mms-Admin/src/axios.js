import axios from "axios"

axios.defaults.withCredentials = false
axios.defaults.baseURL = "https://mms-api.algoskech.co.ke" 
axios.defaults.headers['Accept'] = 'application/json';
axios.defaults.headers['Content-Type'] = 'application/json';
axios.defaults.headers['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.headers.common = {'Authorization': `Bearer ${localStorage.getItem('token')}`}