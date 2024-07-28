<template>
    <TopBar />
    <BannerSection />
    <section id="newsContentSection">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="list_cats__search">
                        <div class="list_cats">
                            <router-link :to="`/${lang}/news/`" class="ff_ss3_bold"
                                :class="{ 'mm-active': [`NamAnh's News`].includes($route.name) }"
                                @click="getCurrentSlug('all')">
                                {{ $t('button.news_all') }}
                            </router-link>
                            <router-link v-for="(cat, idx) in tabCategories" :key="idx"
                                :to="`/${lang}/news/${cat.slug}`" class="ff_ss3_bold"
                                :class="{ 'mm-active': [`/${lang}/news/${cat.slug}`].includes($route.path) }"
                                @click="getCurrentSlug(cat.slug)">
                                {{ convertLang(cat.title) }}
                            </router-link>
                        </div>
                        <div class="search">
                            <div class="search_year form-group">
                                <DatePicker v-model="filters.year" year-picker
                                    :year-range="[2012, new Date().getFullYear()]"
                                    :placeholder="this.$t('placeholder.news_filter_year')"
                                    @update:model-value="getPostsByFilters" />
                            </div>
                            <div class="search_text form-group">
                                <input class="form-control" type="text" v-model="filters.title"
                                    :placeholder="this.$t('placeholder.news_filter_search')" @input="getPostsByFilters">
                            </div>
                        </div>
                    </div>

                    <div v-if="!isFiltering" class="tabs_wrapper">
                        <AllTabSection v-if="catSlug === 'all'" :posts="posts" :filters="filters"
                            :postsCount="postsCount" />
                        <CategoryTabSection v-else :posts="posts" :filters="filters" :postsCount="postsCount" />
                    </div>

                    <div v-if="isFiltering" class="tabs_wrapper">
                        <FiltersTabSection :posts="posts" :filters="filters" :postsCount="postsCount" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <FooterSection />
</template>
<script>
import debounce from 'lodash/debounce';
import TopBar from "../../partials/TopBar.vue";
import FooterSection from "../../sections/FooterSection.vue";
import BannerSection from "../../sections/news/BannerSection.vue";
import AllTabSection from "../../sections/news/AllTabSection.vue";
import CategoryTabSection from "../../sections/news/CategoryTabSection.vue";
import FiltersTabSection from "../../sections/news/FiltersTabSection.vue";
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { i18n } from "../../../../app";

export default {
    components: {
        BannerSection,
        AllTabSection,
        CategoryTabSection,
        FiltersTabSection,
        TopBar,
        FooterSection,
        DatePicker
    },
    data() {
        return {
            catSlug: typeof this.$route.params.slug === 'undefined' ? 'all' : this.$route.params.slug,
            tabCategories: [],
            filters: {
                year: null,
                title: null,
                slug: null,
                limit: 3
            },
            posts: [],
            postsCount: {},
            isFiltering: false
        }
    },
    created() {
        this.getCategories();
        this.getPosts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    methods: {
        getCurrentSlug(slug) {
            this.catSlug = typeof slug === 'undefined' ? 'all' : slug;
            window.scrollTo({ top: 0, behavior: 'smooth' });
            this.getPosts();
        },
        getPosts() {
            this.posts = [];
            this.filters.limit = this.catSlug === 'all' ? 4 : 3;
            this.filters.limit = this.isFiltering ? 3 : this.filters.limit;
            this.filters.offset = 0;
            this.filters.slug = this.catSlug;
            this.axios
                .get("/api/all-posts", { params: this.filters })
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.posts = response.data.data.posts;
                        this.postsCount[this.filters.slug] = response.data.data.count_all;
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
        getPostsByFilters: debounce(function () {
            this.isFiltering = this.filters.year != null || (!['', null].includes(this.filters.title));
            this.getPosts();
            this.emitter.emit("is-filtering", true);
        }, 300),
        getCategories() {
            this.axios
                .get("/api/all-categories")
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.tabCategories = response.data.data;
                        let allCounts = 0;
                        this.tabCategories.forEach(item => {
                            allCounts += item.posts_count;
                            this.postsCount[item.slug] = item.posts_count;
                        });
                        this.postsCount['all'] = allCounts;
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
    }
}
</script>
