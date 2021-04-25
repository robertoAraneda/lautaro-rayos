<template>
    <v-row>
        <v-col cols="12">
            <v-file-input
                label="Seleccionar archivo"
                v-model="file"
                outlined
                dense
                show-size
                prepend-icon=""
                prepend-inner-icon="mdi-paperclip"
                color="burdeo"
            >
                <template v-slot:selection="{ text }">
                    <v-chip label color="burdeo" dark>
                        {{ text }}
                    </v-chip>
                </template>
            </v-file-input>
            <v-btn block @click="handleUploadFile" color="burdeo" dark>
                Subir archivo
            </v-btn>
        </v-col>
        <v-col cols="12">
            <v-card outlined v-show="isFileUploadedExist">
                <span class="overline font-weight-size blueS--text ml-3"
                    >Archivo adjuntos</span
                >
                <div class="d-flex justify-start flex-wrap">
                    <v-chip
                        v-for="file in uploadedFiles"
                        :key="file.name"
                        class="ma-2"
                        close
                        color="burdeo"
                        outlined
                        @click:close="handleDeleteFile(file)"
                    >
                        <v-icon>
                            mdi-file-upload
                        </v-icon>
                        {{ file.name }}({{
                            Number((file.size / 1024).toFixed(1))
                        }}K)
                    </v-chip>
                </div>
            </v-card>
        </v-col>
    </v-row>
</template>

<script>
import { mapActions } from 'vuex';
export default {
    data: () => ({
        files: null,
        file: null,
        uploadedFiles: [],
        loadingFile: false,
    }),
    computed: {
        isFileUploadedExist() {
            return this.uploadedFiles.length !== 0;
        },
    },
    methods: {
        ...mapActions({
            uploadFileReport: 'report/uploadFileReport',
            deleteFileReport: 'report/deleteFileReport',
        }),
        async handleUploadFile() {
            this.loadingFile = true;

            console.log(this.file);
            const uploadedFile = await this.uploadFileReport({
                file: this.file,
            });

            this.uploadedFiles.push(uploadedFile);
            this.file = null;
            this.loadingFile = false;
            this.$emit('files', this.uploadedFiles);
        },
        async handleDeleteFile(file) {
            const deleteFile = await this.deleteFileReport({ name: file.name });

            /**
      * Object = {
      * name: "56653.jpg"
      * size: 68379
      + url: "/storage/56653.jpg"
      * }
      */

            if (deleteFile) {
                const editedIndex = this.uploadedFiles.findIndex(
                    find => find.name === file.name
                );
                this.uploadedFiles.splice(editedIndex, 1);
            } else {
                console.log('error');
            }
        },
    },
};
</script>

<style lang="scss" scoped></style>
