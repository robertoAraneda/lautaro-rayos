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
                findUser => findUser.properties.id === user.properties.id
            );
            Object.assign(state.users[index], user);
        },
    },
    getters: {
        users: state => {
            return state.users;
        },
        allUsers: state => {
            return state.users
                .map(({ properties }) => {
                    return {
                        id: properties.id,
                        rut: properties.rut,
                        name: properties.name,
                        phone: properties.phone,
                        mobile: properties.mobile,
                        email: properties.email,
                        role: properties.role,
                        password: properties.password,
                        isFirstLogin: properties.isFirstLogin,
                    };
                })
                .filter(item => {
                    return item.role.description !== 'Developer';
                });
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

                console.log(data);

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
                const URL = `${BASE_URL}/signup`;
                const { data } = await axios.post(URL, user);

                const { _data, success, message, statusCode } = data;

                if (statusCode === 201) {
                    commit('SET_USER', _data);
                    return { success, message };
                } else if (statusCode === 406) {
                    return {
                        success: false,
                        message: { email: 'El email ya existe' },
                    };
                }
            } catch (error) {
                console.log(error.message);
                console.log(error.name);
                return { success: false, message: error.message };
            }
        },
        deleteUser: async ({ commit }, user) => {
            try {
                const URL = `${BASE_URL}/${user.id}`;
                const { data } = await axios.delete(URL);

                const { success, message } = data;

                if (success) {
                    commit('DELETE_USER', user);
                }
                return { success, message };
            } catch (error) {
                console.log(error.message);
                console.log(error.name);
                return { success: false, message: error.message };
            }
        },
        putUser: async ({ commit }, user) => {
            try {
                const URL = `${BASE_URL}/${user.id}`;

                const { data } = await axios.put(URL, user);

                const { _data, success, message } = data;

                if (success) {
                    commit('PUT_USER', _data);
                }

                return { success, message };
            } catch (error) {
                console.log(error.message);
                console.log(error.name);
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
                console.log(error.message);
                console.log(error.name);
                return { success: false, message: error.message };
            }
        },
    },
};
