<template>
    <section id="featuredProductsSection">
        <div class="container container_2">
            <div class="row">
                <div class="col-12">
                    <h2 class="ff_ss3_bold">{{ convertLang(productSecSettings.main_title) }}</h2>
                    <div class="list-featured-products-home">
                        <swiper ref="swiperFeat" @swiper="onSwiper" @slideChange="slideChanged" :navigation="true"
                            :autoplay="{
                                delay: 3500,
                                disableOnInteraction: false,
                            }" :modules="modules" :loop=true :breakpoints="breakpointsOpts">
                            <swiper-slide v-for="(item, idx) in listFeaturedProducts" :key="idx">
                                <div class="ct_product">
                                    <img class="ct_product_img" :src="item.bg_img" :alt="convertLang(item.name)">
                                    <div class="ct_product_info">
                                        <div class="ct_g_info_desc">
                                            <div class="ct_g_info_desc_name ff_ss3_bold">
                                                {{ convertLang(item.name) }}
                                            </div>
                                            <div class="ct_g_info_desc_content">
                                                {{ convertLang(item.des) }}
                                            </div>
                                        </div>
                                    </div>
                                    <a @click.prevent="viewProductDetail(item)"
                                        class="ct_product_home_link ff_ss3_bold">
                                        {{ convertLang(productSecSettings.more_text) }}
                                    </a>
                                </div>
                            </swiper-slide>
                        </swiper>
                    </div>
                    <div class="our_pride_n_joy">
                        <router-link class="btn ff_ss3_bold" to="/products">
                            {{ convertLang(productSecSettings.products_page_text) }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <deatailsProductModal v-if="isModalVisible" @close="closeModalDtProducts" :product="selectedProduct" :isVisible="isModalVisible" />
</template>

<script>
import deatailsProductModal from '../../partials/deatailsProductModal.vue'
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { i18n } from "../../../../app";
import 'swiper/css';
import { Navigation, Autoplay } from 'swiper/modules';
export default {

    components: { Swiper, SwiperSlide, deatailsProductModal },
    setup() {
        return {
            modules: [Navigation, Autoplay],
        };
    },
    data() {
        return {
            swiper: null,
            indexStart: 1,
            breakpointsOpts: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                415: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
                1440: {
                    slidesPerView: 3,
                    spaceBetween: 70
                }
            },
            indexEnd: 0,
            listFeaturedProducts: [],
            productSecSettings: {},
            selectedProduct: null,
            isModalVisible: false
        };
    },
    created() {
        this.productSecSettings = JSON.parse(localStorage.getItem('products_sec'));
        this.fetchData();
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    methods: {
        fetchData() {
            this.axios
                .get("/api/list-ishot")
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.listFeaturedProducts = response.data.data;
                        this.indexEnd = Math.ceil(this.listFeaturedProducts.length / 3);
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
        viewProductDetail(product){
            this.selectedProduct = product;
            this.isModalVisible = true;
        },
        closeModalDtProducts() {
            this.isModalVisible = false;
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        }
    }
};
</script>
