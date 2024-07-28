<template>
    <div class="settings_form_wrapper col-12">
        <h4 class="text-center mb-2 text-decoration-underline collapsed" data-toggle="collapse"
            data-target="#collapseNewsSec" aria-expanded="false">
            {{ data.name }} Settings
        </h4>
        <div id="collapseNewsSec" class="form_collapse collapse">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Section Title: <small>({{ formLang }})</small></label>
                        <input v-model="formData.main_title" @input="setMainTitleForLang(formData.main_title)"
                            type="text" placeholder="Nhập Section Title" class="form-control" required />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Section News Page Text: <small>({{ formLang }})</small></label>
                        <input v-model="formData.news_page_text" @input="setNewPageTextForLang(formData.news_page_text)"
                            type="text" placeholder="Nhập Section News Page Text" class="form-control" required />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    props: {
        data: {
            type: Object,
            required: true,
        },
        formLang: {
            type: String,
            required: true,
        }
    },
    data() {
        return {
            formData: {},
            formDataRequest: {},
            formDataLang: {
                main_title: [],
                news_page_text: [],
            }
        };
    },
    created() {
        this.formData = this.data.data;
    },
    mounted() {
        this.emitter.on("is-converting-response-data", isConvertingResponseData => {
            if (isConvertingResponseData) {
                this.convertResponseDataLang();
            }
        });
        this.emitter.on("is-change-form-lang", isChangeFormLang => {
            if (isChangeFormLang) {
                this.changeFormLangAction();
            }
        });
        this.emitter.on("is-saving-home-tab", isSavingHomeTab => {
            if (isSavingHomeTab) {
                this.convertRequestDataLang();
            }
        });
    },
    computed: {},
    methods: {
        convertResponseDataLang() {
            this.$config.languages.forEach(lang => {
                this.formDataLang.main_title[lang] = this.formData.main_title.split(`[:${lang}]`)[1];
                this.formDataLang.news_page_text[lang] = this.formData.news_page_text.split(`[:${lang}]`)[1];
            });
            this.changeFormLangAction();
        },
        changeFormLangAction() {
            this.formData.main_title = this.formDataLang.main_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.news_page_text = this.formDataLang.news_page_text[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
            let langMainTitle = '',
                langNewsPageText = '';

            this.$config.languages.forEach(lang => {
                langMainTitle += typeof this.formDataLang.main_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.main_title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.main_title[lang]}[:${lang}]` :
                        this.formDataLang.main_title[lang]);

                langNewsPageText += typeof this.formDataLang.news_page_text[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.news_page_text[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.news_page_text[lang]}[:${lang}]` :
                        this.formDataLang.news_page_text[lang]);
            });

            this.formDataRequest.main_title = langMainTitle;
            this.formDataRequest.news_page_text = langNewsPageText;
        },
        setMainTitleForLang(main_title) {
            this.formDataLang.main_title[this.formLang] = `[:${this.formLang}]${main_title}[:${this.formLang}]`;
        },
        setNewPageTextForLang(news_page_text) {
            this.formDataLang.news_page_text[this.formLang] = `[:${this.formLang}]${news_page_text}[:${this.formLang}]`;
        },
    }
};
</script>
