<template>
    <div class="settings_form_wrapper col-12">
        <h4 class="text-center mb-2 text-decoration-underline collapsed" data-toggle="collapse"
            data-target="#collapseOurValueSec" aria-expanded="false">
            Shop Overview Settings
        </h4>
        <div id="collapseOurValueSec" class="form_collapse collapse">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Main Background:</label>
                        <input type="file" ref="life_our_value_main_bg" class="form-control"
                            onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.life_our_value_main_bg').attr('src', event.target.result)}"
                            accept="image/jpeg, image/png">
                        <div class="text-center mt-4 bg-black p-2">
                            <img class="life_our_value_main_bg" :src="formData.main_bg" alt="" height="250"
                                style="border: 1px dashed #fff">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row for_content">
                <div v-for="(item, idx) in formData.content" :key="idx" class="col-12">
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Block {{ idx + 1 }} - Title: <small>({{ formLang }})</small></label>
                                <input v-model="formData.content[idx].title"
                                    @input="setTitleItemContentForLang(idx, formData.content[idx].title)" type="text"
                                    placeholder="Nhập Title" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form-group">
                                <label>Block {{ idx + 1 }} - Content: <small>({{ formLang }})</small></label>
                                <textarea v-model="formData.content[idx].content"
                                    @input="setContentItemContentForLang(idx, formData.content[idx].content)"
                                    type="text" placeholder="Nhập Content" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Block {{ idx + 1 }} - Background:</label>
                                <input type="file" :ref="`life_our_value_content_bg_${idx + 1}`" class="form-control"
                                    :onchange="`const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_life_our_value_content_bg_${idx + 1}').attr('src', event.target.result)}`"
                                    accept="image/jpeg, image/png">
                                <div class="text-center mt-4 bg-black p-2">
                                    <img :class="`show_life_our_value_content_bg_${idx + 1}`"
                                        :src="formData.content[idx].bg" alt="" height="200"
                                        style="border: 1px dashed #fff">
                                </div>
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
                content: [
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
        this.emitter.on("is-converting-response-data-life", isConvertingResponseData => {
            if (isConvertingResponseData) {
                this.convertResponseDataLang();
            }
        });
        this.emitter.on("is-change-form-lang-life", isChangeFormLang => {
            if (isChangeFormLang) {
                this.changeFormLangAction();
            }
        });
        this.emitter.on("is-saving-life-tab", isSavingLifeTab => {
            if (isSavingLifeTab) {
                this.convertRequestDataLang();
            }
        });
    },
    computed: {},
    methods: {
        convertResponseDataLang() {
            this.$config.languages.forEach(lang => {
                this.formDataLang.content.forEach((item, idx) => {
                    this.formDataLang.content[idx].title[lang] = this.formData.content[idx].title.split(`[:${lang}]`)[1];
                    this.formDataLang.content[idx].content[lang] = this.formData.content[idx].content.split(`[:${lang}]`)[1];
                });
            });
            this.changeFormLangAction();
        },
        changeFormLangAction() {
            this.formData.content.forEach((item, idx) => {
                this.formData.content[idx].title = this.formDataLang.content[idx].title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
                this.formData.content[idx].content = this.formDataLang.content[idx].content[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            });
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
            let langContentTitle = [],
                langContentContent = [];
            this.formDataLang.content.forEach((item, idx) => {
                langContentTitle[idx] = '';
                langContentContent[idx] = '';
            });

            this.$config.languages.forEach(lang => {
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

            this.formDataLang.content.forEach((item, idx) => {
                this.formDataRequest.content[idx].title = langContentTitle[idx];
                this.formDataRequest.content[idx].content = langContentContent[idx];
            });
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
