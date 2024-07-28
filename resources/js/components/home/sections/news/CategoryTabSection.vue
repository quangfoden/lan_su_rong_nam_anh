<template>
    <section id="newsCategoryTabSection">
        <div class="container-fluid">
            <div class="row">
                <div v-if="data.length > 0"  class="category_tab_wrapper">
                    <div class="static_data row">
                        <div
                            v-for="(post, idx) in data"
                            :key="idx"
                            class="item_sub box_item col-4"
                        >
                            <div class="wrapper" @click="toPostDetail(post.categories[0].slug, post.slug)">
                                <div class="image h-100">
                                    <img class="post_image w-100 h-100" :src="post.image" alt="">
                                </div>
                                <div class="content">
                                    <div class="info">
                                        <img class="icon rounded-circle rounded-circle" src="/assets/images/icons/icon-news.jpg" alt="">
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

                    <div v-if="loadMoreData.length > 0" class="row">
                        <div
                            v-for="(post, idx) in loadMoreData"
                            :key="idx"
                            class="item_sub box_item col-4"
                        >
                            <div class="wrapper" @click="toPostDetail(post.categories[0].slug, post.slug)">
                                <div class="image h-100">
                                    <img class="post_image w-100 h-100" :src="post.image" alt="">
                                </div>
                                <div class="content">
                                    <div class="info">
                                        <img class="icon" src="/assets/images/icons/icon-news.jpg" alt="">
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
                    <div
                        v-if="posts.length < postsCount[this.filters.slug]"
                        id="newsLoadMore"
                        class="ff_ss3_bold"
                        @click="handleLoadMore"
                    >
                        {{ $t('button.load_more') }}
                    </div>
                </div>
                <div v-if="isEmpty" class="text-center pt-5">
                    {{ $t('alert.data_not_found') }}
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import dayjs from "dayjs";
import router from "@resources/js/router/index";
import {i18n} from "../../../../app";

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
            isEmpty: false
        };
    },
    computed: {
      lang() {
        return i18n.global.locale;
      }
    },
    mounted() {
        this.emitter.on("is-filtering", isFiltering => {
            if (isFiltering) {
                this.loadMoreData = [];
            }
        });
    },
    watch: {
        posts(newPosts) {
            this.data = [];
            this.data = newPosts;
            this.offsetData = this.data.length;
            this.isEmpty = this.data.length === 0;
        },
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
                .get("/api/all-posts", {params: this.filters})
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
        }
    },
};
</script>
