<template>
    <div class="add_partner">
        <div class="row">
            <div class="row d-flex justify-content-center">
                <div class="card-body">
                    <div class="col-md-12 card show border border-0 p-4">
                        <h4 class="card-title text-center fs-4 mb-4">
                            Post Detail
                            <button class="btn btn-all-add-edit ml-1" @click="toggleEdit">
                                <i v-if="!isDisabled" class="fas fa-lock"></i>
                                <i v-if="isDisabled" class="fas fa-lock-open"></i>
                            </button>
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
                        <form @submit.prevent="updatePost">
                            <div class="row">
                                <div class="col-9">
                                    <div class="form-group">
                                        <label>Title <sup class="text-red">*</sup></label>
                                        <input
                                            v-model="data.title"
                                            @input="setTitleForLang(data.title)"
                                            type="text"
                                            placeholder="Nhập tên"
                                            class="form-control"
                                            required
                                            :disabled="isDisabled"
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
                                            :disabled="isDisabled"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>Source</label>
                                        <input
                                            v-model="data.source"
                                            type="text"
                                            placeholder="Nhập source"
                                            class="form-control"
                                            :disabled="isDisabled"
                                        />
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea
                                            class="form-control"
                                            v-model="data.desc"
                                            @input="setDescForLang(data.desc)"
                                            cols="30"
                                            rows="3"
                                            placeholder="Nhập miêu tả"
                                            :disabled="isDisabled"
                                        ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Content <sup class="text-red">*</sup></label>
                                        <Editor
                                            :api-key="this.$config.tiny_mce.api_key"
                                            v-model="data.content"
                                            :init="{
                                             height: 500,
                                             plugins: this.$config.tiny_mce.plugins,
                                             toolbar: this.$config.tiny_mce.toolbar
                                           }"
                                            :disabled="isDisabled"
                                            @keyPress="setContentForLang(data.content)"
                                            @focusOut="setContentForLang(data.content)"
                                        />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Categories <sup class="text-red">*</sup></label>
                                        <select
                                            id="selectBoxCategories"
                                            class="form-select"
                                            v-model="data.categories_id"
                                            multiple
                                            :disabled="isDisabled"
                                        >
                                            <option
                                                v-for="(opt, idx) in categoryOpts"
                                                :key="idx"
                                                :value="opt.id"
                                            >
                                                {{ convertLang(opt.title) }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Publish Date</label>
                                        <input
                                            class="form-control"
                                            type="date"
                                            v-model="data.publish_date"
                                            :disabled="isDisabled"
                                        >
                                    </div>
                                    <div class="form-group">
                                        <label>Active</label>
                                        <select
                                            class="form-select form-control"
                                            v-model="data.active"
                                            :disabled="isDisabled"
                                        >
                                            <option value="1" selected>Hoạt Động</option>
                                            <option value="0">Tạm Ngừng</option>
                                        </select>
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
                                    <div class="form-group post_img">
                                        <div class="row">
                                            <div class="col-12">
                                                <label>Image:</label>
                                                <input type="file"
                                                       class="form-control"
                                                       ref="post_img"
                                                       onchange="const reader = new FileReader();reader.readAsDataURL(this.files[0]);reader.onload = (event) => {$(this).parents('.form-group').find('.show_post_img').attr('src', event.target.result)}"
                                                       accept="image/jpeg, image/png"
                                                       :disabled="isDisabled"
                                                >
                                            </div>
                                            <div class="col-12 mt-3 text-center">
                                                <img class="show_post_img w-100" :src="data.image" alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-all-add-edit mr-2 mt-2" :disabled="isDisabled">
                                    Cập Nhật Bài Viết
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
import {mapGetters, mapMutations, mapActions} from "vuex";
import Editor from '@tinymce/tinymce-vue';

export default {
    components: {
        Editor
    },
    data() {
        return {
            data: {},
            categoryOpts: [],
            isDisabled: true,
            dataLang: {
              title: [],
              desc: [],
              content: []
            },
            formLang: this.$config.languages[0]
        };
    },
    created() {
        this.getPost(this.$route.params.id);
        this.getCategoryOpts();
    },
    computed: {},
    methods: {
        ...mapActions(["logout"]),
        toggleEdit() {
            this.isDisabled = !this.isDisabled;
        },
        getPost(postId) {
            this.axios
                .get(`/api/admin/post/${postId}`)
                .then((response) => {
                    if (response.data.status === 200) {
                        if (response.data.data) {
                            this.data = response.data.data;
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
        updatePost() {
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
            formData.append('title', this.requestData.title);
            formData.append('slug', this.data.slug);
            formData.append('source', this.data.source);
            formData.append('desc', this.requestData.desc);
            formData.append('content', this.requestData.content);
            formData.append('active', this.data.active);
            formData.append('is_hot', this.data.is_hot);
            formData.append('publish_date', this.data.publish_date);
            formData.append('image', this.$refs.post_img.files[0] ?? '');
            formData.append('categories_id', JSON.stringify($('#selectBoxCategories').val()));
            this.axios
                .post(`/api/admin/post/${this.data.id}/update`, formData)
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
                        });
                        this.getPost(this.data.id);
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
                        text: `Error ${error.response.status}: ${error.response.data.message}`
                    });
                });
        },
        getCategoryOpts() {
            this.axios
                .get("/api/admin/category/category-opts", {params: {for_post: 1}})
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.categoryOpts = response.data.data;
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

            $(document).ready(() => {
                $('#selectBoxCategories').select2({
                    placeholder: "--Chọn Danh Mục--"
                });
            });
        },
        convertResponseData() {
          this.$config.languages.forEach(lang => {
            this.dataLang.title[lang] = this.data.title.split(`[:${lang}]`)[1];
            this.dataLang.desc[lang] = this.data.desc.split(`[:${lang}]`)[1];
            this.dataLang.content[lang] = this.data.content.split(`[:${lang}]`)[1];
          });
          this.changeFormLang();
        },
        changeFormLang() {
          this.data.title = this.dataLang.title[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
          this.data.desc = this.dataLang.desc[this.formLang]?.replaceAll(`[:${this.formLang}]`, '');
          this.data.content = this.dataLang.content[this.formLang]?.replaceAll(`[:${this.formLang}]`, '') ?? '';
        },
        setTitleForLang(title) {
          this.dataLang.title[this.formLang] = `[:${this.formLang}]${title}[:${this.formLang}]`;
        },
        setDescForLang(desc) {
          this.dataLang.desc[this.formLang] = `[:${this.formLang}]${desc}[:${this.formLang}]`;
        },
        setContentForLang(content) {
          this.dataLang.content[this.formLang] = `[:${this.formLang}]${content}[:${this.formLang}]`;
        },
        convertRequestDataLang() {
          this.requestData = Object.assign({}, this.data);
          let langTitle = '', langDesc = '', langContent = '';
          this.$config.languages.forEach(lang => {

            langTitle += typeof this.dataLang.title[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                (
                    !this.dataLang.title[lang].includes(`[:${lang}]`) ?
                        `[:${lang}]${this.dataLang.title[lang]}[:${lang}]` :
                        this.dataLang.title[lang]
                );

            langDesc += typeof this.dataLang.desc[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                (
                    !this.dataLang.desc[lang].includes(`[:${lang}]`) ?
                    `[:${lang}]${this.dataLang.desc[lang]}[:${lang}]` :
                    this.dataLang.desc[lang]
                );

            langContent += typeof this.dataLang.content[lang] === 'undefined' ? `[:${lang}][:${lang}]` :
                (
                    !this.dataLang.content[lang].includes(`[:${lang}]`) ?
                    `[:${lang}]${this.dataLang.content[lang]}[:${lang}]` :
                    this.dataLang.content[lang]
                );

          });

          this.requestData.title = langTitle;
          this.requestData.desc = langDesc;
          this.requestData.content = langContent;
        },
        convertLang(text) {
          return text.split(`[:${this.formLang}]`)[1] ?? text
        }
    },
};
</script>
