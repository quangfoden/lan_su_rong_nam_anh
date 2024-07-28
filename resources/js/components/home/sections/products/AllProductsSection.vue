<template>
    <section id="AllProductSection">
        <div class="container-fluid">
            <div class="wrap-search_text">
                <div class="search_text form-group">
                    <input v-model="filters.title" @input="getProductsbyFilters" class="form-control" type="text"
                        placeholder="Tìm kiếm">
                </div>
            </div>
            <div v-if="products.length > 0">
                <div class="row">
                    <div v-for="(item, index) in products" :key="index"
                        class="overflow-hidden col-12 col-md-6 col-lg-4">
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
                            <a @click.prevent="viewProductDetail(item)" class="ct_product_home_link ff_ss3_bold">
                                {{ convertLang(productSecSettings.more_text) }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="products.length < productsCount" id="newsLoadMore" class="ff_ss3_bold" @click="handleLoadMore">
                {{ $t('button.load_more') }}
            </div>
            <div v-if="isEmpty" class="text-center text-white pt-5">
                {{ $t('alert.data_not_found') }}
            </div>
        </div>
    </section>
    <deatailsProductModal v-if="isModalVisible" @close="closeModalDtProducts" :product="selectedProduct"
        :isVisible="isModalVisible" />
</template>
<script>
import debounce from 'lodash/debounce';
import { i18n } from "../../../../app";
import deatailsProductModal from '../../partials/deatailsProductModal.vue'
export default {
    components: { deatailsProductModal },
    data() {
        return {
            filters: {
                title: null,
                limit: 6,
                title: null
            },
            offsetData: 0,
            products: [],
            data: [],
            loadMoreData: [],
            productsCount: {},
            isEmpty: false,
            productSecSettings: {},
            selectedProduct: null,
            isModalVisible: false,
            isFiltering: false
        }
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    created() {
        this.getProducts();
        this.productSecSettings = JSON.parse(localStorage.getItem('products_sec'));
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    watch: {
        products(newProducts) {
            this.offsetData = newProducts.length;
            this.isEmpty = newProducts.length === 0;
        },
    },
    methods: {
        getProducts() {
            this.products = [];
            this.filters.limit = this.isFiltering ? 6 : this.filters.limit;
            this.filters.offset = 0;
            this.axios
                .get("/api/all-products", { params: this.filters })
                .then((response) => {
                    this.isFiltering = false
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.products = response.data.data.products;
                        this.productsCount = response.data.data.count_all;
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
        getProductsbyFilters: debounce(function () {
            this.isFiltering = true;
            this.filters.offset = 0;
            this.getProducts();
        }, 300),
        handleLoadMore() {
            this.filters.limit = 6;
            this.filters.offset = this.offsetData;
            this.axios
                .get("/api/all-products", { params: this.filters })
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.products = this.products.concat(response.data.data.products);
                        this.offsetData += response.data.data.products.length;
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
        viewProductDetail(product) {
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
}
</script>