<template>
    <div class="card show border border-0">
        <div class="card-body">
            <div class="container-fluid mb-3">
                <div class="row">
                    <div class="col-6 pl-0">
                        <h4 class="card-title mb-4 fs-4 mb-0">
                            Quản lý Web
                        </h4>
                    </div>

                    <div class="col-12">
                        <div class="custom_tabs">
                            <ul class="nav nav-tabs">
                                <li
                                    v-for="(item, idx) in dataTitleTabs"
                                    :key="idx"
                                    :class="{active: idx === 0}"
                                >
                                    <a
                                        :class="{active: idx === 0}"
                                        data-toggle="tab"
                                        :href="`#${item.name}TabSetting`"
                                    >
                                        {{ item.name }}
                                    </a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div
                                    v-for="(item, idx) in dataContentTabs"
                                    :key="idx"
                                    :id="item.id"
                                    :class="{'in active show': idx === 0}"
                                    class="tab-pane fade"
                                >
                                    <div v-if="item.component === 'HomeTab'">
                                        <HomeTab :data="item.data" :name="item.name" />
                                    </div>
                                    <div v-else-if="item.component === 'AboutTab'">
                                        <AboutTab :data="item.data" :name="item.name" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {checkRolesAccess, checkPermissionAccess} from '@resources/js/middleware/access.js';
import {mapGetters, mapMutations, mapActions} from "vuex";
import HomeTab from "./sub-tabs/home/HomeTab.vue";
import AboutTab from "./sub-tabs/about/AboutTab.vue";

export default {
    components: {
        HomeTab,
        AboutTab,
    },
    data() {
        return {
            dataTitleTabs: [],
            dataContentTabs: []
        };
    },
    created() {
        this.fetchData();
        this.stickyBtnSubmit();
    },
    computed: {},
    methods: {
        ...mapActions(["logout"]),
        checkPermission(permissions) {
            return checkPermissionAccess(permissions);
        },
        fetchData() {
            this.axios
                .get("/api/admin/settings/list")
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.separateDataTabs(response.data.data);
                    }
                })
                .catch((error) => {
                    if (error.response.status === 403) {
                        this.logout();
                    }
                    if (error.response.status === 401) {
                        this.logout();
                    }
                });
        },
        separateDataTabs(data) {
            data.forEach((item, idx) => {
                this.dataTitleTabs[idx] = {
                    name: item.name
                };
                this.dataContentTabs[idx] = {
                    id: `${item.name}TabSetting`,
                    component: `${item.name}Tab`,
                    name: `${item.name}`,
                    data: item.data,
                    status: item.status
                };
            });
        },
        stickyBtnSubmit() {
            $(window).scroll(function () {
                if ($(this).scrollTop() > 150) {
                    $('.sticky_group').addClass('sticky');
                } else {
                    $('.sticky_group').removeClass('sticky');
                }
            });
        }
    },
};
</script>
