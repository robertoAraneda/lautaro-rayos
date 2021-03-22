<template>
    <v-app>
        <!--  <v-navigation-drawer app> </v-navigation-drawer>
 -->
        <v-app-bar v-if="!authenticated" absolute color="white" app>
            <v-toolbar-title>Title</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-btn @click="test">Login</v-btn>
        </v-app-bar>
        <v-app-bar v-else absolute color="grey lighten-5" app>
            <v-app-bar-nav-icon
                v-show="!showDrawer"
                @click="setDrawer"
                class="burdeo--text"
            ></v-app-bar-nav-icon>
            <v-toolbar-title class="burdeo--text"
                >Laboratorio clínico - Hospital Dr. Abraham Godoy
                Peña</v-toolbar-title
            >
            <v-spacer></v-spacer>
            <v-btn
                v-show="showLaboratoryButton"
                rounded
                color="burdeo"
                dark
                @click="laboratory"
                >Laboratorio</v-btn
            >
            <v-btn class="ml-2" fab dark color="burdeo" small>
                <v-icon dark>
                    mdi-power
                </v-icon>
            </v-btn>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main class="grey lighten-4">
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                <router-view></router-view>
            </v-container>
        </v-main>

        <v-footer app>
            foot
        </v-footer>
    </v-app>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    props: {
        privileges: Object,
    },
    name: 'App',
    data() {
        return {};
    },
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
        }),
        drawer: {
            get() {
                return this.$store.state.drawer;
            },
            set(val) {
                this.$store.commit('SET_DRAWER', val);
            },
        },
        showDrawer() {
            return this.$route.path === '/' || this.$route.path === '/login';
        },
        showLaboratoryButton() {
            return this.$route.path === '/';
        },
    },

    methods: {
        test() {
            this.$router.push({ name: 'login' });
        },
        setDrawer() {
            this.drawer = !this.drawer;
        },
        laboratory() {
            this.$router.push({ name: 'Laboratory' });
        },
    },
};
</script>
