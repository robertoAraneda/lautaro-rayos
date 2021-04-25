import headers from '../../services/fetch';

const BASE_URL = '/api/v1/reports';

export default {
    namespaced: true,
    state: {
        typeReports: [],
        reportsPatient: [],
    },
    mutations: {
        SET_TYPE_REPORTS: (state, payload) => {
            state.typeReports = payload;
        },
        SET_TYPE_REPORT: (state, payload) => {
            state.typeReports.push(payload);
        },
        SET_REPORTS_PATIENT: (state, payload) => {
            state.reportsPatient = payload;
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
        reportsPatient: state => state.reportsPatient,
    },
    actions: {
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

                const { data } = await response.json();

                return data;
            } catch (error) {
                console.log(error);
            }
        },
        deleteFileReport: async (_, payload) => {
            try {
                var raw = JSON.stringify({
                    name: payload.name,
                });

                const response = await fetch(`${BASE_URL}/delete`, {
                    method: 'POST',
                    headers,
                    body: raw,
                });

                const { success, message } = await response.json();

                if (success) {
                    return { success, message };
                }
            } catch (error) {
                console.log(error);
            }
        },
        downloadFileReport: async (_, payload) => {
            try {
                var raw = JSON.stringify({
                    name: payload.name_file,
                });

                const response = await fetch(`${BASE_URL}/download`, {
                    method: 'POST',
                    responseType: 'blob', // o blob o arraybuffer
                    headers,
                    body: raw,
                });

                console.log(response);

                const blob = await response.blob();
                return {
                    blob: blob,
                    filename: response.headers
                        .get('content-disposition')
                        .split('filename=')[1]
                        .split('"')[1],
                };
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
        findReportsByPatient: async ({ commit }, payload) => {
            try {
                const response = await fetch(
                    `${BASE_URL}/patient/${payload.id}`,
                    {
                        method: 'GET',
                        headers,
                    }
                );

                const { success, data, message } = await response.json();

                if (success) {
                    commit('SET_REPORTS_PATIENT', data);
                } else {
                    console.log(error);
                }

                return { success, message };
            } catch (error) {
                console.log(error);
            }
        },
        postReport: async ({ commit }, payload) => {
            try {
                var raw = JSON.stringify({
                    patient_id: payload.patient.id,
                    link_file: payload.linkFile,
                    name_file: payload.nameFile,
                    date_report: payload.dateReport,
                    type_report_id: payload.typeReport.id,
                    establishment_id: payload.establishment.id,
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
