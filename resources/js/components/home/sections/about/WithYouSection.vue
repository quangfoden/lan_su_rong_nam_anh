<template>
    <section id="VideoAboutpage">
        <h2 class="ff_ss3_bold">{{ convertLang(withYouSecSettings.main_title) }}</h2>
        <div class="list-about">
            <div class="container">
                <video ref="videoElement" width="100%" class="" controls loop @click="handleVideoClick">
                    <source :src="withYouSecSettings.video" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </section>
</template>
<script>
import { i18n } from "../../../../app";

export default {
    data() {
        return {
            withYouSecSettings: JSON.parse(localStorage.getItem('life_with_you_sec')),
            isMobile: false,
        };
    },
    created() {
        this.checkIfMobile();
    },
    computed: {
        lang() {
            return i18n.global.locale;
        }
    },
    mounted() {
        if (!this.isMobile) {
            this.initializeIntersectionObserver();
        }
    },
    beforeDestroy() {
        if (this.observer) {
            this.observer.disconnect();
        }
    },
    methods: {
        convertLang(text) {
            return text?.split(`[:${this.lang}]`)[1] ?? text;
        },
        checkIfMobile() {
            this.isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
        },
        initializeIntersectionObserver() {
            const video = this.$refs.videoElement;

            this.observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        video.play();
                    } else {
                        video.pause();
                    }
                });
            }, {
                threshold: 0.5
            });

            if (video) {
                this.observer.observe(video);
            }
        },
        handleVideoClick() {
            if (this.isMobile) {
                const video = this.$refs.videoElement;
                if (video.paused) {
                    video.play();
                } else {
                    video.pause();
                }
            }
        }
    }
};
</script>
