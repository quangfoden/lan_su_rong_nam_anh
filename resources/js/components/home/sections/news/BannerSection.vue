<template>
    <section id="newsBannerSection">
        <div class="container">
            <div class="row">
                <div class="banner_wrapper">
                    <h1 class="ff_ss3_bold">{{ $t('top_bar.menu_text.news') }}</h1>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
export default {
    data() {
        return {
            bannerSecSettings: {}
        };
    },
    created() {
    }
};
</script>
