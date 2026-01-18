import Axios from 'axios';

export const client = Axios.create({
    baseURL: process.env.EXPO_PUBLIC_SERVER_URL,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true,
    withXSRFToken: true,
});
