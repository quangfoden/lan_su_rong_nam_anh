<template>
    <div class="card show border border-0">
        <div class="card-body">
            <div class="container-fluid mb-3">
                <div class="row">
                    <div class="col-6 pl-0">
                        <h4 class="card-title fs-4 mb-0">
                            Danh sách thông tin liên hệ
                        </h4>
                    </div>
                    <div class="col-2 offset-4 text-right pr-0">
                        <select ref="filterStatus" class="form-select" @change="reloadTable">
                            <option value="">--Select Status--</option>
                            <option value="1">Chưa đọc</option>
                            <option value="2">Đã đọc</option>
                            <option value="3">Đã phản hồi</option>
                        </select>
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
                    data: "name",
                    title: "Tên"
                },
                {
                    data: "email",
                    title: "Email"
                },
                {
                    data: "message",
                    title: "Tin nhắn",
                    render: function (data, type, row) {
                        return `<div class="contact_msg_list">${row.message}</div>`;
                    }
                },
                {
                    data: "status",
                    title: "Trạng thái",
                    render: function (data, type, row) {
                        switch (row.status) {
                            case (1):
                                return `<div class="badge badge-danger w-100 fs-6 p-2"><i class="fa fa-eye-slash"></i> Chưa đọc</div>`;
                            case (2):
                                return `<div class="badge badge-warning w-100 fs-6 p-2"><i class="fa fa-eye"></i> Đã đọc</div>`;
                            case (3):
                                return `<div class="badge badge-success w-100 fs-6 p-2"><i class="fa fa-paper-plane"></i> Đã phản hồi</div>`;
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
                                            to: `/contact-manager/detail/${rowData.id}`,
                                            class: "btn btn-all-add-edit mr-2 waves-effect",
                                            onClick: () => {
                                                router.push({
                                                    name: "Contact Detail",
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
                .get("/api/admin/contact-us/list", {
                    params: {status: this.$refs.filterStatus?.value}
                })
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
