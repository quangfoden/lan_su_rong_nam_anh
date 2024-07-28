<template>
    <TopBar/>
    <BannerSection/>
    <FeaturedSection/>
    <AllProductsSection/>
    <FooterSection/>
</template>
<script>
import TopBar from "../partials/TopBar.vue";
import BannerSection from "../sections/products/BannerSection.vue";
import FeaturedSection from "../sections/products/FeaturedSection.vue";
import AllProductsSection from "../sections/products/AllProductsSection.vue";
import FooterSection from "../sections/FooterSection.vue";

export default {
    components: {
        TopBar,
        BannerSection,
        FeaturedSection,
        AllProductsSection,
        FooterSection
    },
    created() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}
</script>
