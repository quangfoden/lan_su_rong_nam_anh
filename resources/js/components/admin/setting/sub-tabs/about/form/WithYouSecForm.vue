<template>
    <div class="settings_form_wrapper col-12">
        <h4 class="text-center mb-2 text-decoration-underline collapsed" data-toggle="collapse"
            data-target="#collapseWithYouSec" aria-expanded="false">
            Video Overview Settings
        </h4>
        <div id="collapseWithYouSec" class="form_collapse collapse">
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
                        <label>VIDEO:</label>
                        <input type="file" ref="life_with_you_video" class="form-control"
                            onchange="const reader = new FileReader(); reader.readAsDataURL(this.files[0]); reader.onload = (event) => { $(this).parents('.form-group').find('video source').attr('src', event.target.result); $(this).parents('.form-group').find('video')[0].load(); }"
                            accept="video/mp4, video/ogg, video/webm">
                        <div class="text-center mt-4 bg-black p-2">
                            <video height="250" style="border: 1px dashed #fff" controls>
                                <source :src="formData.video" type="video/mp4">
                                Trình duyệt của bạn không hỗ trợ thẻ video.
                            </video>
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
                this.formDataLang.main_title[lang] = this.formData.main_title.split(`[:${lang}]`)[1];
            });
            this.changeFormLangAction();
        },
        changeFormLangAction() {
            this.formData.main_title = this.formDataLang.main_title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
            let langMainTitle = ''
            this.$config.languages.forEach(lang => {
                langMainTitle += typeof this.formDataLang.main_title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (!this.formDataLang.main_title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.formDataLang.main_title[lang]}[:${lang}]` :
                        this.formDataLang.main_title[lang]);
            })
            this.formDataRequest.main_title = langMainTitle;
        },
        setMainTitleForLang(main_title) {
            this.formDataLang.main_title[this.formLang] = `[:${this.formLang}]${main_title}[:${this.formLang}]`;
        },
    }
};
</script>
