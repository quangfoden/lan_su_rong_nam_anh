<template>
    <nav class="navbar navbar-expand-lg fixed-top w-100">
        <div class="top_logo w-25">
            <router-link class="navbar-brand" to="/">
                <img :src="generalSettings.logo" width="140" height="35" class="d-inline-block align-top" alt="logo">
            </router-link>
        </div>
        <div @click="showHideListMenu" id="icon_list_menu"><span><i class="icons fas fa-bars"></i></span></div>
        <div class="top_items text-center w-50">
            <ul class="navbar-nav w-100">
                <li class="nav-item w-25" v-for="(item, idx) in topItems" :key="idx">
                    <a class="nav-link ff_ss3_bold"
                        :class="{ active: (idx === 0 & $route.name === `NamAnh's Home`) || (idx !== 0 && $route.path.includes(item.to)) }"
                        @click="callFunctionLeave(item.to)">
                        {{ item.name }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="top_langs text-right w-25">
            <div id="langSwitch">
                <div class="value" @click="toggleActiveLangOpts">
                    <img :src="`/images/lang/${lang}.png`" :alt="lang">
                    <span>{{ lang }}</span>
                    <i class="fa fa-chevron-down"></i>
                </div>
                <div class="options">
                    <div class="item" v-for="(val, idx) in $config.languages" :key="idx" :data-value="val"
                        :class="{ active: lang === val }" @click="setCurrentLang(val)">
                        <img :src="`/images/lang/${val}.png`" :alt="val">
                        <span>{{ val }}</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>
<script>
import { gsap } from 'gsap';
import router from "@resources/js/router/index";
import { i18n } from '../../../app';

export default {
    data() {
        return {
            isProcessing: false,
            isTransition: true,
            gsap,
            generalSettings: {},
            lang: i18n.global.locale // put here because have used in setCurrentLang()
        };
    },
    created() {
        this.generalSettings = JSON.parse(localStorage.getItem('general'));
        this.setBodyClass();
        this.stickyTopBar();
        this.setHeader();
    },
    computed: {
        topItems() {
            return [
                { name: this.$t('top_bar.menu_text.home'), to: "/" },
                { name: this.$t('top_bar.menu_text.about'), to: "/about" },
                { name: this.$t('top_bar.menu_text.products'), to: "/products" },
                { name: this.$t('top_bar.menu_text.news'), to: "/news" }
            ];
        }
    },
    methods: {
        setBodyClass() {
            $('body').addClass('home');
        },
        stickyTopBar() {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 150) {
                    $('nav.navbar').addClass('bar_sticky');
                    $('#scrollToTop').addClass('opacity-10');
                } else {
                    $('nav.navbar').removeClass('bar_sticky');
                    $('#scrollToTop').removeClass('opacity-10');
                }
            });
        },
        showHideListMenu() {
            $('.top_items').toggleClass('show_menu')
            $('i.icons').toggleClass('fa-times')
        },
        callFunctionLeave(routePath) {
            if (this.isProcessing) return;
            if (this.$route.path !== `/${this.lang}${routePath}`) {
                this.isProcessing = true;
                this.leave(routePath);
            }
        },
        leave(routePath) {
            this.isTransition
                ? (
                    this.gsap.to(".loader-overlay.one", {
                        duration: 0.45,
                        scaleX: 1,
                        transformOrigin: "left",
                        ease: "power1.inOut"
                    }),
                    this.gsap.to(".loader-overlay.one", {
                        duration: 0.6,
                        scaleX: 0,
                        transformOrigin: "right",
                        ease: "power1.inOut",
                        delay: 0.65
                    }),
                    this.gsap.to(".loader-overlay.two", {
                        duration: 0.55,
                        opacity: 1,
                        ease: "power1.inOut",
                        delay: 0.3
                    }),
                    this.gsap.to(".loader-overlay.two", {
                        duration: 0.7,
                        opacity: 0,
                        ease: "power1.inOut",
                        delay: 1
                    })
                )
                : (
                    this.gsap.to(".loader-overlay.two", {
                        opacity: 1,
                        y: 0,
                        duration: 0.3,
                        delay: 0,
                        onComplete: this.transitionComplete
                    })
                );
                setTimeout(() => {
                router.push(routePath).finally(() => {
                    this.isProcessing = false;
                });
            }, 500);
        },
        transitionComplete() {
            console.log("Transition complete!");
        },
        toggleActiveLangOpts() {
            $('#langSwitch .value').toggleClass('active');
            $('#langSwitch .options').toggleClass('active');
        },
        setCurrentLang(val) {
            $('#langSwitch .value').toggleClass('active');
            $('#langSwitch .options').toggleClass('active');
            const me = this;
            this.$nextTick(() => {
                me.lang = val;
                localStorage.setItem('lang', me.lang);
                router.push({
                    name: me.$route.name,
                    params: {
                        lang: me.lang,
                    },
                });
                i18n.global.locale = me.lang;
                this.setHeader();
            });
        },
        setHeader() {
            $('title').text(this.generalSettings?.site_title?.split(`[:${this.lang}]`)[1]);
            $('link[rel="shortcut icon"]').attr('href', this.generalSettings?.favicon);
        },
      
    }
};
</script>
