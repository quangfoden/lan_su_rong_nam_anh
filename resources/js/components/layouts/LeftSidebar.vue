<template>
    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">
        <div data-simplebar class="h-100">

            <!--- Sidemenu -->
            <div id="sidebar-menu">
                <!-- Left Menu Start -->
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title">Menu</li>
                    <li>
                        <router-link :to="{ name: 'Dashboard' }"
                                     class=" waves-effect"
                                     :class="{ 'mm-active': $route.name === 'Dashboard' }"
                                     exact tag="li"
                        >
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </router-link>
                    </li>
                    <li :class="{ 'mm-active': [
                            'All Category', 'Create Category', 'Category Detail',
                            'All Post', 'Create Post', 'Post Detail'
                        ].includes($route.name) }"
                        v-if="checkPermission(['News Manager'])">
                        <a href="javascript: void(0);"
                           :class="{ 'mm-active':  [
                                'All Category', 'Create Category', 'Category Detail',
                                'All Post', 'Create Post', 'Post Detail'
                            ].includes($route.name) }"
                           class="has-arrow waves-effect">
                            <i class="fa fa-newspaper"></i>
                            <span>Quản lý tin Tức</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li
                                :class="{ 'mm-active':  [
                                    'All Category', 'Create Category', 'Category Detail'
                                ].includes($route.name) }"
                            >
                                <router-link
                                    :to="{ name: 'All Category' }"
                                    exact
                                    tag="li"
                                    exact-active-class="active"
                                    :class="{ 'mm-active':  [
                                        'All Category', 'Create Category', 'Category Detail'
                                    ].includes($route.name) }"
                                >Danh Mục
                                </router-link>
                            </li>
                            <li>
                                <router-link
                                    :to="{ name: 'All Post' }"
                                    exact
                                    tag="li"
                                    exact-active-class="active"
                                    :class="{ 'mm-active':  [
                                        'All Post', 'Create Post', 'Post Detail'
                                    ].includes($route.name) }"
                                >
                                    Bài Viết
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <router-link
                            :to="{ name: 'All Product' }"
                            class=" waves-effect" exact tag="li"
                            :class="{ 'mm-active': ['All Product', 'Create Product', 'Game Product'].includes($route.name) }"
                            v-if="checkPermission(['Products Manager'])">
                            <i class="fa-solid fa-box"></i>
                            <span>Quản lý sản phẩm</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            :to="{ name: 'All Contact' }"
                            class=" waves-effect" exact tag="li"
                            :class="{ 'mm-active': ['All Contact', 'Contact Detail'].includes($route.name) }"
                            v-if="checkPermission(['Contact Manager'])">
                            <i class="fa fa-envelope"></i>
                            <span>Quản lý contatcs</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            :to="{ name: 'All Setting' }"
                            class=" waves-effect" exact tag="li"
                            :class="{ 'mm-active': $route.name === 'All Setting' }"
                            v-if="checkPermission(['Setting Manager'])">
                            <i class="fa fa-cog"></i>
                            <span>Quản lý Web</span>
                        </router-link>
                    </li>
                    <li>
                        <router-link
                            :to="{ name: 'All User' }"
                            class=" waves-effect" exact tag="li"
                            :class="{ 'mm-active': $route.name === 'All User' }"
                            v-if="checkPermission(['User Manager'])">
                            <i class="far fa-user"></i>
                            <span>Quản lý tài khoản</span>
                        </router-link>
                    </li>
                    <li :class="{ 'mm-active': $route.name === 'All Roles' || $route.name === 'Add Role' }"
                        v-if="checkPermission(['Role Manager'])">
                        <a href="javascript: void(0);"
                           :class="{ 'mm-active': $route.name === 'All Roles' || $route.name === 'Add Role' }"
                           class="has-arrow waves-effect">
                            <i class="fas fa-users-cog"></i>
                            <span>Phân Quyền</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <router-link :to="{ name: 'All Roles' }" exact tag="li" exact-active-class="active">Danh
                                    sách
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'Add Role' }" exact tag="li" exact-active-class="active">Thêm
                                    mới
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li :class="{ 'mm-active': $route.name === 'All Permissions' || $route.name === 'Add Permission' }"
                        v-if="checkPermission(['Role Manager'])">
                        <a href="javascript: void(0);"
                           :class="{ 'mm-active': $route.name === 'All Permissions' || $route.name === 'Add Permission' }"
                           class="has-arrow waves-effect">
                            <i class="fas fa-users"></i>
                            <span>Trình quản lý quyền</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li>
                                <router-link :to="{ name: 'All Permissions' }" exact tag="li"
                                             exact-active-class="active">Danh sách
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'Add Permission' }" exact tag="li"
                                             exact-active-class="active">Thêm mới
                                </router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- Sidebar -->
        </div>
    </div>
    <!-- Left Sidebar End -->
</template>
<script>
import {checkRolesAccess, checkPermissionAccess} from '@resources/js/middleware/access.js';

export default {
    data() {
        return {
            isExpanded: false
        }
    },
    created() {
    },
    methods: {
        checkPermission(permissions) {
            return checkPermissionAccess(permissions);
        }
    },
    mounted() {
        const element = document.querySelector('.has-arrow');
        if (element instanceof Element) {
            element.setAttribute('aria-expanded', 'true');
        }
    },
    computed: {
        userHasAdmin() {
            return checkRolesAccess(['admin'])
        },
    }
}
</script>
