<template>
    <div class="add_partner">
        <div class="row">
            <div class="row d-flex justify-content-center">
                <div class="card-body">
                    <div class="col-md-8 offset-md-2 card show border border-0 p-4">
                        <h4 class="card-title text-center fs-4 mb-5">
                            Thêm Danh Mục
                            <span class="lang_selector form-group col-2 p-0">
                                <select
                                    v-model="formLang"
                                    class="form-select"
                                    @change="changeFormLang"
                                >
                                    <option
                                        v-for="(lang, key) in $config.langOptions"
                                        :key="key"
                                        :value="key"
                                    >
                                        {{ lang }}
                                    </option>
                                </select>
                            </span>
                        </h4>
                        <form @submit.prevent="addCategory">
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group">
                                        <label>Title <sup class="text-red">*</sup></label>
                                        <input
                                            v-model="data.title"
                                            @input="convertSlug(data.title);setTitleForLang(data.title)"
                                            type="text"
                                            placeholder="Nhập tên"
                                            class="form-control"
                                            required
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>Slug <sup class="text-red">*</sup></label>
                                        <input
                                            v-model="data.slug"
                                            type="text"
                                            placeholder="Nhập slug"
                                            class="form-control"
                                            required
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea
                                            class="form-control"
                                            v-model="data.desc"
                                            @input="setDescForLang(data.desc)"
                                            cols="30"
                                            rows="5"
                                            placeholder="Nhập miêu tả"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="form-group">
                                        <label>Parent Category</label>
                                        <select class="form-select" v-model="data.parent_id">
                                            <option
                                                v-for="(opt, idx) in parentOpts"
                                                :key="idx"
                                                :value="opt.id"
                                            >
                                                {{ convertLang(opt.title) }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Active</label>
                                        <select class="form-select" v-model="data.active">
                                            <option value="1" selected>Hoạt Động</option>
                                            <option value="0">Tạm Ngừng</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-all-add-edit mr-2 mt-2">
                                    Thêm Danh Mục
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
import {mapActions} from "vuex";
import router from "../../../../router";

export default {
    data() {
        return {
            data: {},
            dataTmp: {
                title: '',
                slug: '',
                desc: '',
                active: 1,
                parent_id: '',
            },
            requestData: {},
            dataLang: {
                title: [],
                desc: []
            },
            parentOpts: [],
            formLang: this.$config.languages[0]
        };
    },
    created() {
        this.data = this.dataTmp;
        this.getCategoryOpts();
    },
    computed: {},
    methods: {
        ...mapActions(["logout"]),
        addCategory() {
            this.data.active = this.data.active ? 1 : 0;
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
            this.axios
                .post("/api/admin/category/store", this.requestData)
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
                        router.push(`/admin/category-manager/detail/${response.data.data_id}`);
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
        getCategoryOpts() {
            this.axios
                .get("/api/admin/category/category-opts")
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.parentOpts = response.data.data;
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
        convertSlug(title) {
            let str = title.toLowerCase();
            str = str.replace(/\W+/g, "-").replace(/^-+|-+$/g, "");
            this.data.slug = str.replace(/[^0-9a-z-]+/g, "");
        },
        changeFormLang() {
            this.data.title = this.dataLang.title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
            this.data.desc = this.dataLang.desc[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
        },
        setTitleForLang(title) {
            this.dataLang.title[this.formLang] = `[:${this.formLang}]${title}[:${this.formLang}]`;
        },
        setDescForLang(desc) {
            this.dataLang.desc[this.formLang] = `[:${this.formLang}]${desc}[:${this.formLang}]`;
        },
        convertRequestDataLang() {
            this.requestData = Object.assign({}, this.data);
            let langTitle = '', langDesc = '';
            this.$config.languages.forEach(lang => {
                langTitle += typeof this.dataLang.title[lang] === 'undefined' ?
                    `[:${lang}][:${lang}]` : this.dataLang.title[lang];
                langDesc += typeof this.dataLang.desc[lang] === 'undefined' ?
                    `[:${lang}][:${lang}]` : this.dataLang.desc[lang];
            });

            this.requestData.title = langTitle;
            this.requestData.desc = langDesc;
        },
        convertLang(text) {
            return text.split(`[:${this.formLang}]`)[1] ?? text
        }
    },
};
</script>
