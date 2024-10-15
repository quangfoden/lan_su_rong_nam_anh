import {createRouter, createWebHistory} from 'vue-router';
import LoginIdentifier from '../components/account/LoginIdentifier.vue';

import AdminParent from "../components/admin/AdminParent.vue";
import AdminDashboard from "../components/admin/Dashboard.vue";

import RoleParent from '../components/admin/role/RoleParent.vue';
import AllRoles from '../components/admin/role/AllRoles.vue';
import AddRole from '../components/admin/role/AddRole.vue';

import PermissionParent from '../components/admin/permission/PermissionParent.vue';
import AllPermissions from '../components/admin/permission/AllPermissions.vue';
import AddPermission from '../components/admin/permission/AddPermission.vue';

import UserParent from '../components/admin/user/UserParent.vue';
import AllUser from '../components/admin/user/AllUser.vue';
import CreateNewUser from '../components/admin/user/CreateNewUser.vue';

import ProfileParent from '../components/admin/profile/ProfileParent.vue';
import Profile from '../components/admin/profile/Profile.vue';
import ChangePasswordProfile from '../components/admin/profile/ChangePassword.vue';

const ErrorPage = {
    template: '<div>403 - Access denied</div>'
};
export const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomeParent,
        children: [
            {
                path: ':lang',
                children: [
                    {
                        path: '',
                        name: "NamAnh's Home",
                        component: HomePage
                    },
                    {
                        path: 'about',
                        name: "NamAnh's About",
                        component: AboutPage
                    },
                    {
                        path: 'products',
                        name: "NamAnh's Products",
                        component: ProductsPage
                    },
                    {
                        path: 'news',
                        name: "News",
                        component: NewsParent,
                        children: [
                            {
                                name: "NamAnh's News",
                                path: '',
                                component: NewsCategoryPage,
                            },
                            {
                                name: 'Category News',
                                path: ':slug',
                                component: NewsCategoryPage,
                            },
                            {
                                name: 'News Detail',
                                path: ':cat_slug/:post_slug',
                                component: NewsDetailPage
                            }
                        ]
                    }
                ]
            },
            {
                path: '/admin',
                name: 'Dashboard',
                component: AdminParent,
                meta: {requiresAuth: true},
                children: [
                    {
                        path: '',
                        name: 'Dashboard Details',
                        component: AdminDashboard,
                    },
                    {
                        path: 'role',
                        name: 'Role',
                        component: RoleParent,
                        meta: {permissions: ['Role Manager']},
                        children: [
                            {
                                name: 'All Roles',
                                path: 'all',
                                component: AllRoles,
                            },
                            {
                                name: 'Add Role',
                                path: 'add',
                                component: AddRole,
                            },
                        ]
                    },
                    {
                        path: 'permission',
                        name: 'Permission',
                        component: PermissionParent,
                        meta: {permissions: ['Permission Manager']},
                        children: [
                            {
                                name: 'All Permissions',
                                path: 'all',
                                component: AllPermissions,
                                meta: {requiresAuth: true}
                            },
                            {
                                name: 'Add Permission',
                                path: 'add',
                                component: AddPermission,
                                meta: {requiresAuth: true}
                            },
                        ]
                    },
                    {
                        name: 'Profile',
                        path: 'profile',
                        component: ProfileParent,
                        children: [
                            {
                                name: 'Profile User',
                                path: 'profile-user',
                                component: Profile,
                            },
                            {
                                name: 'Change Password',
                                path: 'change-password',
                                component: ChangePasswordProfile,
                            }
                        ]
                    },
                    {
                        name: 'User Manager',
                        path: 'user-manager',
                        component: UserParent,
                        meta: {permissions: ['User Manager']},
                        children: [
                            {
                                name: 'All User',
                                path: '',
                                component: AllUser,
                            },
                            {
                                name: 'Create New User',
                                path: 'create-new-user',
                                component: CreateNewUser,
                            },
                        ]
                    },
                    {
                        name: 'Product Manager',
                        path: 'product-manager',
                        component: ProductParent,
                        meta: {permissions: ['Products Manager']},
                        children: [
                            {
                                name: 'All Product',
                                path: 'all',
                                component: ProductList,
                            },
                            {
                                name: 'Create Product',
                                path: 'add',
                                component: AddProduct,
                            },
                            {
                                name: 'Product Detail',
                                path: 'detail/:id',
                                component: ProductDetail,
                            }
                        ]
                    },
                    {
                        name: 'Contact Manager',
                        path: 'contact-manager',
                        component: ContactParent,
                        meta: {permissions: ['Contact Manager']},
                        children: [
                            {
                                name: 'All Contact',
                                path: 'all',
                                component: ContactList,
                            },
                            {
                                name: 'Contact Detail',
                                path: 'detail/:id',
                                component: ContactDetail,
                            }
                        ]
                    },
                    {
                        name: 'Setting Manager',
                        path: 'setting-manager',
                        component: SettingParent,
                        meta: {permissions: ['Setting Manager']},
                        children: [
                            {
                                name: 'All Setting',
                                path: 'all',
                                component: AllSetting,
                            }
                        ]
                    },
                    {
                        name: 'Category Manager',
                        path: 'category-manager',
                        component: CategoryParent,
                        meta: {permissions: ['News Manager']},
                        children: [
                            {
                                name: 'All Category',
                                path: 'all',
                                component: CategoryList,
                            },
                            {
                                name: 'Create Category',
                                path: 'add',
                                component: AddCategory,
                            },
                            {
                                name: 'Category Detail',
                                path: 'detail/:id',
                                component: CategoryDetail,
                            }
                        ]
                    },
                    {
                        name: 'Post Manager',
                        path: 'post-manager',
                        component: PostParent,
                        meta: {permissions: ['News Manager']},
                        children: [
                            {
                                name: 'All Post',
                                path: 'all',
                                component: PostList,
                            },
                            {
                                name: 'Create Post',
                                path: 'add',
                                component: AddPost,
                            },
                            {
                                name: 'Post Detail',
                                path: 'detail/:id',
                                component: PostDetail,
                            }
                        ]
                    },
                ]
            }
        ],
    },
    {
        path: '/admin/login',
        name: 'login',
        component: LoginIdentifier
    },
    {
        path: '/admin/error',
        name: 'error',
        component: ErrorPage
    }

];
const router = createRouter({
    history: createWebHistory(),
    routes
})
import {store} from '../store/store';
import $ from 'jquery';
import HomeParent from "../components/home/HomeParent.vue";
import HomePage from "../components/home/HomePage.vue";
import TermsCondsPage from "../components/home/pages/TermsCondsPage.vue";
import ProductsPage from "../components/home/pages/ProductsPage.vue";
import AboutPage from "../components/home/pages/AboutPage.vue";
import AddProduct from "../components/admin/product/AddProduct.vue";
import ProductList from "../components/admin/product/ProductList.vue";
import ProductParent from "../components/admin/product/ProductParent.vue";
import ProductDetail from "../components/admin/product/ProductDetail.vue";
import ContactParent from "../components/admin/contact/ContactParent.vue";
import ContactList from "../components/admin/contact/ContactList.vue";
import ContactDetail from "../components/admin/contact/ContactDetail.vue";
import SettingParent from "../components/admin/setting/SettingParent.vue";
import AllSetting from "../components/admin/setting/AllSetting.vue";
import CategoryParent from "../components/admin/news/category/CategoryParent.vue";
import CategoryList from "../components/admin/news/category/CategoryList.vue";
import PostParent from "../components/admin/news/post/PostParent.vue";
import PostList from "../components/admin/news/post/PostList.vue";
import AddCategory from "../components/admin/news/category/AddCategory.vue";
import CategoryDetail from "../components/admin/news/category/CategoryDetail.vue";
import AddPost from "../components/admin/news/post/AddPost.vue";
import PostDetail from "../components/admin/news/post/PostDetail.vue";
import NewsCategoryPage from "../components/home/pages/news/NewsCategoryPage.vue";
import NewsParent from "../components/home/pages/news/NewsParent.vue";
import NewsDetailPage from "../components/home/pages/news/NewsDetailPage.vue";
import config from "../config";
import { i18n } from '../app';

router.beforeEach((to, from, next) => {
    initLoading();
    let isAdminArea = document.URL.includes('/admin');

    // check lang in path
    if (!isAdminArea) {
        const lang = i18n.global.locale;
        if (typeof to.name === 'undefined') {
            next(`/${lang}`);
            return;
        }
        if (typeof to.params.lang === 'undefined') {
            next(`/${lang}${to.path}`);
            return;
        }
        if (!config.languages.includes(to.params.lang)) {
            let nextTo = '';
            if (config.sub_pages.includes(to.params.lang)) {
                nextTo = '/' + lang + to.path;
            } else {
                nextTo = `/${lang}/`;
            }
            i18n.global.locale = to.params.lang;
            next(nextTo);
            return;
        } else {
            localStorage.setItem('lang', to.params.lang);
            i18n.global.locale = to.params.lang;
        }
    }

    const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
    const isAuthenticated = store.getters.getLoginResponse.authenticated || JSON.parse(localStorage.getItem('loginResponse'))?.authenticated
    const roles = to.meta.roles
    const permissions = to.meta.permissions
    let authUser = undefined
    if (store.getters.getAuthUser.id !== undefined) {
        authUser = store.getters.getAuthUser;
    }
    authUser = JSON.parse(localStorage.getItem('authUser'));
    if (requiresAuth) {
        if (!isAuthenticated) {
            next('/admin/login');
            return;
        }
    }

    // check is right path and right path with authenticated
    if (to.matched.length <= 0) {
        if (requiresAuth) {
            if (!isAuthenticated) {
                next('/admin/login');
                return;
            }
        } else {
            let nextTo = isAuthenticated && isAdminArea ? '/admin' : '/';
            next(nextTo);
            return;
        }
    }

    // check is right path and right path with authenticated

    if (roles && roles.length > 0) {
        const userRoles = authUser.roles
        const hasAccess = userRoles.some(role => roles.includes(role.name));
        if (!hasAccess) {
            next('/admin/error');
            return;
        }
    }
    if (permissions && permissions.length > 0) {
        const userRoles = authUser.roles
        let hasAccess = false;
        for (const role of userRoles) {
            if (role.permissions.some(permission => permissions.includes(permission.name))) {
                hasAccess = true;
                break;
            }
        }
        if (!hasAccess) {
            next('/admin/error');
            return;
        }
    }
    next();

});

router.afterEach(() => {
    initLoading(true);
});

function initLoading(close = false) {
    const pageContent = $('.page-content');
    if (close) {
        pageContent.removeClass('d-none');
        setTimeout(() => {
            pageContent.removeClass('loading');
        }, 500);
    } else {
        pageContent.addClass('d-none');
        pageContent.addClass('loading');
    }
}

export default router
