import headers from '../../services/fetch';

const BASE_URL = '/api/v1/type-reports';

export default {
    namespaced: true,
    state: {
        typeReports: [],
    },
    mutations: {
        SET_TYPE_REPORTS: (state, payload) => {
            state.typeReports = payload;
        },
        SET_TYPE_REPORT: (state, payload) => {
            state.typeReports.push(payload);
        },
        DELETE_TYPE_REPORT: (state, payload) => {
            const index = state.typeReports.findIndex(
                find => find.id === payload.id
            );

            state.typeReports.splice(index, 1);
        },
        PUT_TYPE_REPORT: (state, payload) => {
            const index = state.typeReports.findIndex(
                findUser => findUser.id === payload.id
            );
            Object.assign(state.typeReports[index], payload);
        },
    },
    getters: {
        typeReports: state => {
            return state.typeReports;
        },
    },
    actions: {
        deleteFileEmail: async (_, payload) => {
            try {
                const { data } = await axios.post(
                    '/api/v1/report/delete',
                    payload
                );

                const { _data } = data;

                return _data;
            } catch (error) {
                console.log(error);
            }
        },
        uploadFileReport: async (_, payload) => {
            try {
                let formData = new FormData();

                formData.append(`file`, payload.file);

                const response = await fetch('/api/v1/reports/upload', {
                    method: 'POST',
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem(
                            'access_token'
                        )}`,
                    },
                    body: formData,
                });

                const { success, data, message } = await response.json();
                console.log(success);
                console.log(message);

                return data;
            } catch (error) {
                console.log(error);
            }
        },
        fetchTypeReports: async ({ commit }) => {
            try {
                const response = await fetch(BASE_URL, {
                    method: 'GET',
                    headers,
                });

                const { success, data, message } = await response.json();

                if (success) {
                    commit('SET_TYPE_REPORTS', data.array);
                } else {
                    console.log(error);
                }

                return { success, message };
            } catch (error) {
                console.log(error);
            }
        },
        postTypeReport: async ({ commit }, payload) => {
            try {
                var raw = JSON.stringify({
                    description: payload.description,
                });

                const response = await fetch(BASE_URL, {
                    method: 'POST',
                    headers,
                    body: raw,
                });

                const { success, data, message } = await response.json();
                if (success) {
                    commit('SET_TYPE_REPORT', data);
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
        deleteTypeReport: async ({ commit }, payload) => {
            try {
                const response = await fetch(`${BASE_URL}/${payload.id}`, {
                    method: 'DELETE',
                    headers,
                });

                const { success, message } = await response.json();

                if (success) {
                    commit('DELETE_TYPE_REPORT', payload);
                }
                return { success, message };
            } catch (error) {
                console.log(error);
                return { success: false, message: error.message };
            }
        },
        putTypeReport: async ({ commit }, payload) => {
            try {
                var raw = JSON.stringify({
                    description: payload.description,
                });
                const response = await fetch(`${BASE_URL}/${payload.id}`, {
                    method: 'PUT',
                    headers,
                    body: raw,
                });

                const { success, data, message } = await response.json();
                if (success) {
                    commit('PUT_TYPE_REPORT', data);
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
