<template>
    <section id="aboutSection">
        <div class="container">
            <div class="row">
                <h2 class="ff_ss3_bold">{{ convertLang(aboutSecSettings.main_title) }}</h2>
                <div class="list-about-home">
                    <div v-for="(item, idx) in listAbout" :key="idx" :class="`box box_${idx + 1}`">
                        <div class="desc">
                            <div class="content">
                                <div class="desc_title ff_ss3_bold">{{ convertLang(item.title) }}</div>
                                <div class="desc_content" v-html="convertLang(item.content)"></div>
                            </div>
                            <div class="title">
                                <span class="ff_ss3_bold">{{ convertLang(item.title) }}</span>
                                <img src="/assets/images/about-home/more-abhome.png" alt="more">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { i18n } from "../../../../app";

export default {
    data() {
        return {
            listAbout: [],
            aboutSecSettings: {}
        };
    },
    created() {
        this.aboutSecSettings = JSON.parse(localStorage.getItem('about_sec'));
        this.listAbout.push({
            img: '/assets/images/about-home/img-ab1.png',
            title: this.aboutSecSettings.overview.title,
            content: this.aboutSecSettings.overview.content,
        });
        this.listAbout.push({
            img: '/assets/images/about-home/img-ab2.png',
            title: this.aboutSecSettings.products.title,
            content: this.aboutSecSettings.products.content,
        });
        this.listAbout.push({
            img: '/assets/images/about-home/img-ab3.png',
            title: this.aboutSecSettings.service.title,
            content: this.aboutSecSettings.service.content,
        });
        this.toggleBoxActive();
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    methods: {
        toggleBoxActive() {
            this.$nextTick(() => {
                const boxes = document.querySelectorAll('.box');
                boxes.forEach((e) => {
                    $(e).on('click', () => {
                        if ($(e).hasClass('active')) {
                            $('.box').removeClass('active');
                        } else {
                            $('.box').removeClass('active');
                            $(e).addClass('active');
                        }
                    });
                });
            });
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        }
    }
};
</script>
