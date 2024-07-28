<template>
    <div class="wrap-modal js-modal1 p-t-60 p-b-20  show-modal">
        <div class="overlay-modal"></div>
        <div class="modal-product-details">
            <div class="bg0 bor-10 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                <button @click="closeModal"
                    class="how-pos3 bor-10 position-absolut top-0 p-2 border-0 hov3 trans-04 js-hide-modal1">
                    <img src="/assets/images/icons/icon-close2.png" alt="CLOSE">
                </button>
                <div class="row">
                    <div class="col-md-6 col-lg-7 p-b-30">
                        <div class="px-lg-2 px-3">
                            <div class="wrap-slick flex-sb flex-w">
                                <div class="wrap-slick-dots">
                                    <ul class="slick-dots p-0">
                                        <li @click="changeImg(product.bg_img)" class="slick-active cursor-poi"
                                            :class="{ 'active': product.bg_img === changeBgImg }">
                                            <img :src="product.bg_img" alt="">
                                        </li>
                                        <li @click="changeImg(product.details_img)" class="slick-active cursor-poi"
                                            :class="{ 'active': product.details_img === changeBgImg }">
                                            <img :src="product.details_img" alt="">
                                        </li>
                                    </ul>
                                </div>
                                <div class="slick gallery-lb slick-initialized slick-slider slick-dotted">
                                    <div class="slick-list draggable">
                                        <div class="slick-track">
                                            <div class="item-slick slick-slide slick-current slick-active">
                                                <div class="wrap-pic-w pos-relative">
                                                    <img @click="viewImage(changeBgImg)" width="100%" :src="changeBgImg"
                                                        alt="">
                                                    <button @click="viewImage(changeBgImg)"
                                                        class="flex-c-m size-108 how-pos1 border-0 fs-16 cl10 hov-btn3 trans-04"
                                                        href="">
                                                        <i class="fa fa-expand fs-3"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-5 p-b-30">
                        <div class="px-lg-2 px-3 mr-4">
                            <h4 class="mtext-105 cl2 name-detail p-b-14">
                                {{ convertLang(product.name) }}
                            </h4>
                            <span class="mtext-106 py-2 cl2">
                                giá: <span class="price">{{ formatPrice(product.price) }} VNĐ</span>
                            </span>
                            <p class="stext-102 py-2 cl3">
                                mô tả: {{ convertLang(product.des) }}
                            </p>
                            <div class="p-t-33">
                                <h5 class="mtext-105 cl2 p-b-14">Liên hệ ngay</h5>
                                <div class="d-inline-flex gap-3 p-2 contact-list align-items-center">
                                    <a class="link-item link_fb" :href="generalSettingsDtPr.contact.link_fb"
                                        target="_blank">
                                        <img src="/assets/images/footer/fb-xam.png" alt="link_fb">
                                    </a>
                                    <a class="link-item link_tt" :href="generalSettingsDtPr.contact.link_tt"
                                        target="_blank">
                                        <img src="/assets/images/footer/tiktok.png" alt="link_tt">
                                    </a>
                                    <div>
                                        <i class="fas fa-phone fs-4"></i>{{
                                            commasHotlineDtPr(generalSettingsDtPr.contact.hotline) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <imagePreview :imageSrc="selectedImage" :isVisible="isImageModalVisible" @close="closeImageModal" />
</template>
<script>
import imagePreview from './imagePreview.vue'
import { i18n } from "../../../app";
export default {
    components: {
        imagePreview
    },
    data() {
        return {
            selectedImage: null,
            changeBgImg: null,
            isImageModalVisible: false,
            generalSettingsDtPr: {}
        }
    },
    props: {
        product: {
            type: Object,
            required: true
        },
        isVisible: {
            type: Boolean,
            required: true
        }
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    created() {
        this.generalSettingsDtPr = JSON.parse(localStorage.getItem('general'));
        this.changeBgImg = this.product.bg_img
    },
    methods: {
        closeModal() {
            this.$emit('close');
        },
        formatPrice(price) {
            return new Intl.NumberFormat('vi-VN').format(price);
        },
        viewImage(imageSrc) {
            this.selectedImage = imageSrc;
            this.isImageModalVisible = true;
        },
        closeImageModal() {
            this.isImageModalVisible = false;
        },
        changeImg(img) {
            this.changeBgImg = img
        },
        commasHotlineDtPr(number) {
            return number.toString().replace(/\B(?=(\d{4})+(?!\d))/g, ".");
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        }
    },
}
</script>