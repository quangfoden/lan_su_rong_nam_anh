<template>
    <div class="add_partner">
        <div class="row">
            <div class="row d-flex justify-content-center">
                <div class="card-body">
                    <div class="col-md-8 offset-2 card show border border-0 p-4">
                        <h4 class="card-title text-center fs-4 mb-4">
                            Chi tiết sản phẩm
                            <button class="btn btn-all-add-edit ml-1" @click="toggleEdit">
                                <i v-if="!isDisabled" class="fas fa-lock"></i>
                                <i v-if="isDisabled" class="fas fa-lock-open"></i>
                            </button>
                            <span class="lang_selector form-group col-2 p-0">
                                <select v-model="formLang" class="form-select" @change="changeFormLang">
                                    <option v-for="(lang, key) in $config.langOptions" :key="key" :value="key">
                                        {{ lang }}
                                    </option>
                                </select>
                            </span>
                        </h4>
                        <form @submit.prevent="updateProduct">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên <sup class="text-red">*</sup></label>
                                        <input v-model="data.name" @input="setNameForLang(data.name)" type="text"
                                            placeholder="Nhập tên sản phẩm" class="form-control" required
                                            :disabled="isDisabled" />
                                    </div>
                                    <div class="form-group">
                                        <label>Mô tả <sup class="text-red">*</sup></label>
                                        <textarea class="form-control" v-model="data.des"
                                            @input="setDesForLang(data.des)" cols="30" rows="5"
                                            placeholder="Nhập miêu tả" required :disabled="isDisabled"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Giá</label>
                                        <input v-model="formattedPrice" @input="updatePrice" type="text"
                                            placeholder="Nhập giá" class="form-control" :disabled="isDisabled" />
                                    </div>
                                    <div class="form-group">
                                        <label>Is Hot</label>
                                        <select
                                            class="form-select form-control"
                                            v-model="data.is_hot"
                                            :disabled="isDisabled"
                                        >
                                            <option value="1">Có</option>
                                            <option value="0" selected>Không</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h5 class="mb-4">Hình ảnh sản phẩm</h5>
                            <div class="row">
                                <div id="formGameImages" class="col-12">
                                    <div class="form-group bg_img">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Background Image: <sup class="text-red">*</sup></label>
                                                <input type="file" class="form-control" ref="bg_img"
                                                    onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_bg_img').attr('src', event.target.result)}"
                                                    accept="image/jpeg, image/png" :disabled="isDisabled">
                                            </div>
                                            <div class="col-8 text-center">
                                                <img class="show_bg_img" :src="data.bg_img" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group art_img">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Image Details: <sup class="text-red">*</sup></label>
                                                <input type="file" class="form-control" ref="details_img"
                                                    onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_art_img').attr('src', event.target.result)}"
                                                    accept="image/jpeg, image/png" :disabled="isDisabled">
                                            </div>
                                            <div class="col-8 text-center">
                                                <img class="show_art_img" :src="data.details_img" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group art_img">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Image Cover: <sup class="text-red">*</sup></label>
                                                <input type="file" class="form-control" ref="img_cover"
                                                    onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_art_img').attr('src', event.target.result)}"
                                                    accept="image/jpeg, image/png" :disabled="isDisabled">
                                            </div>
                                            <div class="col-8 text-center">
                                                <img class="show_art_img" :src="data.img_cover" alt="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-all-add-edit mr-2 mt-2" :disabled="isDisabled">
                                    Cập Nhật Sản Phẩm
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
    data() {
        return {
            data: {},
            isDisabled: true,
            requestData: {},
            formattedPrice: '',
            dataLang: {
                name: [],
                des: []
            },
            formLang: this.$config.languages[0]
        };
    },
    created() {
        this.getProduct(this.$route.params.id);
    },
    computed: {
       
    },
    methods: {
        ...mapActions(["logout"]),
        toggleEdit() {
            this.isDisabled = !this.isDisabled;
        },
        getProduct(productId) {
            this.axios
                .get(`/api/admin/products/${productId}`)
                .then((response) => {
                    if (response.data.status === 200) {
                        if (response.data.data) {
                            this.data = response.data.data;
                             this.formattedPrice = this.data.price ?new Intl.NumberFormat('vi-VN').format(this.data.price ) : ''
                            this.convertResponseData();
                        }
                    }
                })
                .catch((error) => {
                    if (error.response.status === 403) {
                        this.logout();
                    }
                    if (error.response.status === 401) {
                        this.logout();
                    }
                });
        },
        updateProduct() {
            this.isDisabled = true;
            this.convertRequestDataLang();
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
            const formData = new FormData();
            formData.append('name', this.requestData.name);
            formData.append('price', this.data.price);
            formData.append('des', this.requestData.des);
            formData.append('details_img', this.$refs.details_img.files[0] ?? '');
            formData.append('bg_img', this.$refs.bg_img.files[0] ?? '');
            formData.append('img_cover', this.$refs.img_cover.files[0] ?? '');
            formData.append('is_hot', this.data.is_hot);
            this.axios
                .post(`/api/admin/products/${this.data.id}/update`, formData)
                .then((response) => {
                    if (response.data.status === 200 && response.data.success) {
                        this.isDisabled = true;
                        this.$swal.close(swalLoading);
                        this.$swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: this.$config.notificationTimer ?? 1000,
                        })
                        this.getProduct(this.data.id);
                    } else if (response.data.status === 200 && !response.data.success) {
                        this.isDisabled = false;
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
                        text: `Error ${error.response.status}: ${error.response.data.message}`,
                    });
                });
        },
        convertResponseData() {
            this.$config.languages.forEach(lang => {
                this.dataLang.name[lang] = this.data.name.split(`[:${lang}]`)[1];
                this.dataLang.des[lang] = this.data.des.split(`[:${lang}]`)[1];
            });
            this.changeFormLang();
        },
        changeFormLang() {
            this.data.name = this.dataLang.name[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.data.des = this.dataLang.des[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
        },
        setNameForLang(name) {
            this.dataLang.name[this.formLang] = `[:${this.formLang}]${name}[:${this.formLang}]`;
        },
        setDesForLang(des) {
            this.dataLang.des[this.formLang] = `[:${this.formLang}]${des}[:${this.formLang}]`;
        },
        convertRequestDataLang() {
            this.requestData = Object.assign({}, this.data);
            let langName = '', langDes = '';
            this.$config.languages.forEach(lang => {

                langName += typeof this.dataLang.name[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (
                        !this.dataLang.name[lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.dataLang.name[lang]}[:${lang}]` :
                            this.dataLang.name[lang]
                    );

                langDes += typeof this.dataLang.des[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                    (
                        !this.dataLang.des[lang].includes(`[:${lang}]`) ?
                            `[:${lang}]${this.dataLang.des[lang]}[:${lang}]` :
                            this.dataLang.des[lang]
                    );

            });

            this.requestData.name = langName;
            this.requestData.des = langDes;
        },
        updatePrice(event) {
            let value = event.target.value.replace(/,/g, '');
            this.data.price = parseFloat(value) || 0;
            this.formattedPrice = this.formatNumber(this.data.price);
        },
        formatPrice() {
            this.formattedPrice = this.formatNumber(this.data.price);
        },
        formatNumber(value) {
            return value.toLocaleString('en-US');
        },

    },
};
</script>
