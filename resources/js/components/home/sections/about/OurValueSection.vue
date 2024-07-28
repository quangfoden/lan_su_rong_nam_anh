<template>
    <section id="lifeOurValueSection">
        <div class="list_ovl_bg hidden-mobile">
            <div
                v-for="(it, idx) in ourValueSecSettings.content"
                :key="idx"
                class="it_ovl_bg"
                :class="`it_ovl_bg_${idx}`"
                :style="`background-image: url('${it.bg}')`"
            ></div>
            <div
                id="activeFirst"
                class="it_ovl_bg previous active activeFirst"
                :style="`background-image: url(${ourValueSecSettings.main_bg})`">
            </div>
        </div>
        <div class="list_ovl_life d-flex position-relative">
            <div
                v-for="(it, idx) in ourValueSecSettings.content"
                :key="idx"
                class="it_ovl_life position-relative"
                :class="`it_ovl_life_${idx}`"
                :style="`background-image: url('${it.bg}')`"
                @click="toggleActive(idx)"
            >
                <div class="ovl_toggle position-absolute plus">
                    <span aria-hidden="true" class="icon">
                        <svg viewBox="0 0 8 8"><path d="M8 3H5V0H3v3H0v2h3v3h2V5h3z" fill-rule="evenodd"
                                                     clip-rule="evenodd"></path></svg>
                    </span>
                </div>
                <div class="ovl_toggle position-absolute minus">
                    <span aria-hidden="true" class="icon">
                        <svg viewBox="0 0 12 2" width="12" height="2"><path d="M0 0h12v2H0z"></path></svg>
                    </span>
                </div>
                <div class="info_front">
                    <div class="title ff_ss3_bold">{{ convertLang(it.title) }}</div>
                </div>
                <div class="info_back">
                    <div class="title ff_ss3_bold">{{ convertLang(it.title) }}</div>
                    <div class="desc" v-html="convertLang(it.content)"></div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import {i18n} from "../../../../app";

export default {
    data() {
        return {
            ourValueSecSettings: JSON.parse(localStorage.getItem('life_our_value_sec'))
        };
    },
    created() {
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    methods: {
        toggleActive(idx) {
            const itemOvlLife = $(`.it_ovl_life_${idx}`);
            const itemOvlBg = $(`.it_ovl_bg_${idx}`);
            if (itemOvlLife.hasClass('active')) {
                itemOvlLife.toggleClass('active');
                itemOvlBg.toggleClass('active');

                $('#activeFirst').addClass('active');
                setTimeout(() => {
                    itemOvlBg.toggleClass('previous');
                    $('#activeFirst').addClass('previous');
                }, 2000);
            } else {
                $('.it_ovl_life').removeClass('active');
                itemOvlLife.addClass('active');
                $('.it_ovl_bg').removeClass('active');
                itemOvlBg.addClass('active');
                setTimeout(() => {
                    $('.it_ovl_bg').removeClass('previous');
                    itemOvlBg.addClass('previous');
                }, 2000);
            }
        },
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text
        }
    }
};
</script>
