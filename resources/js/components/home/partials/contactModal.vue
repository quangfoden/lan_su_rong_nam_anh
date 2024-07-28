<template>
    <div class="modal fade contact_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="ct_info">
                                    <h2 class="ff_ss3_bold">{{ convertLang(generalSettings.contact_modal.text) }}</h2>
                                    <h5 class="ff_ss3_bold">{{ convertLang(generalSettings.contact_modal.question) }}</h5>
                                    <p>{{ convertLang(generalSettings.contact_modal.answer) }}</p>
                                </div>
                                <div class="ct_form">
                                    <form @submit.prevent="sendContact">
                                        <div class="row">
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label>{{ $t('placeholder.contact_popup.name') }}</label>
                                                    <input
                                                        type="text"
                                                        :placeholder="$t('placeholder.contact_popup.name')"
                                                        class="form-control"
                                                        v-model="form.name"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" placeholder="Email" class="form-control"
                                                           v-model="form.email" required/>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>{{ $t('placeholder.contact_popup.subject') }}</label>
                                                    <input
                                                        type="text"
                                                        :placeholder="$t('placeholder.contact_popup.subject')"
                                                        class="form-control"
                                                        v-model="form.subject"
                                                        required
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>{{ $t('placeholder.contact_popup.message') }}</label>
                                                    <textarea
                                                        class="form-control"
                                                        :placeholder="$t('placeholder.contact_popup.message')"
                                                        cols="30"
                                                        rows="5"
                                                        v-model="form.message"
                                                        required
                                                    ></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <button
                                                    type="submit"
                                                    class="btn btn-all-add-edit w-25"
                                                    :disabled="isSending"
                                                >
                                                    {{ $t('button.contact_submit') }}
                                                </button>
                                            </div>
                                        </div>
                                    </form>
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

import {i18n} from "../../../app";

export default {
    data() {
        return {
            form: {
                name: null,
                email: null,
                subject: null,
                message: null
            },
            isSending: false,
            generalSettings: {}
        };
    },
    created() {
        this.generalSettings = JSON.parse(localStorage.getItem('general'));
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    methods: {
        sendContact() {
            this.isSending = true;
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
                .post("/api/send-contact", this.form)
                .then((response) => {
                    if (response.data.status === 200 && response.data.success) {
                        this.$swal.close(swalLoading);
                        this.$swal.fire({
                            position: "center-center",
                            icon: "success",
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: this.$config.notificationTimer ?? 1000,
                        });
                        this.form.name = this.form.email = this.form.subject = this.form.message = null;
                    } else if (response.data.status === 200 && !response.data.success) {
                        this.$swal.close(swalLoading);
                        this.$swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: `Error ${response.data.message}`
                        });
                    }
                    this.isSending = false;
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
                    this.isSending = false;
                });
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        }
    }
};
</script>
