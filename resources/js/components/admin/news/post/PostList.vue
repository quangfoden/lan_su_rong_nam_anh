<template>
    <div class="card show border border-0">
        <div class="card-body">
            <div class="container-fluid mb-3">
                <div class="row">
                    <div class="col-6 pl-0">
                        <h4 class="card-title fs-4 mb-0">
                            Danh sách Bài Viết
                            <router-link :to="{ name: 'Create Post' }"
                                         class="btn btn-all-add-edit waves-effect"
                                         v-if="checkPermission(['News Manager'])">
                                <span>Thêm Bài Viết</span>
                            </router-link>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="table-responsive-lg">
                <table ref="myTable"
                       class="table table-bordered table-striped table-hover display nowrap">
                </table>
            </div>
        </div>
    </div>
</template>

<style lang="scss"></style>

<script>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import $ from "jquery";
import {checkRolesAccess, checkPermissionAccess} from '@resources/js/middleware/access.js';

DataTable.use(DataTablesCore);
import {mapGetters, mapMutations, mapActions} from "vuex";
import {createApp, h} from "vue";
import router from "@resources/js/router/index";

export default {
    data() {
        return {
            dataTableData: []
        };
    },
    created() {
        this.fetchData();
    },
    computed: {},
    methods: {
        ...mapActions(["logout"]),
        checkPermission(permissions) {
            return checkPermissionAccess(permissions);
        },
        setColumns() {
            this.columns = [
                {
                    data: "id",
                    title: "#"
                },
                {
                    data: "title",
                    title: "Title",
                    render: function (data, type, row) {
                        return row.title.split('[:vi]')[1] ?? row.title
                    }
                },
                {
                    data: "categories",
                    title: "Categories",
                    render: function (data, type, row) {
                        let tmp = '';
                        if (row.categories.length > 0) {
                            for (let i = 0; i < row.categories.length; i++) {
                                tmp += `<b>${row.categories[i].title.split('[:vi]')[1] ?? row.categories[i].title}</b><br>`
                            }
                        }

                        return tmp;
                    }
                },
                {
                    data: "active",
                    title: "Active",
                    render: function (data, type, row) {
                        if (row.active === 1) {
                            return `<label class="badge badge-success p-2 mb-0 mt-1">Hoạt Động</label>`;
                        } else {
                            return `<label class="badge badge-danger p-2 mb-0 mt-1">Tạm Ngừng</label>`;
                        }
                    }
                },
                {
                    data: "id",
                    title: "",
                    createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
                        const app = createApp({
                            render() {
                                return [
                                    h(
                                        "a",
                                        {
                                            to: `/post-manager/detail/${rowData.id}`,
                                            class: "btn btn-all-add-edit mr-2 waves-effect",
                                            onClick: () => {
                                                router.push({
                                                    name: "Post Detail",
                                                    params: {id: rowData.id},
                                                });
                                            }
                                        },
                                        "Chi tiết"
                                    )
                                ];
                            },
                            data() {
                                return {
                                    rowData: rowData,
                                };
                            },
                        });
                        app.mount(cell);
                    }
                },
            ];
        },
        fetchData() {
            this.axios
                .get("/api/admin/post/list")
                .then((response) => {
                    if (
                        response.data.message === "success" &&
                        response.data.status === 200
                    ) {
                        this.setColumns();

                        this.dataTableData = response.data.data;
                        this.table = $(this.$refs.myTable).DataTable({
                            data: this.dataTableData,
                            columns: this.columns,
                            scrollX: true,
                            order: [0, 'desc']
                        });
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
        reloadTable() {
            $(this.$refs.myTable).DataTable().destroy();
            this.fetchData();
        }
    },
};
</script>
