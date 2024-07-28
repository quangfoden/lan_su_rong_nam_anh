<template>
    <div class="card show border border-0">
        <div class="card-body">
            <div class="container-fluid mb-3">
                <div class="row">
                    <div class="col-6 pl-0">
                        <h4 class="card-title fs-4 mb-0">
                            Danh sách Sản phẩm
                            <router-link :to="{ name: 'Create Product' }" class="btn btn-all-add-edit waves-effect"
                                v-if="checkPermission(['Products Manager'])">
                                <span>Thêm sản phẩm</span>
                            </router-link>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="table-responsive-lg">
                <table ref="myTable" class="table table-bordered table-striped table-hover display nowrap">
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
import { checkRolesAccess, checkPermissionAccess } from '@resources/js/middleware/access.js';

DataTable.use(DataTablesCore);
import { mapGetters, mapMutations, mapActions } from "vuex";
import { createApp, h } from "vue";
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
                    data: "name",
                    title: "Tên",
                    render: function (data, type, row) {
                        return row.name.split('[:vi]')[1] ?? row.name;
                    }
                },
                {
                    data: "bg_img",
                    title: "Ảnh",
                    render: function (data, type, row) {
                        const imgUrl = row.bg_img;
                        return `<img src="${imgUrl}" alt="Ảnh" style="max-width: 100px; max-height: 100px;">`;
                    }
                },
                {
                    data: "price",
                    title: "Giá",
                    render: function (data, type, row) {
                        return new Intl.NumberFormat('vi-VN').format(row.price);
                    }
                },
                {
                    data: "is_hot",
                    title: "Nổi bật",
                    render: function (data, type, row) {
                        return row.is_hot === 1 ? 'Có' : 'Không'
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
                                            to: `/product-manager/detail/${rowData.id}`,
                                            class: "btn btn-all-add-edit mr-2 waves-effect",
                                            onClick: () => {
                                                router.push({
                                                    name: "Product Detail",
                                                    params: { id: rowData.id },
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
                .get("/api/admin/products/list")
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
                            order: [0, 'asc']
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
