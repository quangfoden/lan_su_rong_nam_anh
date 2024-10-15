<template>
    <section id="FeaturedSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h2 class="ff_ss3_bold">{{ convertLang(productSecSettings.main_title) }}</h2>
                    <div class="slider_wrapper pl-0">
                        <swiper @swiper="onSwiper" :loop="true" :modules="swiperModules" :simulateTouch="false"
                            :autoplay="{ delay: 5000 }" :effect="'fade'" v-if="listFeaturedProducts.length > 0">
                            <swiper-slide v-for="(item, idx) in listFeaturedProducts" :key="idx">
                                <div>
                                    <div class="art_img_wrapper">
                                        <img class="art_img" :src="item.img_cover" alt="">
                                    </div>
                                    <div class="content_wrapper">
                                        <div class="name ff_ss3_bold">
                                            {{ convertLang(item.name) }}
                                        </div>
                                        <div class="des">
                                            {{ convertLang(item.des) }}
                                        </div>
                                        <div class="btn_group">
                                            <a @click.prevent="viewProductDetail(item)"
                                                class="os_btn cursor-poi ff_ss3_bold" :href="item.link_home"
                                                target="_blank">
                                                {{ convertLang(productSecSettings.more_text) }}
                                            </a>
                                            <a class="fb_btn hov3 cursor-poi"
                                                :href="generalSettingsDtPr.contact.link_fb" target="_blank">
                                                <img src="/assets/images/footer/fb-xam.png" alt="">
                                            </a>
                                            <a class="tt_btn hov3 cursor-poi"
                                                :href="generalSettingsDtPr.contact.link_tt" target="_blank">
                                                <img src="/assets/images/footer/tiktok.png" alt="">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </swiper-slide>
                        </swiper>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <deatailsProductModal v-if="isModalVisible" @close="closeModalDtProducts" :product="selectedProduct"
        :isVisible="isModalVisible" />
</template>
<script>
import deatailsProductModal from '../../partials/deatailsProductModal.vue'
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay, EffectFade } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';
import { i18n } from "../../../../app";

export default {
    components: { Swiper, SwiperSlide, deatailsProductModal },
    data() {
        return {
            listFeaturedProducts: [],
            swiperModules: [Autoplay, EffectFade],
            productSecSettings: {},
            selectedProduct: null,
            isModalVisible: false,
            generalSettingsDtPr: {}
        };
    },
    created() {
        this.fetchDataFeaturedProducts();
        this.generalSettingsDtPr = JSON.parse(localStorage.getItem('general'));
        this.productSecSettings = JSON.parse(localStorage.getItem('products_sec'));
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    methods: {
        fetchDataFeaturedProducts() {
            this.axios
                .get("/api/list-ishot")
                .then((response) => {
                    if (response.data.message === "success" && response.data.status === 200) {
                        this.listFeaturedProducts = response.data.data;
                    }
                })
                .catch((error) => {
                    if (error.response.status === 403) {
                        this.logout();
                    }
                    if (error.response.status === 401) {
                        this.logout();
                    }
                });
        },
        onSwiper(swiper) {
            this.swiper = swiper;
            this.$nextTick(() => {
                this.swiper.update();
            });
        },
        viewProductDetail(product) {
            this.selectedProduct = product;
            this.isModalVisible = true;
        },
        closeModalDtProducts() {
            this.isModalVisible = false;
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text;
        }
    }
};
</script>
