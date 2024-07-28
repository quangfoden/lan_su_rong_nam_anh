<template>
    <div class="settings_wrapper">
        <form id="homeForm">
            <div class="sticky_group">
                <a class="btn_save_settings btn btn-all-add-edit" @click="saveHomeSettings">Lưu cài đặt</a>
                <span class="lang_selector form-group">
                    <select v-model="formLang" class="form-select" @change="changeFormLang">
                        <option v-for="(lang, key) in $config.langOptions" :key="key" :value="key">
                            {{ lang }}
                        </option>
                    </select>
                </span>
            </div>
            <div v-for="(val, idx) in data" :key="idx" class="row">
                <GeneralForm v-if="val.name === 'General'" :data="val" :formLang="formLang" ref="GeneralForm" />
                <SlideSecForm v-if="val.name === 'Slide Sec.'" :data="val" :formLang="formLang" ref="SlideSecForm" />
                <ProductsSecForm v-if="val.name === 'Products Sec.'" :data="val" :formLang="formLang"
                    ref="ProductsSecForm" />
                <NewsSecForm v-if="val.name === 'News Sec.'" :data="val" :formLang="formLang" ref="NewsSecForm" />
                <AboutSecForm v-if="val.name === 'About Sec.'" :data="val" :formLang="formLang" ref="AboutSecForm" />
            </div>
        </form>
    </div>
</template>

<script>
import GeneralForm from "./form/GeneralForm.vue";
import SlideSecForm from "./form/SlideSecForm.vue";
import AboutSecForm from "./form/AboutSecForm.vue";
import ProductsSecForm from "./form/ProductsSecForm.vue";
import NewsSecForm from "./form/NewsSecForm.vue";

export default {
    props: {
        data: {
            type: Array,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
    },
    components: {
        GeneralForm, SlideSecForm, AboutSecForm, ProductsSecForm, NewsSecForm
    },
    data() {
        return {
            currentHomeData: [],
            formLang: this.$config.languages[0]
        };
    },
    created() {
        const me = this;
        this.$nextTick(() => {
            me.convertResponseData();
        });
    },
    mounted() {

    },
    computed: {},
    methods: {
        convertResponseData() {
            this.emitter.emit("is-converting-response-data", true);
        },
        changeFormLang() {
            this.emitter.emit("is-change-form-lang", true);
        },
        saveHomeSettings() {
            this.emitter.emit("is-saving-home-tab", true);

            const GeneralFormData = JSON.stringify(Object.keys(this.$refs.GeneralForm[0].formDataRequest).map((key) =>
                [key, this.$refs.GeneralForm[0].formDataRequest[key]]
            ));

            const SlideSecFormData = JSON.stringify(Object.keys(this.$refs.SlideSecForm[0].formDataRequest).map((key) =>
                [key, this.$refs.SlideSecForm[0].formDataRequest[key]]
            ));
            const ProductsSecFormData = JSON.stringify(Object.keys(this.$refs.ProductsSecForm[0].formDataRequest).map((key) =>
                [key, this.$refs.ProductsSecForm[0].formDataRequest[key]]
            ));
            const NewsSecFormData = JSON.stringify(Object.keys(this.$refs.NewsSecForm[0].formDataRequest).map((key) =>
                [key, this.$refs.NewsSecForm[0].formDataRequest[key]]
            ));
            const AboutSecFormData = JSON.stringify(Object.keys(this.$refs.AboutSecForm[0].formDataRequest).map((key) =>
                [key, this.$refs.AboutSecForm[0].formDataRequest[key]]
            ));

            const chars = {
                ' ': '_',
                '.': ''
            };

            function setData(slug) {
                switch (slug) {
                    case ('general'):
                        return GeneralFormData;
                    case ('slide_sec'):
                        return SlideSecFormData;
                    case ('products_sec'):
                        return ProductsSecFormData;
                    case ('news_sec'):
                        return NewsSecFormData;
                    case ('about_sec'):
                        return AboutSecFormData;
                }
            }

            this.data.forEach((item) => {
                let slug = item.name.replace(/[ .]/g, m => chars[m]).toLowerCase();
                this.currentHomeData[slug] = JSON.stringify([item.name, setData(slug)]);
            });
            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('general', this.currentHomeData['general']);
            formData.append('slide_sec', this.currentHomeData['slide_sec']);
            formData.append('products_sec', this.currentHomeData['products_sec']);
            formData.append('news_sec', this.currentHomeData['news_sec']);
            formData.append('about_sec', this.currentHomeData['about_sec']);

            // check General file inputs
            const generalFavicon = this.$refs.GeneralForm[0].$refs.general_favicon.files[0] ?? null;
            const generalLogo = this.$refs.GeneralForm[0].$refs.general_logo.files[0] ?? null;
            formData.append('general_favicon', generalFavicon);
            formData.append('general_logo', generalLogo);

            // Collect Slide file inputs
            if (this.$refs.SlideSecForm && this.$refs.SlideSecForm.length > 0) {
                const slideSecFormData = this.$refs.SlideSecForm[0]?.collectFiles();
                if (slideSecFormData && slideSecFormData instanceof FormData) {
                    for (const [key, value] of slideSecFormData.entries()) {
                        formData.append(key, value);
                    }
                } else {
                    console.log('No data returned from collectFiles.');
                }
            } else {
                console.log('$refs.SlideSecForm is not initialized or empty.');
            }

            // update settings
            const swalLoading = this.$swal.fire({
                title: "",
                customClass: {
                    container: "bg-transparent",
                    popup: "bg-transparent",
                },
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    this.$swal.showLoading();
                },
            });

            this.axios
                .post("/api/admin/settings/update", formData)
                .then((response) => {
                    if (response.data.status === 200 && response.data.success) {
                        this.changeFormLang();
                        this.$swal.close(swalLoading);
                        this.$swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: this.$config.notificationTimer ?? 1000,
                        });
                    } else if (response.data.status === 200 && !response.data.success) {
                        this.$swal.close(swalLoading);
                        this.$swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: `Error ${response.data.message}`
                        });
                    }
                })
                .catch((error) => {
                    if (error.response.status === 403) {
                        this.logout();
                    }
                    if (error.response.status === 401) {
                        this.logout();
                    }
                    this.$swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: `Error ${error.response.status}: ${error.response.data.message}`
                    });
                });
        }
    },
};
</script>
