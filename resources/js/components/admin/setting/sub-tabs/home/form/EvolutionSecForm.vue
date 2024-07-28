<template>
    <div class="settings_form_wrapper col-12">
        <h4
            class="text-center mb-2 text-decoration-underline collapsed"
            data-toggle="collapse" data-target="#collapseEvolutionSec"
            aria-expanded="false"
        >
            {{ data.name }} Settings
        </h4>
        <div id="collapseEvolutionSec" class="form_collapse collapse">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label>Section Title: <small>({{ formLang }})</small></label>
                        <input
                            v-model="formData.main_title"
                            @input="setMainTitleForLang(formData.main_title)"
                            type="text"
                            placeholder="Nhập Section Title"
                            class="form-control"
                            required
                        />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Section Sub-Title: <small>({{ formLang }})</small></label>
                        <input
                            v-model="formData.sub_title"
                            @input="setSubTitleForLang(formData.sub_title)"
                            type="text"
                            placeholder="Nhập Section Sub-Title"
                            class="form-control"
                            required
                        />
                    </div>
                </div>
            </div>
            <div class="row for_content">
                <div
                    v-for="(item, idx) in formData.content"
                    :key="idx"
                    class="col-12"
                >
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Block {{ idx + 1 }} - Title: <small>({{ formLang }})</small></label>
                                <input
                                    v-model="formData.content[idx].title"
                                    @input="setTitleItemContentForLang(idx, formData.content[idx].title)"
                                    type="text"
                                    placeholder="Nhập Title"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Block {{ idx + 1 }} - Years:</label>
                                <input
                                    v-model="formData.content[idx].years"
                                    type="text"
                                    placeholder="Nhập Years"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Block {{ idx + 1 }} - Content: <small>({{ formLang }})</small></label>
                                <textarea
                                    v-model="formData.content[idx].content"
                                    @input="setContentItemContentForLang(idx, formData.content[idx].content)"
                                    type="text"
                                    placeholder="Nhập Content"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
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
                sub_title: [],
                content: [
                    { title: [], content: [] },
                    { title: [], content: [] },
                    { title: [], content: [] },
                    { title: [], content: [] },
                    { title: [], content: [] },
                    { title: [], content: [] },
                    { title: [], content: [] }
                ]
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
                this.formDataLang.sub_title[lang] = this.formData.sub_title.split(`[:${lang}]`)[1];

                this.formDataLang.content.forEach((item, idx) => {
                    this.formDataLang.content[idx].title[lang] = this.formData.content[idx].title.split(`[:${lang}]`)[1];
                    this.formDataLang.content[idx].content[lang] = this.formData.content[idx].content.split(`[:${lang}]`)[1];
                });
            });
            this.changeFormLangAction();
        },
        changeFormLangAction() {
            this.formData.main_title = this.formDataLang.main_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.sub_title = this.formDataLang.sub_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.content.forEach((item, idx) => {
                this.formData.content[idx].title = this.formDataLang.content[idx].title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
                this.formData.content[idx].content = this.formDataLang.content[idx].content[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            });
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
            let langMainTitle = '',
                langSubTitle = '',
                langContentTitle = [],
                langContentContent = [];
            this.formDataLang.content.forEach((item, idx) => {
                langContentTitle[idx] = '';
                langContentContent[idx] = '';
            });

            this.$config.languages.forEach(lang => {
                langMainTitle += typeof this.formDataLang.main_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.main_title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.main_title[lang]}[:${lang}]` :
                        this.formDataLang.main_title[lang]);
                langSubTitle += typeof this.formDataLang.sub_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.sub_title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.sub_title[lang]}[:${lang}]` :
                        this.formDataLang.sub_title[lang]);

                this.formDataLang.content.forEach((item, idx) => {
                    langContentTitle[idx] += typeof this.formDataLang.content[idx].title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                        (!this.formDataLang.content[idx].title[lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.formDataLang.content[idx].title[lang]}[:${lang}]` :
                            this.formDataLang.content[idx].title[lang]);

                    langContentContent[idx] += typeof this.formDataLang.content[idx].content[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                        (!this.formDataLang.content[idx].content[lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.formDataLang.content[idx].content[lang]}[:${lang}]` :
                            this.formDataLang.content[idx].content[lang]);
                });
            });

            this.formDataRequest.main_title = langMainTitle;
            this.formDataRequest.sub_title = langSubTitle;

            this.formDataLang.content.forEach((item, idx) => {
                this.formDataRequest.content[idx].title = langContentTitle[idx];
                this.formDataRequest.content[idx].content = langContentContent[idx];
            });
        },
        setMainTitleForLang(main_title) {
            this.formDataLang.main_title[this.formLang] = `[:${this.formLang}]${main_title}[:${this.formLang}]`;
        },
        setSubTitleForLang(sub_title) {
            this.formDataLang.sub_title[this.formLang] = `[:${this.formLang}]${sub_title}[:${this.formLang}]`;
        },
        setTitleItemContentForLang(idx, title) {
            this.formDataLang.content[idx].title[this.formLang] = `[:${this.formLang}]${title}[:${this.formLang}]`;
        },
        setContentItemContentForLang(idx, content) {
            this.formDataLang.content[idx].content[this.formLang] = `[:${this.formLang}]${content}[:${this.formLang}]`;
        }
    }
};
</script>
