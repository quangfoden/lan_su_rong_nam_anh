<template>
    <section id="newsAllTabSection">
        <div class="container-fluid">
            <div v-if="data.length > 0" class="all_tab_wrapper">
                <div class="static_data row">
                    <div v-for="(post, idx) in data" :key="idx" :class="{
                        'item_main box_item col-12': idx === 0 && screen > 767,
                        'item_sub box_item col-4': idx > 0 || screen <= 767
                    }">
                        <div class="wrapper" @click="toPostDetail(post.categories[0].slug, post.slug)">
                            <div class="image h-100">
                                <img class="post_image w-100 h-100" :src="post.image" alt="">
                            </div>
                            <div class="content">
                                <div class="info">
                                    <img class="icon rounded-circle" src="/assets/images/icons/icon-news.jpg" alt="">
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
                    </div>
                </div>

                <div v-if="loadMoreData.length > 0" class="list_load_more">
                    <div v-for="(post, idx) in loadMoreData" :key="idx" class="box_item col-12 py-4">
                        <div class="wrapper row" @click="toPostDetail(post.categories[0].slug, post.slug)">
                            <div class="content col-7">
                                <div class="info">
                                    <img class="icon rounded-circle" src="/assets/images/icons/icon-news.jpg" alt="">
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
                            <div class="image h-100 col-5">
                                <img class="post_image" :src="post.image" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="posts.length < postsCount.all" id="newsLoadMore" class="ff_ss3_bold" @click="handleLoadMore">
                    {{ $t('button.load_more') }}
                </div>
            </div>
            <div v-if="isEmpty" class="text-center pt-5">
                {{ $t('alert.data_not_found') }}
            </div>
        </div>
    </section>
</template>

<script>
import dayjs from "dayjs";
import router from "@resources/js/router/index";
import { i18n } from "../../../../app";

export default {
    props: {
        posts: {
            type: Array,
            required: true
        },
        filters: {
            type: Object,
            required: true
        },
        postsCount: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            offsetData: 0,
            data: [],
            loadMoreData: [],
            isEmpty: false,
            screenWidth: window.innerWidth
        };
    },
    computed: {
        lang() {
            return i18n.global.locale;
        },
        screen() {
            return this.screenWidth;
        }
    },
    watch: {
        posts(newPosts) {
            this.data = newPosts;
            this.offsetData = this.data.length;
            this.isEmpty = this.data.length === 0;
        },
    },
    mounted() {
        this.emitter.on("is-filtering", isFiltering => {
            if (isFiltering) {
                this.loadMoreData = [];
            }
        });
        window.addEventListener('resize', this.handleResize);
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.handleResize);
    },
    methods: {
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
        handleLoadMore() {
            this.filters.limit = 3;
            this.filters.offset = this.offsetData;
            this.axios
                .get("/api/all-posts", { params: this.filters })
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.loadMoreData = this.loadMoreData.concat(response.data.data.posts);
                        this.offsetData += response.data.data.posts.length;
                        if (this.postsCount.all === this.offsetData) {
                            $('#newsLoadMore').remove();
                        }
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
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        },
        handleResize() {
            this.screenWidth = window.innerWidth;
        }
    },

};
</script>
