<template>
    <div class="add_partner">
        <div class="row">
            <div class="row d-flex justify-content-center">
                <div class="card-body">
                    <div class="col-md-8 offset-md-2 card show border border-0 p-4">
                        <h4 class="card-title text-center fs-4 mb-4">
                            Thêm sản phẩm
                            <span class="lang_selector form-group col-2 p-0">
                                <select v-model="formLang" class="form-select" @change="changeFormLang">
                                    <option v-for="(lang, key) in $config.langOptions" :key="key" :value="key">
                                        {{ lang }}
                                    </option>
                                </select>
                            </span>
                        </h4>
                        <form @submit.prevent="addProducts">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Tên <sup class="text-red">*</sup></label>
                                        <input v-model="data.name" @input="setNameForLang(data.name)" type="text"
                                            placeholder="Nhập tên sản phẩm" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <label>Mô tả <sup class="text-red">*</sup></label>
                                        <textarea class="form-control" v-model="data.des"
                                            @input="setDesForLang(data.des)" cols="30" rows="5"
                                            placeholder="Nhập miêu tả" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Giá <sup class="text-red">*</sup></label>
                                        <input v-model="formattedPrice" @input="updatePrice" @blur="formatPrice"
                                            type="text" step="0.01" placeholder="Nhập giá" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Is Hot</label>
                                        <select class="form-select form-control" v-model="data.is_hot">
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
                                                    accept="image/jpeg, image/png" required>
                                            </div>
                                            <div class="col-8 text-center">
                                                <img class="show_bg_img" src="" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group art_img">
                                        <div class="row">
                                            <div class="col-4">
                                                <label>Image Details: <sup class="text-red">*</sup></label>
                                                <input type="file" class="form-control" ref="details_img"
                                                    onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_art_img').attr('src', event.target.result)}"
                                                    accept="image/jpeg, image/png" required>
                                            </div>
                                            <div class="col-8 text-center">
                                                <img class="show_art_img" src="" alt="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-all-add-edit mr-2 mt-2">
                                    Thêm sản phẩm
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
import router from "@resources/js/router/index";

export default {
    data() {
        return {
            data: {},
            dataTmp: {
                name: '',
                des: '',
                price: '',
                bg_img: '',
                details_img: '',
                is_hot:0,
            },
            formattedPrice: '',
            requestData: {},
            dataLang: {
                name: [],
                des: []
            },
            formLang: this.$config.languages[0]
        };
    },
    created() {
        this.data = this.dataTmp;
    },
    computed: {},
    methods: {
        ...mapActions(["logout"]),
        addProducts() {
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
            formData.append('des', this.requestData.des);
            formData.append('price', this.data.price);
            formData.append('bg_img', this.$refs.bg_img.files[0]);
            formData.append('details_img', this.$refs.details_img.files[0]);
            formData.append('is_hot', this.data.is_hot);
            this.axios
                .post("/api/admin/products/store", formData)
                .then((response) => {
                    if (response.data.status === 200 && response.data.success) {
                        this.$swal.close(swalLoading);
                        this.$swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: this.$config.notificationTimer ?? 1000,
                        });
                        router.push(`/admin/product-manager/detail/${response.data.data_id}`);
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
                langName += typeof this.dataLang.name[lang] === 'undefined' ?
                    `[:${lang}][:${lang}]` : this.dataLang.name[lang];
                langDes += typeof this.dataLang.des[lang] === 'undefined' ?
                    `[:${lang}][:${lang}]` : this.dataLang.des[lang];
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
