<template>
    <div>
        <file-pond
            name="file"
            ref="pond"
            label-idle="Click here or drop to add your image / videos"
            :allow-multiple="true"
            accepted-file-types="image/jpeg, image/png, video/mp4"
            :files="initFiles"
            @init="handleFilePondInit"
            @removefile="handleFilePondUpdate"
            @processfile="handleFilePondUpdate"
            imagePreviewMaxHeight="300"
            maxFileSize="3MB"
            :server="{ process: '/api/file', revert: onRevertFile }"
        />
    </div>
</template>

<script>
import vueFilePond from "vue-filepond";
import FilePondPluginFileValidateType from "filepond-plugin-file-validate-type";
import FilePondPluginImagePreview from "filepond-plugin-image-preview";
import FilePondPluginFileValidateSize from "filepond-plugin-file-validate-size";

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize
);

export default {
    components: {
        FilePond
    },
    data() {
        return {};
    },
    props: {
        isUpload: false,
        initFiles: Array
    },
    methods: {
        handleFilePondInit() {
            console.log("FilePond has initialized");
        },
        handleFilePondUpdate() {
            this.$emit(
                "file-update",
                this.$refs.pond.getFiles().map(x => {
                    return x.serverId;
                })
            );
        },
        async onRevertFile(uniqueFileID, load, error) {
            await axios.delete("/api/file/" + uniqueFileID);
            load();
        }
    }
};
</script>

<style></style>
