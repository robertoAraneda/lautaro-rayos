<template>
    <v-app>
        <!--  <v-navigation-drawer app> </v-navigation-drawer>
 -->
        <v-app-bar v-if="!authenticated" absolute color="white" app>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title>Title</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-btn @click="test">Login</v-btn>
        </v-app-bar>
        <v-app-bar v-else absolute color="white" app>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>
            <v-toolbar-title>Hospital Dr. Abraham Godoy Peña</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn icon @click="test" class="ml-3">
                <v-icon>mdi-power</v-icon>
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
    mounted() {},
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
        }),
    },

    methods: {
        test() {
            this.$router.push('login');
        },
    },
};
</script>
