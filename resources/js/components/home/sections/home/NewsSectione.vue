<template>
    <section id="newsSection">
        <div class="container-fluid">
            <div v-if="data.length > 0" class="all_tab_wrapper">
                <div class="static_data row">
                    <h2 class="main_title ff_ss3_bold">
                        {{ convertLang(newsSecSettings.main_title) }}
                    </h2>
                    <div class="list_box_item">
                        <swiper ref="swiperFeat" @swiper="onSwiper" @slideChange="slideChanged" :navigation="true"
                            :modules="modules":loop=true
                            :autoplay="{
                                delay: 3500,
                                disableOnInteraction: false,
                            }" :breakpoints="breakpointsOpts">
                            <swiper-slide v-for="(post, idx) in data" :key="idx" class="item_sub box_item">
                                <div class="wrapper" @click="toPostDetail(post.categories[0].slug, post.slug)">
                                    <div class="image h-100">
                                        <img class="post_image w-100 h-100" :src="post.image" alt="">
                                    </div>
                                    <div class="content">
                                        <div class="info">
                                            <img class="icon rounded-circle" src="/assets/images/icons/icon-news.jpg"
                                                alt="">
                                            <div class="cat_title ff_ss3_bold">
                                                {{ convertLang(post.categories[0].title) }}
                                            </div>
                                            <div class="open_date">
                                                {{ dayjs(post.created_at).format('DD-MM-YYYY') }}
                                            </div>
                                        </div>
                                        <h2 class="title ff_ss3_bold">
                                            {{ convertLang(post.title) }}
                                        </h2>
                                        <h6 class="desc">
                                            {{ convertLang(post.desc) }}
                                        </h6>
                                    </div>
                                </div>
                            </swiper-slide>
                        </swiper>
                        <!-- <a class="btn btn_navigation btn_prev disabled opacity-00" ref="btnPrev" @click="prev()"></a>
                        <a class="btn btn_navigation btn_next" ref="btnNext" @click="next()"></a> -->
                    </div>
                    <div class="more">
                        <router-link class="btn ff_ss3_bold" to="/news">
                            {{ convertLang(newsSecSettings.news_page_text) }}
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { i18n } from "../../../../app";
import dayjs from "dayjs";
import router from "@resources/js/router/index";
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import { Navigation,Autoplay } from 'swiper/modules';
export default {
    components: { Swiper, SwiperSlide },
    setup() {
        return {
            modules: [Navigation,Autoplay],
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
            data: [],
            newsSecSettings: {},
        };
    },
    created() {
        this.newsSecSettings = JSON.parse(localStorage.getItem('news_sec'));
        this.fetchData();
    },
    computed: {
        lang() {
            return i18n.global.locale;
        },
    },
    methods: {
        fetchData() {
            this.axios
                .get("/api/latest-posts")
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.data = response.data.data;
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
        dayjs,
        toPostDetail(cateSlug, postSlug) {
            router.push({
                name: "News Detail",
                params: {
                    cat_slug: cateSlug,
                    post_slug: postSlug
                },
            });
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        }
    }
};
</script>
