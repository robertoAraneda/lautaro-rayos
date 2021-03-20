<template>
    <v-app>
        <!--  <v-navigation-drawer app> </v-navigation-drawer>
 -->
        <v-app-bar absolute color="white" app>
            <v-app-bar-nav-icon></v-app-bar-nav-icon>

            <v-toolbar-title>Title</v-toolbar-title>

            <v-spacer></v-spacer>
            <v-btn @click="test">Login</v-btn>
        </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>
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
export default {
    props: {
        privileges: Object,
    },
    name: 'App',
    data() {
        return {};
    },
    mounted() {},

    methods: {
        test() {
            this.$router.push('login');
        },
    },
};
</script>
