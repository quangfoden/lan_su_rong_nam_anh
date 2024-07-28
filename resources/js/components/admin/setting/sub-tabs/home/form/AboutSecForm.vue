<template>
    <div class="settings_form_wrapper col-12">
        <h4
            class="text-center mb-2 text-decoration-underline collapsed"
            data-toggle="collapse" data-target="#collapseAboutSec"
            aria-expanded="false"
        >
            {{ data.name }} Settings
        </h4>
        <div id="collapseAboutSec" class="form_collapse collapse">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label>Section Title: </label>
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
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="my-2">* Tổng quan Shop:</h5>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tiêu đề: <small>({{ formLang }})</small></label>
                                <input
                                    v-model="formData.overview.title"
                                    @input="setVisionTitleForLang(formData.overview.title)"
                                    type="text"
                                    placeholder="Nhập tiêu đề ... "
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label>Nội dung: <small>({{ formLang }})</small></label>
                                <textarea
                                    v-model="formData.overview.content"
                                    @input="setVisionContentForLang(formData.overview.content)"
                                    placeholder="Nhập nội dung ..."
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="my-2">* Products:</h5>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tiêu đề: <small>({{ formLang }})</small></label>
                                <input
                                    v-model="formData.products.title"
                                    @input="setMissionTitleForLang(formData.products.title)"
                                    type="text"
                                    placeholder="Nhập tiêu đề ..."
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label>Nội dung: <small>({{ formLang }})</small></label>
                                <textarea
                                    v-model="formData.products.content"
                                    @input="setMissionContentForLang(formData.products.content)"
                                    placeholder="Nhập nội dung ..."
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="my-2">* Action Principle:</h5>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tiêu đề: <small>({{ formLang }})</small></label>
                                <input
                                    v-model="formData.service.title"
                                    @input="setActionPrincipleTitleForLang(formData.service.title)"
                                    type="text"
                                    placeholder="Nhập tiêu đề ..."
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label>Nội dung: <small>({{ formLang }})</small></label>
                                <textarea
                                    v-model="formData.service.content"
                                    @input="setActionPrincipleContentForLang(formData.service.content)"
                                    placeholder="Nhập nội dung ..."
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
                overview: {
                    title: [],
                    content: []
                },
                products: {
                    title: [],
                    content: []
                },
                service: {
                    title: [],
                    content: []
                }
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

                this.formDataLang.overview.title[lang] = this.formData.overview.title.split(`[:${lang}]`)[1];
                this.formDataLang.overview.content[lang] = this.formData.overview.content.split(`[:${lang}]`)[1];

                this.formDataLang.products.title[lang] = this.formData.products.title.split(`[:${lang}]`)[1];
                this.formDataLang.products.content[lang] = this.formData.products.content.split(`[:${lang}]`)[1];

                this.formDataLang.service.title[lang] = this.formData.service.title.split(`[:${lang}]`)[1];
                this.formDataLang.service.content[lang] = this.formData.service.content.split(`[:${lang}]`)[1];
            });
            this.changeFormLangAction();
        },
        changeFormLangAction() {
            this.formData.main_title = this.formDataLang.main_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.overview.title = this.formDataLang.overview.title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.overview.content = this.formDataLang.overview.content[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.products.title = this.formDataLang.products.title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.products.content = this.formDataLang.products.content[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.service.title = this.formDataLang.service.title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.service.content = this.formDataLang.service.content[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
            let langMainTitle = '',
                langVTitle = '',
                langVContent = '',
                langMTitle = '',
                langMContent = '',
                langApTitle = '',
                langApContent = '';
            this.$config.languages.forEach(lang => {
                langMainTitle += typeof this.formDataLang.main_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.main_title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.main_title[lang]}[:${lang}]` :
                        this.formDataLang.main_title[lang]);

                langVTitle += typeof this.formDataLang.overview.title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.overview.title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.overview.title[lang]}[:${lang}]` :
                        this.formDataLang.overview.title[lang]);
                langVContent += typeof this.formDataLang.overview.content[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.overview.content[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.overview.content[lang]}[:${lang}]` :
                        this.formDataLang.overview.content[lang]);

                langMTitle += typeof this.formDataLang.products.title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.products.title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.products.title[lang]}[:${lang}]` :
                        this.formDataLang.products.title[lang]);
                langMContent += typeof this.formDataLang.products.content[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.products.content[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.products.content[lang]}[:${lang}]` :
                        this.formDataLang.products.content[lang]);

                langApTitle += typeof this.formDataLang.service.title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.service.title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.service.title[lang]}[:${lang}]` :
                        this.formDataLang.service.title[lang]);
                langApContent += typeof this.formDataLang.service.content[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.service.content[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.service.content[lang]}[:${lang}]` :
                        this.formDataLang.service.content[lang]);
            });

            this.formDataRequest.main_title = langMainTitle;

            this.formDataRequest.overview.title = langVTitle;
            this.formDataRequest.overview.content = langVContent;

            this.formDataRequest.products.title = langMTitle;
            this.formDataRequest.products.content = langMContent;

            this.formDataRequest.service.title = langApTitle;
            this.formDataRequest.service.content = langApContent;
        },
        setMainTitleForLang(main_title) {
            this.formDataLang.main_title[this.formLang] = `[:${this.formLang}]${main_title}[:${this.formLang}]`;
        },
        setVisionTitleForLang(v_title) {
            this.formDataLang.overview.title[this.formLang] = `[:${this.formLang}]${v_title}[:${this.formLang}]`;
        },
        setVisionContentForLang(v_content) {
            this.formDataLang.overview.content[this.formLang] = `[:${this.formLang}]${v_content}[:${this.formLang}]`;
        },
        setMissionTitleForLang(m_title) {
            this.formDataLang.products.title[this.formLang] = `[:${this.formLang}]${m_title}[:${this.formLang}]`;
        },
        setMissionContentForLang(m_content) {
            this.formDataLang.products.content[this.formLang] = `[:${this.formLang}]${m_content}[:${this.formLang}]`;
        },
        setActionPrincipleTitleForLang(ap_title) {
            this.formDataLang.service.title[this.formLang] = `[:${this.formLang}]${ap_title}[:${this.formLang}]`;
        },
        setActionPrincipleContentForLang(ap_content) {
            this.formDataLang.service.content[this.formLang] = `[:${this.formLang}]${ap_content}[:${this.formLang}]`;
        }
    }
};
</script>
