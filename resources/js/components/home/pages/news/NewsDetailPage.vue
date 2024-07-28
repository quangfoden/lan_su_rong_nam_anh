<template>
    <TopBar/>
    <BannerSection/>
    <section id="newsContentSection" class="detail">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="list_cats__search">
                        <div class="list_cats">
                            <router-link :to="`/${lang}/news/`" class="ff_ss3_bold">
                                {{ $t('button.news_all') }}
                            </router-link>
                            <router-link
                                v-for="(cat, idx) in tabCategories"
                                :key="idx"
                                :to="`/${lang}/news/${cat.slug}`"
                                class="ff_ss3_bold"
                                :class="{ 'mm-active':  $route.params.cat_slug === cat.slug }"
                            >
                                {{ convertLang(cat.title) }}
                            </router-link>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="back_title">
                        <a @click="back"><i class="fa fa-chevron-left"></i> {{ $t('button.back') }}</a>
                        <div class="like_number">
                            <span>{{ post.like_number }}</span> <i class="fa fa-thumbs-up"></i>
                        </div>
                    </div>
                    <h1 class="post_title ff_ss3_bold">{{ convertLang(post.title) }}</h1>
                    <div class="main_translate">
                        <div class="time_post">{{ dayjs(post.created_at).format('DD-MM-YYYY') }} (GMT+07:00)</div>
                        <div class="translator"></div>
                    </div>
                    <div class="full_content" v-html="convertLang(post.content)"></div>
                </div>
                <div class="like__copy_link col-12">
                    <div class="item_like" :class="{active: isClientLiked}" @click="handleLike(post.id)">
                        <i class="fa fa-thumbs-up"></i> <span>{{ $t('button.like') }}</span>
                    </div>
                    <div class="item_copy" @click="copyLink">
                        <i class="fa fa-link"></i> <span>{{ $t('button.copy_link') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <FooterSection/>
</template>
<script>
import TopBar from "../../partials/TopBar.vue";
import FooterSection from "../../sections/FooterSection.vue";
import BannerSection from "../../sections/news/BannerSection.vue";
import dayjs from "dayjs";
import {i18n} from "../../../../app";

export default {
    components: {
        BannerSection,
        TopBar,
        FooterSection
    },
    data() {
        return {
            post: {},
            tabCategories: [],
            isClientLiked: false,
            isTranslate: false
        }
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    created() {
        this.getCategories();
        this.getPost();
        this.isClientLiked = localStorage.getItem(this.$route.params.post_slug) !== null &&
            localStorage.getItem(this.$route.params.post_slug) === 'liked';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    methods: {
        dayjs,
        getPost() {
            this.post = [];
            this.axios
                .get(`/api/post/${this.$route.params.post_slug}`)
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.post = response.data.data;
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
        getCategories() {
            this.axios
                .get("/api/all-categories")
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.tabCategories = response.data.data;
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
        back() {
            window.history.go(-1);
            return false;
        },
        handleLike(postId) {
            if (!this.isClientLiked) {
                this.axios
                    .post(`/api/post/like/${postId}`)
                    .then((response) => {
                        if (response.data.status === 200 && response.data.success) {
                            this.post.like_number = this.post.like_number + 1;
                            this.isClientLiked = true;
                            localStorage.setItem(this.$route.params.post_slug, 'liked');
                        }
                    });
            }
        },
        copyLink() {
            navigator.clipboard.writeText(document.URL);
            alert('The link has been copied.');
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        }
    }
}
</script>
