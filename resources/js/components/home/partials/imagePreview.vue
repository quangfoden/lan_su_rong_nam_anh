<template>
    <div v-if="isVisible" class="modalPreviewImage">
        <button style="top: 30px;" class="how-pos3 position-absolute p-2 border-0 hov3 trans-04 js-hide-modal1"> <img @click="closeModal" src="/assets/images/icons/icon-close2.png" alt="CLOSE"></button>
        <img :src="imageSrc" alt="Product Image" class="modal-image" />
    </div>
</template>

<script>
export default {
    props: {
        imageSrc: {
            type: String,
            required: true
        },
        isVisible: {
            type: Boolean,
            required: true
        }
    },
    methods: {
        closeModal() {
            this.$emit('close');
        }
    }
};
</script>