import Vue from 'vue';
import Vuex from 'vuex';

import auth from './modules/auth';
import user from './modules/user';
import typeReport from './modules/typeReport';
Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        auth,
        user,
        typeReport,
    },
    state: {
        drawer: true,
    },
    getters: {
        drawer: state => state.drawer,
    },
    mutations: {
        SET_DRAWER: (state, payload) => {
            state.drawer = payload;
        },
    },
    actions: {
        updateDrawer({ commit, state }) {
            const drawer = state.drawer;
            commit('SET_DRAWER', !drawer);
        },
    },
});
