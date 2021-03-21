const BASE_URL = '/api/auth';

export default {
    namespaced: true,
    state: {
        loginUser: null,
        access_token: null,
    },
    mutations: {
        SET_LOGIN_USER: (state, user) => {
            if (user !== null) {
                state.loginUser = Object.assign({}, user);
            } else {
                state.loginUser = user;
            }
        },
        SET_ACCESS_TOKEN: (state, access_token) => {
            state.access_token = access_token;
        },
    },
    getters: {
        authenticated: state => state.loginUser && state.access_token,
        token: state => state.access_token,
        user: state => state.loginUser,
    },
    actions: {
        login: async (_, credentials) => {
            try {
                var raw = JSON.stringify({
                    rut: credentials.rut,
                    password: credentials.password,
                    remember_me: true,
                });

                var requestOptions = {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: raw,
                };

                const response = await fetch(
                    `${BASE_URL}/login`,
                    requestOptions
                );

                const { access_token } = await response.json();

                return { success: true, token: access_token };
            } catch (error) {
                console.log(error);
                return { success: false };
            }
        },
        attempt: async ({ commit, state }, token) => {
            if (token) {
                commit('SET_ACCESS_TOKEN', token);
            }

            if (!state.access_token) {
                return;
            }

            try {
                var requestOptions = {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${localStorage.getItem(
                            'access_token'
                        )}`,
                    },
                };

                const response = await fetch(
                    `${BASE_URL}/user`,
                    requestOptions
                );
                const { user } = await response.json();

                commit('SET_LOGIN_USER', user);
                return { success: true };
            } catch (error) {
                console.log(error);

                commit('SET_ACCESS_TOKEN', null);
                commit('SET_LOGIN_USER', null);
            }
        },
        logout: async ({ commit }) => {
            try {
                const { data } = await axios.get(`${BASE_URL}/logout`);

                commit('SET_LOGIN_USER', null);
                commit('SET_ACCESS_TOKEN', null);

                return { success: true, message: data.message };
            } catch (error) {
                console.log(error);
                return { success: false };
            }
        },
    },
};
