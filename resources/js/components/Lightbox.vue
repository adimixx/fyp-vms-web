<template>
    <div>
        <ul class="list-group list-group-horizontal m-0 p-0">
            <li
                v-for="(image, index) in media"
                :key="index"
                style="cursor: pointer;"
                class="list-group-item list-group-item-action d-inline-block text"
                @click="openGallery(index)"
            >
                <img
                    :src="image.thumb"
                    class="w-100"
                    style="height: 100px; object-fit:cover;"
                    v-if="image.thumb != null"
                />
                <div v-if="image.thumb == null" class="text-center h-100 w-100">
                    <i class="fas fa-film fa-4x"></i>
                </div>
            </li>
        </ul>

        <LightBox
            :media="media"
            :show-light-box="false"
            ref="lightbox"
        ></LightBox>
    </div>
</template>

<script>
import LightBox from "vue-it-bigger";

export default {
    components: {
        LightBox
    },
    props: {
        media: Array
    },
    methods: {
        openGallery(index) {
            this.$refs.lightbox.showImage(index);
        }
    }
};
</script>

<style></style>
