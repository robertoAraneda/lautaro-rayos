import store from '../store';

store.subscribe(mutation => {
    console.log(mutation);
    switch (mutation.type) {
        case 'auth/SET_ACCESS_TOKEN':
            if (mutation.payload) {
                localStorage.setItem('access_token', mutation.payload);
            } else {
                axios.defaults.headers.common['Authorization'] = null;
                localStorage.removeItem('access_token');
            }
            break;
    }
});
