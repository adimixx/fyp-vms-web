<template>
    <div>
        <file-pond
            :server="{ process, revert }"
            ref="pond"
            name="file"
            labelIdle="Drag & Drop or Click to import file"
            :maxFileSize="maxFileSize"
            :acceptedFileTypes="acceptedFileTypes"
            :maxFiles="maxFilesLocal"
            @init="init"
            @updatefiles="updatefiles"
            :allowMultiple="maxFilesLocal == null || maxFilesLocal > 1"
        ></file-pond>
        <FormulateInput v-model="uploadedFileName" type="hidden" name="file" />
    </div>
</template>

<script>
export default {
    data() {
        return {
            uploadedFileName: [],
            maxFilesLocal: null
        };
    },
    props: {
        maxFileSize: String,
        acceptedFileTypes: String,
        maxFiles: Number
    },
    mounted() {
        if (this.maxFiles) {
            this.maxFilesLocal = this.maxFiles;
        }
    },
    methods: {
        init() {
            console.log("pond init");
        },
        updatefiles(e) {
            this.uploadedFileName = this.$refs.pond
                .getFiles()
                .map(x => x.serverId);
            this.uploadedFileName.shift();
            console.log(this.uploadedFileName);
        },
        process(
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
            console.log("uploading file");

            const formData = new FormData();
            formData.append(fieldName, file, file.name);

            const CancelToken = axios.CancelToken;
            const source = CancelToken.source();

            axios
                .post("/backend/file", formData, {
                    onUploadProgress: function(progressEvent) {
                        progress(
                            progressEvent.lengthComputable,
                            progressEvent.loaded,
                            progressEvent.total
                        );
                    },
                    cancelToken: source.token
                })
                .then(res => {
                    load(res.data);
                    console.log('uploaded');

                })
                .catch(err => {
                    if (axios.isCancel(thrown)) {
                        console.log("Request canceled", thrown.message);
                    } else {
                        error("upload error");
                    }
                });

            return {
                abort: () => {
                    // This function is entered if the user has tapped the cancel button
                    source.cancel("User aborted upload");
                    // Let FilePond know the request has been cancelled
                    abort();
                }
            };
        },
        revert: (uniqueFileId, load, error) => {
            axios
                .delete("/backend/file/" + uniqueFileId)
                .then(res => {
                    console.log("file deleted");
                })
                .catch(err => {
                    error("delete error");
                });

            // Should call the load method when done, no parameters required
            load();
        }
    }
};
</script>

<style></style>
