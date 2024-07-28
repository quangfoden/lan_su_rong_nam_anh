<template>
  <div class="all_roles">
    <div class="row">
      <div class="col-12">
        <div class="card show border border-0">
          <div class="card-body">
            <h4 class="card-title text-center fs-4 mb-3">All Roles</h4>
            <div class="">
              <table ref="myTable" class="table table-bordered table-striped table-hover display nowrap"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <button ref="myModalBtn" type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#exampleModal">
      Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
      aria-hidden="true">
      <div class="modal-dialog p-lg-5 p-1 pt-5 pt-lg-5 d-flex justify-content-center" role="document">
        <div class="modal-content col-md-7">
          <div class="row">
            <div class="word_default p-4">
              <h3 class="text-center">Edit Permission</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-center">
                  <form @submit.prevent="updateRole">
                    <div class="form-group">
                      <label for="role-name">Role name</label>
                      <input id="role-name" type="text" placeholder="Enter role name" class="form-control"
                        v-model="roleForm.name" required />
                    </div>
                    <div class="form-group">
                      <label for="role-description">Description</label>
                      <textarea id="role-description" type="text" placeholder="Enter description" class="form-control"
                        cols="70" rows="4" v-model="roleForm.description"></textarea>
                    </div>
                    <label> List Permission</label>
                    <div v-if="showCheckbox" class="form-check" v-for="(permission, index) in permissions" :key="index">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="" :checked="isPermissionChecked(rolePermissions, permission.id)
                          " @click="
    handleCheckboxClick(
      permission.id,
      $event.target.checked
    )
    " />{{ permission.name }}
                      </label>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-all-add-edit">
                        Add Role
                      </button>
                    </div>
                  </form>
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
import { exit } from "process";
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import $ from "jquery";
DataTable.use(DataTablesCore);
import checkAccess from "@resources/js/middleware/access.js";
import { createApp, h } from "vue";
import router from "@resources/js/router/index"; // import router từ file router.js
import { mapGetters, mapMutations, mapActions } from "vuex";
export default {
  data() {
    return {
      roles: [],
      permissions: {},
      roleForm: { name: null, description: null },
      rolePermissions: {},
      DataTableData: [],
      activeUpdateData: 1,
      showCheckbox: true,
    };
  },
  created() {
    this.fetchData();
  },
  methods: {
    ...mapActions(["logout"]),
    actionEditStatus(rowData) {
      let dataReponsive = {};
      this.axios
        .post(`/api/admin/role/update-status/${rowData.id}`)
        .then((response) => {
          if (response.data.status === 200) {
            this.$swal.fire({
              position: "top-end",
              icon: "success",
              title: `Update Roles ${rowData.name} Success`,
              showConfirmButton: false,
              timer: this.$config.notificationTimer ?? 1000,
            });
          }
        })
        .catch((error) => {
          if (error.response.status == 403) {
            this.logout();
          }
          if (error.response.status == 401) {
            this.logout();
          }
          this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: `Error ${error.response.status}: ${error.response.data.message}`,
          });
        })
        .finally(() => (this.loading = false));
    },
    setColumns() {
      const self = this;
      this.columns = [
        { data: "id", title: "ID" },
        { data: "name", title: "Role" },
        { data: "description", title: "Description" },
        {
          data: "id",
          title: "Permissions",
          class: "columns-list",
          createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
            const app = createApp({
              render() {
                return h(
                  "ul",
                  { class: "ul-list mb-0" },
                  rowData.permissions.map((permission) => {
                    return h("li", {}, [
                      h(
                        "p",
                        {
                          to: `/admin/role/edit/${rowData.id}`,
                          class: "mb-2",
                        },
                        permission.name
                      ),
                    ]);
                  })
                );
              },
              data() {
                return {
                  rowData: rowData,
                };
              },
            });
            app.mount(cell);
          },
        },
        {
          data: "status",
          title: "Status",
          render: function (data, type, row) {
            const checked = row.status == 0 ? "checked" : "";
            return `<input type="checkbox" id="${row.id}" ${checked}/><label for="${row.id}">Toggle</label>`;
          },
          createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
            const checkbox = cell.querySelector('input[type="checkbox"]');
            checkbox.addEventListener(
              "click",
              function () {
                self.actionEditStatus(rowData);
              }.bind(this)
            );
          },
        },
        {
          data: "id",
          title: "Action",
          createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
            const app = createApp({
              render() {
                return h(
                  "a",
                  {
                    to: `/admin/role/edit/${rowData.id}`,
                    class: "btn btn-all-add-edit",
                    onClick: () => {
                      self.roleForm = {
                        name: rowData.name,
                        description: rowData.description,
                        id: rowData.id,
                      };

                      self.showCheckbox = false;
                      setTimeout(() => {
                        self.showCheckbox = true;
                        self.rolePermissions = rowData.permissions;
                        self.$refs.myModalBtn.click();
                      }, 10); // xử lý chờ 10 ms để rolePermissions kịp xóa list checkbox cũ
                    },
                  },
                  "edit"
                );
              },
              data() {
                return {
                  rowData: rowData,
                };
              },
            });
            app.mount(cell);
          },
        },
      ];
    },
    fetchData() {
      this.axios
        .get("/api/admin/role/all")
        .then((response) => {
          if (response.data.success === true && response.data.status == 200) {
            this.permissions = response.data.data.permissions;
            this.setColumns();
            this.DataTableData = response.data.data.roles;
            this.table = $(this.$refs.myTable).DataTable({
              data: this.DataTableData,
              columns: this.columns,
              scrollX: true,
            });
          }
        })
        .catch((error) => {
          if (error.response.status == 403) {
            this.logout();
          }
          if (error.response.status == 401) {
            this.logout();
          }
          // alert(`Error ${error.response.status}: ${error.response.data.message}`);
        });
    },
    updateRole() {
      this.axios
        .post(`/api/admin/role/update/${this.roleForm.id}`, this.roleForm)
        .then((response) => {
          if (response.data.status === 200 && response.data.success == true) {
            this.updateRowData(
              this.roleForm.id,
              response.data.data.role_update
            );
            this.$swal.fire({
              position: "top-end",
              icon: "success",
              title: `Add role ${this.roleForm.name} success`,
              showConfirmButton: false,
              timer: this.$config.notificationTimer ?? 1000,
            });
          } else {
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: `Error ${error.response.status}: ${error.response.data.message}`,
              // footer: '<a href="">Why do I have this issue?</a>'
            });
          }
        })
        .catch((error) => {
          // Nếu không thành công, hiển thị thông báo lỗi
          if (error.response.status == 403) {
            this.logout();
          }
          if (error.response.status == 401) {
            this.logout();
          }
          // alert(`Error ${error.response.status}: ${error.response.data.message}`);
          this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: `Error ${error.response.status}: ${error.response.data.message}`,
            // footer: '<a href="">Why do I have this issue?</a>'
          });
        });
    },
    isPermissionChecked(permissions, permissionId) {
      // return true;
      this.roleForm["permission_" + permissionId] = false;
      if (Array.isArray(permissions)) {
        const isCheck = permissions.some(
          (permission) => permission.id === permissionId
        );
        if (isCheck) {
          this.roleForm["permission_" + permissionId] = true;
        }
        return isCheck;
      } else {
        return false;
      }
      // return true;
    },
    handleCheckboxClick(permissionId, checked) {
      this.roleForm["permission_" + permissionId] = checked;
    },

    updateRowData(id, newRole) {
      let elementToUpdate = this.DataTableData.find((item) => item.id === id);
      if (elementToUpdate) {
        elementToUpdate.permissions = newRole.permissions;
        elementToUpdate.name = newRole.name;
        elementToUpdate.status = newRole.status;
        elementToUpdate.description = newRole.description;
      }

      $(this.$refs.myTable).DataTable().destroy();
      // this.setColumns();
      this.table = $(this.$refs.myTable).DataTable({
        data: this.DataTableData,
        columns: this.columns,
        scrollX: true,
      });
    },
  },
  computed: {},
};
</script>
