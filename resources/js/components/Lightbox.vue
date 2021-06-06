<template>
    <div>
        <ul class="list-group list-group-horizontal m-0 p-0">
            <li
                v-for="(image, index) in media"
                :key="index"
                class="list-group-item list-group-item-action d-inline-block text"
            >
                <img
                    :src="image.thumb"
                    @click="openGallery(index)"
                    class="w-100"
                    style="height: 100px; cursor: pointer; object-fit:cover;"
                />
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
