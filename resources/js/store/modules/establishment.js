import headers from '../../services/fetch';

const BASE_URL = '/api/v1/establishments';

export default {
    namespaced: true,
    state: {
        establishments: [],
    },
    mutations: {
        SET_ESTABLISHMENTS: (state, payload) => {
            state.establishments = payload;
        },
        SET_ESTABLISHMENT: (state, payload) => {
            state.establishments.push(payload);
        },
        DELETE_ESTABLISHMENT: (state, payload) => {
            const index = state.establishments.findIndex(
                find => find.id === payload.id
            );

            state.establishments.splice(index, 1);
        },
        PUT_ESTABLISHMENT: (state, payload) => {
            const index = state.establishments.findIndex(
                findUser => findUser.id === payload.id
            );
            Object.assign(state.establishments[index], payload);
        },
    },
    getters: {
        establishments: state => {
            return state.establishments;
        },
    },
    actions: {
        fetchEstablishments: async ({ commit }) => {
            try {
                const response = await fetch(BASE_URL, {
                    method: 'GET',
                    headers,
                });

                const { success, data, message } = await response.json();

                if (success) {
                    commit('SET_ESTABLISHMENTS', data.array);
                } else {
                    console.log(error);
                }

                return { success, message };
            } catch (error) {
                console.log(error);
            }
        },
        postEstablishment: async ({ commit }, payload) => {
            try {
                var raw = JSON.stringify({
                    description: payload.description,
                    shortname: payload.shortname,
                });

                const response = await fetch(BASE_URL, {
                    method: 'POST',
                    headers,
                    body: raw,
                });

                const { success, data, message } = await response.json();
                if (success) {
                    commit('SET_ESTABLISHMENT', data);
                    return { success, message };
                } else {
                    return {
                        success: false,
                        message: message,
                    };
                }
            } catch (error) {
                console.log(error);
                return { success: false, message: error.message };
            }
        },
        deleteEstablishment: async ({ commit }, payload) => {
            try {
                const response = await fetch(`${BASE_URL}/${payload.id}`, {
                    method: 'DELETE',
                    headers,
                });

                const { success, message } = await response.json();

                if (success) {
                    commit('DELETE_ESTABLISHMENT', payload);
                }
                return { success, message };
            } catch (error) {
                console.log(error);
                return { success: false, message: error.message };
            }
        },
        putEstablishment: async ({ commit }, payload) => {
            try {
                var raw = JSON.stringify({
                    description: payload.description,
                    shortname: payload.shortname,
                });
                const response = await fetch(`${BASE_URL}/${payload.id}`, {
                    method: 'PUT',
                    headers,
                    body: raw,
                });

                const { success, data, message } = await response.json();
                if (success) {
                    commit('PUT_ESTABLISHMENT', data);
                    return { success, message };
                } else {
                    return {
                        success: false,
                        message: message,
                    };
                }
            } catch (error) {
                console.log(error);
                return { success: false, message: error.message };
            }
        },
    },
};
