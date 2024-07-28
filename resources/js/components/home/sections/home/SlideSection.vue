<template>
    <section id="slideSection">
        <swiper v-if="screen > 767" :spaceBetween="30" :centeredSlides="true" :autoplay="{
            delay: 2500,
            disableOnInteraction: false,
        }" :loop=true :modules="modules" class="slide h-100 mySwiper">
            <swiper-slide v-for="(slideSecSetting, index) in slideSecSettings" :key="index" class="item-slide"
                :style="{ backgroundImage: `url(${slideSecSetting.img})` }">
                <!-- Nội dung của swiper-slide -->
            </swiper-slide>
        </swiper>
        <swiper v-else :spaceBetween="30" :centeredSlides="true" :autoplay="{
            delay: 2500,
            disableOnInteraction: false,
        }" :loop=true :modules="modules" class="slide h-100 mySwiper">
            <swiper-slide v-for="(slideSecSetting, index) in slideSecSettings" :key="index" class="item-slide"
                :style="{ backgroundImage: `url(${slideSecSetting.img_small})` }">
                <!-- Nội dung của swiper-slide -->
            </swiper-slide>
        </swiper>
    </section>
</template>

<script>
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Navigation, Autoplay, Pagination } from 'swiper/modules';
import 'swiper/css';
export default {
    components: {
        Swiper,
        SwiperSlide,
    },
    setup() {
        return {
            modules: [Autoplay],
        };
    },
    data() {
        return {
            slideSecSettings: {},
            screenWidth: window.innerWidth
        };
    },
    computed: {
        screen() {
            return this.screenWidth;
        }
    },
    created() {
        this.slideSecSettings = JSON.parse(localStorage.getItem('slide_sec'));
    },
    mounted() {
        window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    },
    methods: {
        handleResize() {
            this.screenWidth = window.innerWidth;
        }
    },
};
</script>
