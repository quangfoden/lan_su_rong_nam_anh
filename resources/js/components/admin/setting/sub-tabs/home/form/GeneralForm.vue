<template>
    <div class="settings_form_wrapper col-12">
        <h4 class="text-center mb-2 text-decoration-underline collapsed" data-toggle="collapse"
            data-target="#collapseGeneral" aria-expanded="false">
            Quản lý chung
        </h4>
        <div id="collapseGeneral" class="form_collapse collapse">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label>Tiêu đề trang web: <small>({{ formLang }})</small></label>
                        <input v-model="formData.site_title" @input="setSiteTitleForLang(formData.site_title)"
                            type="text" placeholder="Nhập Site Title" class="form-control" required />
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Favicon:</label>
                        <input type="file" ref="general_favicon" class="form-control"
                            onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_home_favicon').attr('src', event.target.result)}"
                            accept="image/jpeg, image/png">
                        <div class="text-center mt-4 bg-black p-2">
                            <img class="show_home_favicon" :src="formData.favicon" alt="favicon" width="50" height="50"
                                style="border: 1px dashed #fff">
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label>Logo Home:</label>
                        <input type="file" ref="general_logo" class="form-control"
                            onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_home_logo').attr('src', event.target.result)}"
                            accept="image/jpeg, image/png">
                        <div class="text-center mt-4 bg-black p-2">
                            <img class="show_home_logo" :src="formData.logo" alt="logo" width="200" height="50"
                                style="border: 1px dashed #fff">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="my-2">* Footer Privacy:</h5>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Tên: <small>({{ formLang }})</small></label>
                                <input v-model="formData.privacy.name"
                                    @input="setPrivacyNameForLang(formData.privacy.name)" type="text"
                                    placeholder="Nhập Privacy - Name" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Địa chỉ: <small>({{ formLang }})</small></label>
                                <textarea v-model="formData.privacy.address"
                                    @input="setPrivacyAddressForLang(formData.privacy.address)"
                                    placeholder="Nhập Privacy - Address" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Hotline:</label>
                                <input v-model="formData.privacy.phone" type="text" placeholder="Nhập Privacy - Phone"
                                    class="form-control" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="my-2">* Footer Center:</h5>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Content Pic: <small>({{ formLang }})</small></label>
                                <input v-model="formData.footer_center.content"
                                    @input="setFooterCenterContentPicForLang(formData.footer_center.content)"
                                    type="text" placeholder="Nhập Footer Center - Content Pic" class="form-control"
                                    required />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Des-products: <small>({{ formLang }})</small></label>
                                <input v-model="formData.footer_center.products"
                                    @input="setFooterCenterProductsForLang(formData.footer_center.products)" type="text"
                                    placeholder="Nhập Footer Center - des-products" class="form-control"
                                    required />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Des-service.: <small>({{ formLang }})</small></label>
                                <textarea v-model="formData.footer_center.service"
                                    @input="setFooterCenterServiceForLang(formData.footer_center.service)"
                                    placeholder="Nhập Footer Center - Des-service." class="form-control" required />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Email:</label>
                                <input v-model="formData.footer_center.email" type="email"
                                    placeholder="Nhập Footer Center - Email" class="form-control" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="my-2">* Liên hệ:</h5>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label>Link Facebook:</label>
                                <input v-model="formData.contact.link_fb" type="text"
                                    placeholder="Nhập Contact - Link Facebook" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Link Fanpage:</label>
                                <input v-model="formData.contact.link_page_fb" type="text"
                                    placeholder="Nhập Contact - Link Facebook" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Link Tiktok:</label>
                                <input v-model="formData.contact.link_tt" type="text"
                                    placeholder="Nhập Contact - Link Tiktok" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label>Hotline:</label>
                                <input v-model="formData.contact.hotline" type="text"
                                    placeholder="Nhập Contact - Hotline" class="form-control" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h5 class="my-2">* Contact Modal:</h5>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>Text: <small>({{ formLang }})</small></label>
                                <input v-model="formData.contact_modal.text"
                                    @input="setContactModalTextForLang(formData.contact_modal.text)" type="text"
                                    placeholder="Nhập Contact Modal - Text" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Question: <small>({{ formLang }})</small></label>
                                <input v-model="formData.contact_modal.question"
                                    @input="setContactModalQuestionForLang(formData.contact_modal.question)" type="text"
                                    placeholder="Nhập Contact Modal - Question" class="form-control" required />
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label>Answer: <small>({{ formLang }})</small></label>
                                <textarea v-model="formData.contact_modal.answer"
                                    @input="setContactModalAnswerForLang(formData.contact_modal.answer)"
                                    placeholder="Nhập Contact Modal - Answer" class="form-control" required />
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
                site_title: [],
                privacy: {
                    name: [],
                    address: []
                },
                footer_center: {
                    content: [],
                    products: [],
                    service: []
                },
                contact_modal: {
                    text: [],
                    question: [],
                    answer: []
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
                this.formDataLang.site_title[lang] = this.formData.site_title.split(`[:${lang}]`)[1];

                this.formDataLang.privacy.name[lang] = this.formData.privacy.name.split(`[:${lang}]`)[1];
                this.formDataLang.privacy.address[lang] = this.formData.privacy.address.split(`[:${lang}]`)[1];

                this.formDataLang.footer_center.content[lang] = this.formData.footer_center.content.split(`[:${lang}]`)[1];
                this.formDataLang.footer_center.products[lang] = this.formData.footer_center.products.split(`[:${lang}]`)[1];
                this.formDataLang.footer_center.service[lang] = this.formData.footer_center.service.split(`[:${lang}]`)[1];

                this.formDataLang.contact_modal.text[lang] = this.formData.contact_modal.text.split(`[:${lang}]`)[1];
                this.formDataLang.contact_modal.question[lang] = this.formData.contact_modal.question.split(`[:${lang}]`)[1];
                this.formDataLang.contact_modal.answer[lang] = this.formData.contact_modal.answer.split(`[:${lang}]`)[1];
            });
            this.changeFormLangAction();
        },
        changeFormLangAction() {
            this.formData.site_title = this.formDataLang.site_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.privacy.name = this.formDataLang.privacy.name[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.privacy.address = this.formDataLang.privacy.address[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.footer_center.content = this.formDataLang.footer_center.content[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.footer_center.products = this.formDataLang.footer_center.products[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.footer_center.service = this.formDataLang.footer_center.service[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.contact_modal.text = this.formDataLang.contact_modal.text[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.contact_modal.question = this.formDataLang.contact_modal.question[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.contact_modal.answer = this.formDataLang.contact_modal.answer[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
            let langSiteTitle = '',
                langPName = '',
                langPAddress = '',
                langFcContentPic = '',
                langFcProducts = '',
                langFcService = '',
                langCmText = '',
                langCmQuestion = '',
                langCmAnswer = '';
            this.$config.languages.forEach(lang => {
                langSiteTitle += typeof this.formDataLang.site_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.site_title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.site_title[lang]}[:${lang}]` :
                        this.formDataLang.site_title[lang]);

                langPName += typeof this.formDataLang.privacy.name[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.privacy.name[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.privacy.name[lang]}[:${lang}]` :
                        this.formDataLang.privacy.name[lang]);
                langPAddress += typeof this.formDataLang.privacy.address[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.privacy.address[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.privacy.address[lang]}[:${lang}]` :
                        this.formDataLang.privacy.address[lang]);

                langFcContentPic += typeof this.formDataLang.footer_center.content[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.footer_center.content[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.footer_center.content[lang]}[:${lang}]` :
                        this.formDataLang.footer_center.content[lang]);
                langFcProducts += typeof this.formDataLang.footer_center.products[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.footer_center.products[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.footer_center.products[lang]}[:${lang}]` :
                        this.formDataLang.footer_center.products[lang]);
                langFcService += typeof this.formDataLang.footer_center.service[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.footer_center.service[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.footer_center.service[lang]}[:${lang}]` :
                        this.formDataLang.footer_center.service[lang]);

                langCmText += typeof this.formDataLang.contact_modal.text[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.contact_modal.text[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.contact_modal.text[lang]}[:${lang}]` :
                        this.formDataLang.contact_modal.text[lang]);
                langCmQuestion += typeof this.formDataLang.contact_modal.question[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.contact_modal.question[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.contact_modal.question[lang]}[:${lang}]` :
                        this.formDataLang.contact_modal.question[lang]);
                langCmAnswer += typeof this.formDataLang.contact_modal.answer[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.contact_modal.answer[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.contact_modal.answer[lang]}[:${lang}]` :
                        this.formDataLang.contact_modal.answer[lang]);
            });

            this.formDataRequest.site_title = langSiteTitle;

            this.formDataRequest.privacy.name = langPName;
            this.formDataRequest.privacy.address = langPAddress;

            this.formDataRequest.footer_center.content = langFcContentPic;
            this.formDataRequest.footer_center.products = langFcProducts;
            this.formDataRequest.footer_center.service = langFcService;

            this.formDataRequest.contact_modal.text = langCmText;
            this.formDataRequest.contact_modal.question = langCmQuestion;
            this.formDataRequest.contact_modal.answer = langCmAnswer;
        },
        setSiteTitleForLang(site_title) {
            this.formDataLang.site_title[this.formLang] = `[:${this.formLang}]${site_title}[:${this.formLang}]`;
        },
        setPrivacyNameForLang(p_name) {
            this.formDataLang.privacy.name[this.formLang] = `[:${this.formLang}]${p_name}[:${this.formLang}]`;
        },
        setPrivacyAddressForLang(p_address) {
            this.formDataLang.privacy.address[this.formLang] = `[:${this.formLang}]${p_address}[:${this.formLang}]`;
        },
        setFooterCenterContentPicForLang(fc_content) {
            this.formDataLang.footer_center.content[this.formLang] = `[:${this.formLang}]${fc_content}[:${this.formLang}]`;
        },
        setFooterCenterProductsForLang(fc_products) {
            this.formDataLang.footer_center.products[this.formLang] = `[:${this.formLang}]${fc_products}[:${this.formLang}]`;
        },
        setFooterCenterServiceForLang(fc_service) {
            this.formDataLang.footer_center.service[this.formLang] = `[:${this.formLang}]${fc_service}[:${this.formLang}]`;
        },
        setContactModalTextForLang(cm_text) {
            this.formDataLang.contact_modal.text[this.formLang] = `[:${this.formLang}]${cm_text}[:${this.formLang}]`;
        },
        setContactModalQuestionForLang(cm_question) {
            this.formDataLang.contact_modal.question[this.formLang] = `[:${this.formLang}]${cm_question}[:${this.formLang}]`;
        },
        setContactModalAnswerForLang(cm_answer) {
            this.formDataLang.contact_modal.answer[this.formLang] = `[:${this.formLang}]${cm_answer}[:${this.formLang}]`;
        }
    }
};
</script>
