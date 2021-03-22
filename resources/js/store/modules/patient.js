import headers from '../../services/fetch';

const BASE_URL = '/api/v1/patients';

export default {
    namespaced: true,
    state: {
        foundedPatients: [],
        patient: null,
    },
    mutations: {
        SET_FOUNDED_PATIENTS: (state, payload) => {
            state.foundedPatients = [];
            state.foundedPatients = payload;
        },
        SET_PATIENT: (state, payload) => {
            state.typeReports.push(payload);
        },
    },
    getters: {
        foundedPatients: state => state.foundedPatients,
        patient: state => state.patient,
    },
    actions: {
        fetchFoundedPatients: async ({ commit }, payload) => {
            try {
                var raw = JSON.stringify({
                    names: payload.names,
                    lastname: payload.lastname,
                    mother_lastname: payload.motherLastname,
                });
                const response = await fetch(`${BASE_URL}/find/demographics`, {
                    method: 'POST',
                    headers,
                    body: raw,
                });

                const { success, data, message } = await response.json();

                if (success) {
                    commit('SET_FOUNDED_PATIENTS', data.array);
                } else {
                    console.log(error);
                }

                return { success, message };
            } catch (error) {
                console.log(error);
            }
        },
        findPatientByRut: async ({ commit }, payload) => {
            try {
                const rut = payload.rut;

                const response = await fetch(`${BASE_URL}/find/rut/${rut}`, {
                    method: 'GET',
                    headers,
                });

                const { success, data, message } = await response.json();

                if (success) {
                    commit('SET_FOUNDED_PATIENTS', data.array);
                } else {
                    console.log(error);
                }

                return { success, message };
            } catch (error) {
                console.log(error);
            }
        },
        findPatientByBdup: async ({ commit }, payload) => {
            try {
                const bdup = payload.bdup;

                const response = await fetch(`${BASE_URL}/find/bdup/${bdup}`, {
                    method: 'GET',
                    headers,
                });

                const { success, data, message } = await response.json();

                if (success) {
                    commit('SET_FOUNDED_PATIENTS', data.array);
                } else {
                    console.log(error);
                }

                return { success, message };
            } catch (error) {
                console.log(error);
            }
        },
        postPatient: async ({ commit }, payload) => {
            try {
                var raw = JSON.stringify({
                    rut: payload.rut,
                    bdup: payload.bdup,
                    names: payload.names,
                    lastname: payload.lastname,
                    mother_lastname: payload.motherLastname,
                    birthdate: payload.birthDate,
                    email: payload.email,
                    phone: payload.phone,
                });

                const response = await fetch(BASE_URL, {
                    method: 'POST',
                    headers,
                    body: raw,
                });

                const { success, data, message } = await response.json();
                if (success) {
                    commit('SET_PATIENT', data);
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
