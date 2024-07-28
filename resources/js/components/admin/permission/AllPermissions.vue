<template>
  <div class="all_permissions">
    <div class="row">
      <div class="col-12">
        <div class="card show border border-0">
          <div class="card-body">
            <h4 class="card-title text-center fs-4 mb-3">All Permissions</h4>
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
      <div class="modal-dialog p-lg-5 p-1 pt-5 pt-lg-5 d-flex flex-column align-items-center" role="document">
        <div class="modal-content col-md-7">
          <div class="row">
            <div class="word_default p-4">
              <h3 class="text-center">Edit Permission</h3>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <div class="row">
                <div class="col-md-12 d-flex flex-column align-items-center">
                  <form @submit.prevent="updatePermission">
                    <div class="form-group">
                      <label for="permission-name">Permission name</label>
                      <input id="permission-name" type="text" placeholder="Enter permission name" class="form-control"
                        v-model="permissionForm.name" required />
                    </div>
                    <div class="form-group">
                      <label for="permission-description">Description</label>
                      <textarea id="permission-description" type="text" placeholder="Enter description"
                        class="form-control" cols="70" rows="4" v-model="permissionForm.description"></textarea>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-all-add-edit">
                        Save Permission
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
import { createApp, h } from "vue";
import router from "@resources/js/router/index"; // import router từ file router.js
import { mapGetters, mapMutations, mapActions } from "vuex";
export default {
  data() {
    return {
      permissions: [],
      permissionForm: [],
      DataTableData: [],
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
        .post(`/api/admin/permission/update-status/${rowData.id}`)
        .then((response) => {
          if (response.data.status === 200) {
            this.$swal.fire({
              position: "top-end",
              icon: "success",
              title: response.data.message,
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
        { data: "name", title: "Permission" },
        { data: "description", title: "Description" },
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
                    to: `/admin/permission/edit/${rowData.id}`,
                    class: "btn btn-all-add-edit",
                    onClick: () => {
                      self.permissionForm = {
                        name: rowData.name,
                        description: rowData.description,
                        id: rowData.id,
                      };
                      self.$refs.myModalBtn.click();
                      // router.push({ name: 'Edit Permission', params: { id: rowData.id } });
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
        .get("/api/admin/permission/all")
        .then((response) => {
          if (response.data.success === true && response.data.status == 200) {
            this.setColumns();

            this.DataTableData = response.data.data.permissions;
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

    updatePermission() {
      this.axios
        .post(
          `/api/admin/permission/update/${this.permissionForm.id}`,
          this.permissionForm
        )
        .then((response) => {
          if (response.data.status === 200 && response.data.success == true) {
            this.updateRowData(
              this.permissionForm.id,
              response.data.data.permission_update
            );
            this.$swal.fire({
              position: "top-end",
              icon: "success",
              title: `Add role ${this.permissionForm.name} success`,
              showConfirmButton: false,
              timer: this.$config.notificationTimer ?? 1000,
            });
          } else {
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
    updateRowData(id, newPermission) {
      let elementToUpdate = this.DataTableData.find((item) => item.id === id);
      if (elementToUpdate) {
        elementToUpdate.name = newPermission.name;
        elementToUpdate.status = newPermission.status;
        elementToUpdate.description = newPermission.description;
      }

      $(this.$refs.myTable).DataTable().destroy();
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
