<template>
    <div class="settings_form_wrapper col-12">
        <h4 class="text-center mb-2 text-decoration-underline collapsed" data-toggle="collapse"
            data-target="#collapseHowWeHireSec" aria-expanded="false">
            Support & FAQs Settings
        </h4>
        <div id="collapseHowWeHireSec" class="form_collapse collapse">
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Section Title: <small>({{ formLang }})</small></label>
                        <input v-model="formData.main_title" @input="setMainTitleForLang(formData.main_title)"
                            type="text" placeholder="Nhập Section Main-Title" class="form-control" required />
                    </div>
                </div>
            </div>
            <div v-for="(question, index) in formData.data.question" :key="index" class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>{{ `Question ${index + 1} ` }}: <small>({{ formLang }})</small></label>
                        <input v-model="question.title" @input="setQuestionTitleForLang(question.title, index)"
                            type="text" placeholder="Nhập Question" class="form-control" required />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>{{ `Answer ${index + 1}` }}: <small>({{ formLang }})</small></label>
                        <input v-model="question.answer" @input="setQuestionAnswerForLang(question.answer, index)"
                            type="text" placeholder="Nhập Answer" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Info Title: <small>({{ formLang }})</small></label>
                        <input v-model="formData.data.info.title" @input="setTitleForLang(formData.data.info.title)"
                            type="text" placeholder="Nhập Info Title" class="form-control" required />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Customer Title: <small>({{ formLang }})</small></label>
                        <input v-model="formData.data.info.customer_title"
                            @input="setCustomerTitleForLang(formData.data.info.customer_title)" type="text"
                            placeholder="Nhập Customer Title" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Title Small: <small>({{ formLang }})</small></label>
                        <input v-model="formData.data.info.title_small"
                            @input="setTitleSmallForLang(formData.data.info.title_small)" type="text"
                            placeholder="Nhập Title Small" class="form-control" required />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Title Small Note: <small>({{ formLang }})</small></label>
                        <input v-model="formData.data.info.note_title_small"
                            @input="setTitleSmallNoteForLang(formData.data.info.note_title_small)" type="text"
                            placeholder="Nhập Title Small Note" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label>Hotline Title: <small>({{ formLang }})</small></label>
                        <input v-model="formData.data.info.hotline_title"
                            @input="setHotlineTitleForLang(formData.data.info.hotline_title)" type="text"
                            placeholder="Nhập Hotline Title" class="form-control" required />
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Zalo Title: <small>({{ formLang }})</small></label>
                        <input v-model="formData.data.info.zalo_title"
                            @input="setZaloTitleForLang(formData.data.info.zalo_title)" type="text"
                            placeholder="Nhập Zalo Title" class="form-control" required />
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Facebook Title: <small>({{ formLang }})</small></label>
                        <input v-model="formData.data.info.fb_title"
                            @input="setFacebookTitleForLang(formData.data.info.fb_title)" type="text"
                            placeholder="Nhập Facebook Title" class="form-control" required />
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>Fanpage Title: <small>({{ formLang }})</small></label>
                        <input v-model="formData.data.info.fanpage_title"
                            @input="setFanpageTitleForLang(formData.data.info.fanpage_title)" type="text"
                            placeholder="Nhập Fanpage Title" class="form-control" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div v-for="(imgKh, index) in formData.data.images_kh" :key="index" class="col-3">
                    <div class="form-group">
                        <label>{{ `Images Khách Hàng ${index + 1}:` }}</label>
                        <input type="file" :ref="`image_kh_${index}`" class="form-control"
                            onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_about_img_kh').attr('src', event.target.result)}"
                            accept="image/jpeg, image/png">
                        <div class="text-center mt-4 bg-black p-2">
                            <img class="show_about_img_kh" :src="imgKh" alt="img khách hàng" height="250"
                                style="border: 1px dashed #fff">
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
                data: {
                    info: {
                        customer_title: [],
                        fanpage_title: [],
                        fb_title: [],
                        hotline_title: [],
                        note_title_small: [],
                        title: [],
                        title_small: [],
                        zalo_title: []
                    },
                    question: [
                        { title: [], answer: [] },
                        { title: [], answer: [] },
                        { title: [], answer: [] },
                        { title: [], answer: [] },
                    ]
                }
            }
        };
    },
    created() {
        this.formData = this.data.data;
        console.log(this.formData);
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
                this.formDataLang.main_title[lang] = this.formData.main_title.split(`[:${lang}]`)[1];
                this.formDataLang.data.info.customer_title[lang] = this.formData.data.info.customer_title.split(`[:${lang}]`)[1];
                this.formDataLang.data.info.fanpage_title[lang] = this.formData.data.info.fanpage_title.split(`[:${lang}]`)[1];
                this.formDataLang.data.info.fb_title[lang] = this.formData.data.info.fb_title.split(`[:${lang}]`)[1];
                this.formDataLang.data.info.hotline_title[lang] = this.formData.data.info.hotline_title.split(`[:${lang}]`)[1];
                this.formDataLang.data.info.note_title_small[lang] = this.formData.data.info.note_title_small.split(`[:${lang}]`)[1];
                this.formDataLang.data.info.title[lang] = this.formData.data.info.title.split(`[:${lang}]`)[1];
                this.formDataLang.data.info.title_small[lang] = this.formData.data.info.title_small.split(`[:${lang}]`)[1];
                this.formDataLang.data.info.zalo_title[lang] = this.formData.data.info.zalo_title.split(`[:${lang}]`)[1];

                this.formDataLang.data.question.forEach((item, idx) => {
                    this.formDataLang.data.question[idx].title[lang] = this.formData.data.question[idx].title.split(`[:${lang}]`)[1];
                    this.formDataLang.data.question[idx].answer[lang] = this.formData.data.question[idx].answer.split(`[:${lang}]`)[1];
                });
            });
            this.changeFormLangAction();
        },
        changeFormLangAction() {
            this.formData.main_title = this.formDataLang.main_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.data.info.customer_title = this.formDataLang.data.info.customer_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.data.info.fanpage_title = this.formDataLang.data.info.fanpage_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.data.info.fb_title = this.formDataLang.data.info.fb_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.data.info.hotline_title = this.formDataLang.data.info.hotline_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.data.info.note_title_small = this.formDataLang.data.info.note_title_small[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.data.info.title = this.formDataLang.data.info.title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.data.info.title_small = this.formDataLang.data.info.title_small[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.formData.data.info.zalo_title = this.formDataLang.data.info.zalo_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');

            this.formData.data.question.forEach((item, idx) => {
                this.formData.data.question[idx].title = this.formDataLang.data.question[idx].title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
                this.formData.data.question[idx].answer = this.formDataLang.data.question[idx].answer[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            });
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
            let langMainTitle = '',
                infoTitles = {},
                questionTitles = [],
                questionAnswers = [];

            // Initialize arrays to hold the language-specific strings
            Object.keys(this.formDataLang.data.info).forEach(key => {
                infoTitles[key] = '';
            });

            this.formDataLang.data.question.forEach((item, idx) => {
                questionTitles[idx] = '';
                questionAnswers[idx] = '';
            });

            // Process each language
            this.$config.languages.forEach(lang => {
                langMainTitle += typeof this.formDataLang.main_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.main_title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.main_title[lang]}[:${lang}]` :
                        this.formDataLang.main_title[lang]);

                // Process info titles
                Object.keys(this.formDataLang.data.info).forEach(key => {
                    infoTitles[key] += typeof this.formDataLang.data.info[key][lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                        (!this.formDataLang.data.info[key][lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.formDataLang.data.info[key][lang]}[:${lang}]` :
                            this.formDataLang.data.info[key][lang]);
                });

                // Process question titles and answers
                this.formDataLang.data.question.forEach((item, idx) => {
                    questionTitles[idx] += typeof this.formDataLang.data.question[idx].title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                        (!this.formDataLang.data.question[idx].title[lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.formDataLang.data.question[idx].title[lang]}[:${lang}]` :
                            this.formDataLang.data.question[idx].title[lang]);

                    questionAnswers[idx] += typeof this.formDataLang.data.question[idx].answer[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                        (!this.formDataLang.data.question[idx].answer[lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.formDataLang.data.question[idx].answer[lang]}[:${lang}]` :
                            this.formDataLang.data.question[idx].answer[lang]);
                });
            });

            // Assign processed data to formDataRequest
            this.formDataRequest.main_title = langMainTitle;

            // Assign info titles
            Object.keys(infoTitles).forEach(key => {
                this.formDataRequest.data.info[key] = infoTitles[key];
            });

            // Assign question titles and answers
            this.formDataLang.data.question.forEach((item, idx) => {
                this.formDataRequest.data.question[idx].title = questionTitles[idx];
                this.formDataRequest.data.question[idx].answer = questionAnswers[idx];
            });
        },
        // convertRequestDataLang() {
        //     this.formDataRequest = Object.assign({}, this.formData);
        //     let langMainTitle = '',
        //         langContentTitle = [],
        //         langContentChild = [];
        //     this.formDataLang.content.forEach((item, idx) => {
        //         langContentTitle[idx] = '';
        //         langContentChild[idx] = [];
        //         langContentChild[idx]['child'] = [];
        //         this.formDataLang.content[idx].child.forEach((item2, idx2) => {
        //             langContentChild[idx]['child'][idx2] = [];
        //             langContentChild[idx]['child'][idx2]['text'] = '';
        //         });
        //     });

        //     this.$config.languages.forEach(lang => {
        //         langMainTitle += typeof this.formDataLang.main_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
        //             (!this.formDataLang.main_title[lang].includes(`[:${lang}]`) ?
        //                 `[:${lang}]${this.formDataLang.main_title[lang]}[:${lang}]` :
        //                 this.formDataLang.main_title[lang]);

        //         this.formDataLang.content.forEach((item, idx) => {
        //             langContentTitle[idx] += typeof this.formDataLang.content[idx].title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
        //                 (!this.formDataLang.content[idx].title[lang].includes(`[:${lang}]`) ?
        //                     `[:${lang}]${this.formDataLang.content[idx].title[lang]}[:${lang}]` :
        //                     this.formDataLang.content[idx].title[lang]);

        //             this.formDataLang.content[idx].child.forEach((item2, idx2) => {
        //                 langContentChild[idx]['child'][idx2]['text'] += typeof this.formDataLang.content[idx].child[idx2].text === 'undefined' ? `[:${lang}][:${lang}]` :
        //                     (!this.formDataLang.content[idx].child[idx2].text[lang].includes(`[:${lang}]`) ?
        //                         `[:${lang}]${this.formDataLang.content[idx].child[idx2].text[lang]}[:${lang}]` :
        //                         this.formDataLang.content[idx].child[idx2].text[lang]);
        //             });
        //         });
        //     });

        //     this.formDataRequest.main_title = langMainTitle;

        //     this.formDataLang.content.forEach((item, idx) => {
        //         this.formDataRequest.content[idx].title = langContentTitle[idx];

        //         this.formDataRequest.content[idx].child.forEach((item2, idx2) => {
        //             this.formDataRequest.content[idx].child[idx2].text = langContentChild[idx]['child'][idx2]['text'];
        //         });
        //     });
        // },
        // Hàm set cho formDataLang
        setMainTitleForLang(main_title) {
            this.formDataLang.main_title[this.formLang] = `[:${this.formLang}]${main_title}[:${this.formLang}]`;
        },
        setCustomerTitleForLang(customer_title) {
            this.formDataLang.data.info.customer_title[this.formLang] = `[:${this.formLang}]${customer_title}[:${this.formLang}]`;
        },
        setFanpageTitleForLang(fanpage_title) {
            this.formDataLang.data.info.fanpage_title[this.formLang] = `[:${this.formLang}]${fanpage_title}[:${this.formLang}]`;
        },
        setFacebookTitleForLang(fb_title) {
            this.formDataLang.data.info.fb_title[this.formLang] = `[:${this.formLang}]${fb_title}[:${this.formLang}]`;
        },
        setHotlineTitleForLang(hotline_title) {
            this.formDataLang.data.info.hotline_title[this.formLang] = `[:${this.formLang}]${hotline_title}[:${this.formLang}]`;
        },
        setTitleSmallNoteForLang(note_title_small) {
            this.formDataLang.data.info.note_title_small[this.formLang] = `[:${this.formLang}]${note_title_small}[:${this.formLang}]`;
        },
        setTitleForLang(title) {
            this.formDataLang.data.info.title[this.formLang] = `[:${this.formLang}]${title}[:${this.formLang}]`;
        },
        setTitleSmallForLang(title_small) {
            this.formDataLang.data.info.title_small[this.formLang] = `[:${this.formLang}]${title_small}[:${this.formLang}]`;
        },
        setZaloTitleForLang(zalo_title) {
            this.formDataLang.data.info.zalo_title[this.formLang] = `[:${this.formLang}]${zalo_title}[:${this.formLang}]`;
        },
        setQuestionTitleForLang(title, index) {
            this.formDataLang.data.question[index].title[this.formLang] = `[:${this.formLang}]${title}[:${this.formLang}]`;
        },
        setQuestionAnswerForLang(answer, index) {
            this.formDataLang.data.question[index].answer[this.formLang] = `[:${this.formLang}]${answer}[:${this.formLang}]`;
        },

        collectFiles() {
            const formData = new FormData();
            this.formData.data.images_kh.forEach((_, index) => {
                const imgKH = this.$refs[`image_kh_${index}`]?.[0] ?? null;
                if (imgKH && imgKH.files.length > 0) {
                    formData.append(`image_kh_${index}`, imgKH.files[0]);
                } else {
                    formData.append(`image_kh_${index}`, null);
                }
            });
            return formData;
        }
    }
};
</script>
