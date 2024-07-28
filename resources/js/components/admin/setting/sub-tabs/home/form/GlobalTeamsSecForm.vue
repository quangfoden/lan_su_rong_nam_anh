<template>
    <div class="settings_form_wrapper col-12">
        <h4
            class="text-center mb-2 text-decoration-underline collapsed"
            data-toggle="collapse" data-target="#collapseGlobalTeamsSec"
            aria-expanded="false"
        >
            {{ data.name }} Settings
        </h4>
        <div id="collapseGlobalTeamsSec" class="form_collapse collapse">
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
                                <label>Block {{ idx + 1 }} - Name: <small>({{ formLang }})</small></label>
                                <input
                                    v-model="formData.content[idx].name"
                                    @input="setNameItemContentForLang(idx, formData.content[idx].name)"
                                    type="text"
                                    placeholder="Nhập Name"
                                    class="form-control"
                                />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Block {{ idx + 1 }} - Address: <small>({{ formLang }})</small></label>
                                <textarea
                                    v-model="formData.content[idx].address"
                                    @input="setAddressItemContentForLang(idx, formData.content[idx].address)"
                                    type="text"
                                    placeholder="Nhập Address"
                                    class="form-control"
                                />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Block {{ idx + 1 }} - Phone:</label>
                                <input
                                    v-model="formData.content[idx].phone"
                                    type="text"
                                    placeholder="Nhập Phone"
                                    class="form-control"
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
                content: [
                    { name: [], address: [] },
                    { name: [], address: [] },
                    { name: [], address: [] },
                    { name: [], address: [] }
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

                this.formDataLang.content.forEach((item, idx) => {
                    this.formDataLang.content[idx].name[lang] = this.formData.content[idx].name.split(`[:${lang}]`)[1];
                    this.formDataLang.content[idx].address[lang] = this.formData.content[idx].address.split(`[:${lang}]`)[1];
                });
            });
            this.changeFormLangAction();
        },
        changeFormLangAction() {
            this.formData.main_title = this.formDataLang.main_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.content.forEach((item, idx) => {
                this.formData.content[idx].name = this.formDataLang.content[idx].name[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
                this.formData.content[idx].address = this.formDataLang.content[idx].address[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            });
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
            let langMainTitle = '',
                langContentName = [],
                langContentAddress = [];
            this.formDataLang.content.forEach((item, idx) => {
                langContentName[idx] = '';
                langContentAddress[idx] = '';
            });

            this.$config.languages.forEach(lang => {
                langMainTitle += typeof this.formDataLang.main_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.main_title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.main_title[lang]}[:${lang}]` :
                        this.formDataLang.main_title[lang]);

                this.formDataLang.content.forEach((item, idx) => {
                    langContentName[idx] += typeof this.formDataLang.content[idx].name[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                        (!this.formDataLang.content[idx].name[lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.formDataLang.content[idx].name[lang]}[:${lang}]` :
                            this.formDataLang.content[idx].name[lang]);

                    langContentAddress[idx] += typeof this.formDataLang.content[idx].address[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                        (!this.formDataLang.content[idx].address[lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.formDataLang.content[idx].address[lang]}[:${lang}]` :
                            this.formDataLang.content[idx].address[lang]);
                });
            });

            this.formDataRequest.main_title = langMainTitle;

            this.formDataLang.content.forEach((item, idx) => {
                this.formDataRequest.content[idx].name = langContentName[idx];
                this.formDataRequest.content[idx].address = langContentAddress[idx];
            });
        },
        setMainTitleForLang(main_title) {
            this.formDataLang.main_title[this.formLang] = `[:${this.formLang}]${main_title}[:${this.formLang}]`;
        },
        setNameItemContentForLang(idx, name) {
            this.formDataLang.content[idx].name[this.formLang] = `[:${this.formLang}]${name}[:${this.formLang}]`;
        },
        setAddressItemContentForLang(idx, address) {
            this.formDataLang.content[idx].address[this.formLang] = `[:${this.formLang}]${address}[:${this.formLang}]`;
        }
    }
};
</script>
