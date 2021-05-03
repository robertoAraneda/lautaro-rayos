import store from '../store';
import fetch from '../services/fetch';

store.subscribe(mutation => {
    switch (mutation.type) {
        case 'auth/SET_ACCESS_TOKEN':
            if (mutation.payload) {
                localStorage.setItem('access_token', mutation.payload);
                fetch.Authorization = `Bearer ${localStorage.getItem(
                    'access_token'
                )}`;
            } else {
                localStorage.removeItem('access_token');
            }
            break;
    }
});
