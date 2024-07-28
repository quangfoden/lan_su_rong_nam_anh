<template>
    <section id="footerSection">
        <div class="container container_2">
            <div class="row">
                <div class="logo_privacy col-12 col-xl-5">
                    <div class="row text-center text-xl-start">
                        <div class="col-12 col-xl-3">
                            <router-link class="footer_logo" to="/">
                                <img style="" :src="generalSettings.logo" width="140" height="35"
                                    class="d-inline-block align-top" alt="logo">
                            </router-link>
                        </div>
                        <div class="col-12 col-xl-9">
                            <div class="privacy_info">
                                <div class="name ff_ss3_bold">
                                    {{ convertLang(generalSettings.privacy.name) }}
                                </div>
                                <div class="address">
                                    {{ convertLang(generalSettings.privacy.address) }}
                                </div>
                                <div v-if="generalSettings.privacy.phone" class="phone">
                                    Phone: {{ generalSettings.privacy.phone }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer_center col-12 col-xl-4">
                    <div class="content_pic">
                        {{ convertLang(generalSettings.footer_center.content) }}
                    </div>
                    <div class="footer-pr">
                        {{ convertLang(generalSettings.footer_center.products) }}
                    </div>
                    <div class="footer-sv">
                        {{ convertLang(generalSettings.footer_center.service) }}
                    </div>
                    <div class="email ff_ss3_bold">
                        <a :href="`mailto:${generalSettings.footer_center.email}`">
                            {{ generalSettings.footer_center.email }}
                        </a>
                    </div>
                </div>
                <div class="contact_hotline text-center text-xl-start col-12 col-xl-3">
                    <div class="info">
                        <button class="btn btn_contact ff_ss3_bold" data-toggle="modal" data-target=".contact_modal">
                            {{ $t('button.contact') }}
                        </button>
                        <a class="link_fb" :href="generalSettings.contact.link_fb" target="_blank">
                            <img src="/assets/images/footer/fb-xam.png" alt="link_fb">
                        </a>
                        <a class="link_tt" :href="generalSettings.contact.link_tt" target="_blank">
                            <img src="/assets/images/footer/tiktok.png" alt="link_tt">
                        </a>
                        <div class="hotline d-inline-block">
                            <div class="ff_ss3_bold">hotline</div>
                            <div class="hl_number">
                                <a :href="`tel:${generalSettings.contact.hotline}`">
                                    {{ commasHotline(generalSettings.contact.hotline) }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <ContactModal />

    <div id="scrollToTop" @click="scrollToTop">
        <i class="fas fa-angle-up"></i>
    </div>
</template>

<script>

import ContactModal from "../partials/contactModal.vue";
import { i18n } from "../../../app";

export default {
    components: {
        ContactModal
    },
    data() {
        return {
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
        commasHotline(number) {
            return number.toString().replace(/\B(?=(\d{4})+(?!\d))/g, ".");
        },
        scrollToTop() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        }
    }
};
</script>
