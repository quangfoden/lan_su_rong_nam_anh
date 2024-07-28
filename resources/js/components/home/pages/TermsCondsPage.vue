<template>
    <TopBar/>
    <div id="termsCondsSection" STYLE="min-height: 100vh; text-align: center;">
        <div style="position: relative;top: 200px;">THIS IS TERMS AND CONDITIONS PAGE</div>
    </div>
    <FooterSection/>
</template>
<script>
import TopBar from "../partials/TopBar.vue";
import FooterSection from "../sections/FooterSection.vue";

export default {
    components: {
        TopBar, FooterSection
    }
}
</script>
