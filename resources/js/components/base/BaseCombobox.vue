<template>
    <v-combobox
        v-model="selected"
        :items="items"
        @change="$emit('updateValue', selected)"
        :label="label"
        chips
        color="burdeo"
        dense
        outlined
        item-text="description"
        item-value="id"
        return-object
    >
        <template v-slot:selection="data">
            <v-chip
                :key="JSON.stringify(data.item.id)"
                v-bind="data.attrs"
                @click:close="data.parent.selectItem(data.item)"
                small
            >
                <v-avatar
                    class="burdeo white--text"
                    left
                    v-text="data.item.description.slice(0, 1).toUpperCase()"
                ></v-avatar>
                {{ data.item.description }}
            </v-chip>
        </template>
    </v-combobox>
</template>

<script>
export default {
    name: 'BaseCombobox',
    props: {
        items: Array,
        label: {
            type: String,
            default: () => 'Label',
        },
    },
    data: () => ({
        selected: null,
    }),
};
</script>

<style lang="scss" scoped></style>
