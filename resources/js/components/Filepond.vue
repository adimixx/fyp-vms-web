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
            :server="{ process: onProcess, revert: onRevertFile }"
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
        async onProcess(
            fieldName,
            file,
            metadata,
            load,
            error,
            progress,
            abort,
            transfer,
            options
        ) {
            try {
            } catch (e) {}

            // fieldName is the name of the input field
            // file is the actual file object to send
            const formData = new FormData();
            formData.append(fieldName, file, file.name);
            const CancelToken = axios.CancelToken;
            const cancelSrc = CancelToken.source();

            axios
                .post("/backend/file", formData, {
                    onUploadProgress: progressEvent => {
                        progress(
                            progressEvent.lengthComputable,
                            progressEvent.loaded,
                            progressEvent.total
                        );
                    },
                    cancelToken: cancelSrc.token
                })
                .then(function(res) {
                    load(res.data);
                })
                .catch(function(error) {
                    if (axios.isCancel(thrown)) {
                        console.log("Request canceled", thrown.message);
                    } else {
                        error("oh no");
                    }
                });

            // Should expose an abort method so the request can be cancelled
            return {
                abort: () => {
                    // This function is entered if the user has tapped the cancel button
                    cancelSrc.cancel("upload cancelled");

                    // Let FilePond know the request has been cancelled
                    abort();
                }
            };
        },
        async onRevertFile(uniqueFileID, load, error) {
            await axios.delete("/backend/file/" + uniqueFileID);
            load();
        }
    }
};
</script>

<style></style>
