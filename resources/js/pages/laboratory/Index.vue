<template>
    <div>
        <v-navigation-drawer permanent app>
            <v-list-item>
                <v-list-item-content>
                    <v-list-item-title class="title">
                        Laboratorio
                    </v-list-item-title>
                    <v-list-item-subtitle v-if="user">
                        {{ user.name }}
                    </v-list-item-subtitle>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense nav shaped>
                <v-list-group
                    v-for="(link, index) in items"
                    :key="index"
                    no-action
                    :prepend-icon="link.icon"
                    color
                >
                    <template v-slot:activator>
                        <v-list-item>
                            <v-list-item-title>{{
                                link.name
                            }}</v-list-item-title>
                        </v-list-item>
                    </template>
                    <v-list-item
                        v-for="internalLink in link.links"
                        :key="internalLink.name"
                        :to="internalLink.to"
                        link
                    >
                        <v-list-item-content>
                            <v-list-item-title>{{
                                internalLink.name
                            }}</v-list-item-title>
                        </v-list-item-content>
                        <v-list-item-icon
                            v-if="internalLink.icon !== undefined"
                        >
                            <v-icon>{{ internalLink.icon }}</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>
        <v-container fluid>
            Content
            <router-view></router-view>
        </v-container>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data: () => ({
        items: [
            {
                name: 'Configuración',
                icon: 'mdi-cog',
                links: [
                    {
                        name: 'Funcionarios',
                        to: { name: 'SettingEmployee' },
                    },
                ],
            },
        ],
    }),
    computed: {
        ...mapGetters({
            user: 'auth/user',
        }),
    },
};
</script>

<style lang="scss" scoped></style>
