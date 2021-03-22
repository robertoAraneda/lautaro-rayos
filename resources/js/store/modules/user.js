import headers from '../../services/fetch';

const BASE_URL = '/api/v1/users';

export default {
    namespaced: true,
    state: {
        users: [],
    },
    mutations: {
        SET_USERS: (state, users) => {
            state.users = users;
        },
        SET_USER: (state, user) => {
            state.users.push(user);
        },
        DELETE_USER: (state, user) => {
            const index = state.users.findIndex(
                findUser => findUser.id === user.id
            );

            state.users.splice(index, 1);
        },
        PUT_USER: (state, user) => {
            const index = state.users.findIndex(
                findUser => findUser.id === user.id
            );
            Object.assign(state.users[index], user);
        },
    },
    getters: {
        users: state => {
            return state.users;
        },
    },
    actions: {
        fetchUsers: async ({ commit }) => {
            try {
                const response = await fetch(BASE_URL, {
                    method: 'GET',
                    headers,
                });

                const { success, data, message } = await response.json();

                if (success) {
                    commit('SET_USERS', data.array);
                } else {
                    console.log(error);
                }

                return { success, message };
            } catch (error) {
                console.log(error);
            }
        },
        postUser: async ({ commit }, user) => {
            try {
                var raw = JSON.stringify({
                    rut: user.rut,
                    name: user.name,
                    lastname: user.lastname,
                    mother_lastname: user.motherLastname,
                    email: user.email,
                    password: user.possword,
                    phone: user.phone,
                });

                const response = await fetch(`/api/v1/signup`, {
                    method: 'POST',
                    headers,
                    body: raw,
                });

                const {
                    success,
                    statusCode,
                    data,
                    message,
                } = await response.json();

                if (statusCode === 201) {
                    commit('SET_USER', data);
                    return { success, message };
                } else if (statusCode === 406) {
                    return {
                        success: false,
                        message: { email: 'El email ya existe' },
                    };
                }
            } catch (error) {
                console.log(error);
                return { success: false, message: error.message };
            }
        },
        deleteUser: async ({ commit }, user) => {
            try {
                const response = await fetch(`/api/v1/users/${user.id}`, {
                    method: 'DELETE',
                    headers,
                });

                const { success, message } = await response.json();

                if (success) {
                    commit('DELETE_USER', user);
                }
                return { success, message };
            } catch (error) {
                console.log(error);
                return { success: false, message: error.message };
            }
        },
        putUser: async ({ commit }, user) => {
            try {
                var raw = JSON.stringify({
                    rut: user.rut,
                    name: user.name,
                    lastname: user.lastname,
                    mother_lastname: user.motherLastname,
                    email: user.email,
                    password: user.possword,
                    phone: user.phone,
                });

                const response = await fetch(`/api/v1/users/${user.id}`, {
                    method: 'PUT',
                    headers,
                    body: raw,
                });

                const {
                    success,
                    statusCode,
                    data,
                    message,
                } = await response.json();

                if (statusCode === 200) {
                    commit('PUT_USER', data);
                    return { success, message };
                } else if (statusCode === 406) {
                    return {
                        success: false,
                        message: { email: 'El email ya existe' },
                    };
                }
            } catch (error) {
                console.log(error);
                return { success: false, message: error.message };
            }
        },
        changePasswordIsFirstLogin: async (_, { user, token }) => {
            try {
                const URL = `${BASE_URL}/${user.id}`;

                axios.defaults.headers.common[
                    'Authorization'
                ] = `Bearer ${token}`;

                const { data } = await axios.put(URL, user);

                const { success, message } = data;

                return { success, message };
            } catch (error) {
                console.log(error);
                return { success: false, message: error.message };
            }
        },
    },
};
