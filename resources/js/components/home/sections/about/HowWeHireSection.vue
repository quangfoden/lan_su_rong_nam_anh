<template>
    <div id="QuestionAbout" class="pb-5">
        <div class="container">
            <h2 class="ff_ss3_bold">{{ convertLang(lifeHowWeHireSec.main_title) }}</h2>
            <div class="row">
                <div class="col-12 faqs">
                    <div v-for="(faq, index) in lifeHowWeHireSec.data.question" :key="index" class="faq-item my-2">
                        <p @click="toggleFaq(index)" class="faq-question stext-104 p-3" :class="{ open: faq.open }">
                            {{ convertLang(faq.title) }}
                        </p>
                        <p v-if="faq.open" class="faq-answer stext-101 c-xam pb-2 pt-2 px-3">
                            {{ convertLang(faq.answer) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid pt-5">
            <div class="row fw-bold">
                <div class="col-12 col-md-6">
                    <h3 class="mtext-101 fw-bold">{{convertLang(lifeHowWeHireSec.data.info.title)}}</h3>
                    <p class="mtext-102 m-0">{{convertLang(lifeHowWeHireSec.data.info.title_small)}}</p>
                    <p class="mtext-106 mb-1">{{convertLang(lifeHowWeHireSec.data.info.note_title_small)}}</p>
                    <ul class="lstylen p-0">
                        <li class="mtext-105">{{convertLang(lifeHowWeHireSec.data.info.hotline_title)}}
                            <span class="mtext-103">{{ generalAbout.contact.hotline }}</span>
                        </li>
                        <li class="mtext-105">{{convertLang(lifeHowWeHireSec.data.info.zalo_title)}}
                            <span class="mtext-103">{{ generalAbout.contact.hotline }}</span>
                        </li>
                        <li class="mtext-105">{{convertLang(lifeHowWeHireSec.data.info.fb_title)}}
                            <a class="mtext-104" :href="generalAbout.contact.link_fb"
                                target="_blank">Lân sư rồng Nam Anh</a>
                        </li>
                        <li class="mtext-105">{{convertLang(lifeHowWeHireSec.data.info.fanpage_title)}}
                            <a class="mtext-104" :href="generalAbout.contact.link_page_fb"
                                target="_blank">Lân sư rồng Nam Anh</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-md-6">
                    <h3 class="mtext-101 text-center fw-bold">{{convertLang(lifeHowWeHireSec.data.info.customer_title)}}</h3>
                    <div id="ImageKH">
                        <div v-for="(imgKh, index) in lifeHowWeHireSec.data.images_kh" :key="index"
                            class="imgkh hov-img0">
                            <img :src="imgKh" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import { i18n } from "../../../../app";
export default {
    data() {
        return {
            lifeHowWeHireSec: JSON.parse(localStorage.getItem('life_how_we_hire_sec')),
            generalAbout: JSON.parse(localStorage.getItem('general'))
        };
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    created() {
    },
    methods: {
        toggleFaq(index) {
            this.lifeHowWeHireSec.data.question.forEach((faq, i) => {
                if (i === index) {
                    faq.open = !faq.open;
                } else {
                    faq.open = false;
                }
            });
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        },
    }
};
</script>