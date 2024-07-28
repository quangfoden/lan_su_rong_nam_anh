<template>
    <TopBar/>
    <OurValueSection/>
    <WithYouSection/>
    <HowWeHireSection/>
    <FooterSection/>
</template>
<script>
import TopBar from "../partials/TopBar.vue";
import OurValueSection from "../sections/About/OurValueSection.vue";
import WithYouSection from "../sections/About/WithYouSection.vue";
import HowWeHireSection from "../sections/About/HowWeHireSection.vue";
import FooterSection from "../sections/FooterSection.vue";

export default {
    components: {
        TopBar,
        OurValueSection,
        WithYouSection,
        HowWeHireSection,
        FooterSection
    },
    created() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}
</script>
