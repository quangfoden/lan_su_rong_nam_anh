<template>
    <div class="settings_wrapper">
        <form id="lifeForm">
            <div class="sticky_group">
                <a class="btn_save_settings btn btn-all-add-edit" @click="saveLifeSettings">Lưu cài đặt</a>
                <span class="lang_selector form-group">
                    <select v-model="formLang" class="form-select" @change="changeFormLang">
                        <option v-for="(lang, key) in $config.langOptions" :key="key" :value="key">
                            {{ lang }}
                        </option>
                    </select>
                </span>
            </div>
            <div v-for="(val, idx) in data" :key="idx" class="row">
                <OurValueSecForm v-if="val.name === 'Life Our Value Sec.'" :data="val" :formLang="formLang"
                    ref="OurValueSecForm" />
                <WithYouSecForm v-if="val.name === 'Life With You Sec.'" :data="val" :formLang="formLang"
                    ref="WithYouSecForm" />
                <HowWeHireSecForm v-if="val.name === 'Life How We Hire Sec.'" :data="val" :formLang="formLang"
                    ref="HowWeHireSecForm" />
            </div>
        </form>
    </div>
</template>

<script>
import OurValueSecForm from "./form/OurValueSecForm.vue";
import WithYouSecForm from "./form/WithYouSecForm.vue";
import HowWeHireSecForm from "./form/HowWeHireSecForm.vue";

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
        OurValueSecForm, WithYouSecForm, HowWeHireSecForm
    },
    data() {
        return {
            currentLifeData: [],
            formLang: this.$config.languages[0]
        };
    },
    created() {
        const me = this;
        this.$nextTick(() => {
            me.convertResponseData();
        });
    },
    computed: {},
    methods: {
        convertResponseData() {
            this.emitter.emit("is-converting-response-data-life", true);
        },
        changeFormLang() {
            this.emitter.emit("is-change-form-lang-life", true);
        },
        saveLifeSettings() {
            this.emitter.emit("is-saving-life-tab", true);

            const OurValueSecFormData = JSON.stringify(Object.keys(this.$refs.OurValueSecForm[0].formDataRequest).map((key) =>
                [key, this.$refs.OurValueSecForm[0].formDataRequest[key]]
            ));
            const WithYouSecFormData = JSON.stringify(Object.keys(this.$refs.WithYouSecForm[0].formDataRequest).map((key) =>
                [key, this.$refs.WithYouSecForm[0].formDataRequest[key]]
            ));
            const HowWeHireSecFormData = JSON.stringify(Object.keys(this.$refs.HowWeHireSecForm[0].formDataRequest).map((key) =>
                [key, this.$refs.HowWeHireSecForm[0].formDataRequest[key]]
            ));

            const chars = {
                ' ': '_',
                '.': ''
            };

            function setData(slug) {
                switch (slug) {
                    case ('life_our_value_sec'):
                        return OurValueSecFormData;
                    case ('life_with_you_sec'):
                        return WithYouSecFormData;
                    case ('life_how_we_hire_sec'):
                        return HowWeHireSecFormData;
                }
            }

            this.data.forEach((item) => {
                let slug = item.name.replace(/[ .]/g, m => chars[m]).toLowerCase();
                this.currentLifeData[slug] = JSON.stringify([item.name, setData(slug)]);
            });

            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('life_our_value_sec', this.currentLifeData['life_our_value_sec']);
            formData.append('life_with_you_sec', this.currentLifeData['life_with_you_sec']);
            formData.append('life_how_we_hire_sec', this.currentLifeData['life_how_we_hire_sec']);

            // check Life file inputs
            const lifeOurValueMainBG = this.$refs.OurValueSecForm[0].$refs.life_our_value_main_bg.files[0] ?? null;
            const lifeOurValueContentBg1 = this.$refs.OurValueSecForm[0].$refs.life_our_value_content_bg_1[0].files[0] ?? null;
            const lifeOurValueContentBg2 = this.$refs.OurValueSecForm[0].$refs.life_our_value_content_bg_2[0].files[0] ?? null;
            const lifeOurValueContentBg3 = this.$refs.OurValueSecForm[0].$refs.life_our_value_content_bg_3[0].files[0] ?? null;
            const lifeOurValueContentBg4 = this.$refs.OurValueSecForm[0].$refs.life_our_value_content_bg_4[0].files[0] ?? null;
            const lifeOurValueContentBg5 = this.$refs.OurValueSecForm[0].$refs.life_our_value_content_bg_5[0].files[0] ?? null;
            formData.append('life_our_value_main_bg', lifeOurValueMainBG);
            formData.append('life_our_value_content_bg_1', lifeOurValueContentBg1);
            formData.append('life_our_value_content_bg_2', lifeOurValueContentBg2);
            formData.append('life_our_value_content_bg_3', lifeOurValueContentBg3);
            formData.append('life_our_value_content_bg_4', lifeOurValueContentBg4);
            formData.append('life_our_value_content_bg_5', lifeOurValueContentBg5);

            const lifeWithYouVideo = this.$refs.WithYouSecForm[0].$refs.life_with_you_video.files[0] ?? null;
            formData.append('life_with_you_video', lifeWithYouVideo);

            const HowWeHireImgKh = this.$refs.HowWeHireSecForm[0]?.collectFiles();
            if (HowWeHireImgKh && HowWeHireImgKh instanceof FormData) {
                for (const [key, value] of HowWeHireImgKh.entries()) {
                    formData.append(key, value);
                }
            } else {
                console.log('No data returned from collectFiles.');
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
