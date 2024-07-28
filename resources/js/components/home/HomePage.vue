<template>
    <TopBar/>
    <slideSection/>
    <ProductsSection/>
    <NewsSectione/>
    <AboutSection/>
    <FooterSection/>
</template>
<script>
import TopBar from "./partials/TopBar.vue";
import slideSection from "./sections/home/slideSection.vue";
import AboutSection from "./sections/home/AboutSection.vue";
import NewsSectione from "./sections/home/NewsSectione.vue";
import FooterSection from "./sections/FooterSection.vue";
import ProductsSection from "./sections/home/ProductsSection.vue";

export default {
    components: {
        TopBar,
        slideSection,
        AboutSection,
        NewsSectione,
        ProductsSection,
        FooterSection
    },
    data() {
        return {}
    },
    created() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },
    methods: {
    }
}
</script>
