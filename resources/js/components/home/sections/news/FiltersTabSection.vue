<template>
    <section id="newsFiltersTabSection">
        <div class="container-fluid">
            <div class="row">
                <div
                    v-if="data.length > 0"
                    class="list_load_more">
                    <div
                        v-for="(post, idx) in data"
                        :key="idx"
                        class="box_item col-12 py-4"
                        :class="{'pt-0': idx === 0}"
                    >
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
                <div
                    v-if="data.length < postsCount[filters.slug]"
                    id="newsLoadMore"
                    class="ff_ss3_bold"
                    @click="handleLoadMore"
                >
                    {{ $t('button.load_more') }}
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
            isEmpty: false
        };
    },
    computed: {
      lang() {
        return i18n.global.locale;
      }
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
                        this.data = this.data.concat(response.data.data.posts);
                        this.offsetData += response.data.data.posts.length;
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
