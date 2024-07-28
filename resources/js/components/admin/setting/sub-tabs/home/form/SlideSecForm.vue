<template>
    <div class="settings_form_wrapper col-12">
        <h4 class="text-center mb-2 text-decoration-underline collapsed" data-toggle="collapse"
            data-target="#collapseSlide" aria-expanded="false">
            {{ data.name }} Settings
        </h4>
        <div id="collapseSlide" class="form_collapse collapse">
            <div v-for="(data, index) in formData" :key="index" class="row p-2">
                <h5>Slide{{ index + 1 }}</h5>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label>Slide-big:</label>
                        <input type="file" :ref="`slide_big_${index}`" class="form-control"
                            onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_home_favicon').attr('src', event.target.result)}"
                            accept="image/jpeg, image/png">
                        <div class="text-center mt-4 bg-black p-2">
                            <img class="show_home_favicon" :src="data.img" alt="favicon" width="300" height="300"
                                style="border: 1px dashed #fff">
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="form-group">
                        <label>slide-small:</label>
                        <input type="file" :ref="`slide_small_${index}`" class="form-control"
                            onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_home_logo').attr('src', event.target.result)}"
                            accept="image/jpeg, image/png">
                        <div class="text-center mt-4 bg-black p-2">
                            <img class="show_home_logo" :src="data.img_small" alt="logo" width="300" height="300"
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
    },
    data() {
        return {
            formData: {},
            formDataRequest:{}
        };
    },
    created() {
        this.formData = this.data.data;
    },
    mounted() {
        this.emitter.on("is-saving-home-tab", isSavingHomeTab => {
            if (isSavingHomeTab) {
                this.convertRequestDataLang();
            }
        });
    },
    computed: {},
    methods: {
        collectFiles() {
            const formData = new FormData();

            this.formData.forEach((_, index) => {
                const slideBigInput = this.$refs[`slide_big_${index}`]?.[0] ?? null;
                const slideSmallInput = this.$refs[`slide_small_${index}`]?.[0] ?? null;

                if (slideBigInput && slideBigInput.files.length > 0) {
                    formData.append(`slide_img_big_${index}`, slideBigInput.files[0]);
                } else {
                    formData.append(`slide_img_big_${index}`, null);
                }

                if (slideSmallInput && slideSmallInput.files.length > 0) {
                    formData.append(`slide_img_small_${index}`, slideSmallInput.files[0]);
                } else {
                    formData.append(`slide_img_small_${index}`, null);
                }
            });

            return formData;
        },
        convertRequestDataLang() {
            this.formDataRequest = Object.assign({}, this.formData);
        }
    }
};
</script>
