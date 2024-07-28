<template>
    <div class="app_vue">
        <div v-if="$route.path === '/admin/login'">
            <loginLayout/>
        </div>
        <div>
            <div v-if="authUser && isAdminArea">
                <AdminWrapper :authUser="authUser"/>
                <RightSidebar/>
            </div>
            <div v-if="!isAdminArea">
                <HomeWrapper/>
            </div>
        </div>
    </div>
</template>
<script>
import loginLayout from './components/account/LoginLayout.vue';
import AdminWrapper from './components/layouts/AdminWrapper.vue';
import HomeWrapper from './components/layouts/HomeWrapper.vue';
import RightSidebar from './components/layouts/RightSidebar.vue';

export default {
    components: {
        loginLayout,
        AdminWrapper,
        HomeWrapper,
        RightSidebar
    },
    computed: {
        authUser() {
            if (this.$store.getters.getAuthUser.id !== undefined) {
                return this.$store.getters.getAuthUser;
            }
            return JSON.parse(localStorage.getItem('authUser'));
        },
        isAdminArea() {
            return window.location.href.indexOf("/admin") > -1;
        }
    }
}
</script>
