<template>
  <div class="user_manager">
    <div class="row position-relative">
      <div class="col-md-12">
        <div class="card show border border-0">
          <button ref="myModalAddUserBtn" type="button" class="btn btn-all-add-edit my-3 mx-3 position-absolute"
                  data-toggle="modal" data-target="#ModalAddUser">
            Thêm tài khoản
          </button>
          <div class="card-body">
            <h4 class="card-title text-md-center fs-4 my-3 text-right">
              Quản lý tài khoản
            </h4>
            <div class="table-responsive-lg">
              <table ref="myTable" class="table table-bordered table-striped table-hover display nowrap"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <button ref="myModalBtn" type="button" class="btn btn-primary d-none" data-toggle="modal"
            data-target="#exampleModal">
      Launch demo modal
    </button>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
      <div class="modal-dialog p-lg-5 p-1 pt-5 pt-lg-5 d-flex justify-content-center" role="document">
        <div class="modal-content col-md-7">
          <div class="word_default p-4">
            <h3 class="text-center">Chỉnh sửa</h3>
            <button ref="btnCloseEditUser" type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="col-md-12 d-flex flex-column align-items-center">
              <form @submit.prevent="updateUser" class="col-md-12 p-0 p-md-4">
                <div class="row">
                  <div class="col-md-12 p-0 p-md-4">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" placeholder="Enter description" class="form-control" v-model="userForm.email"
                             disabled required/>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" placeholder="Enter description" class="form-control" v-model="userForm.name"
                             required disabled/>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-6">
                          <label>Status</label>
                          <select class="form-select" v-model="userForm.status" required>
                            <option :value="1">OPEN</option>
                            <option :value="0">CLOSE</option>
                          </select>
                        </div>
                        <div class="col-6">
                          <label>Lock Status</label>
                          <select class="form-select" v-model="userForm.is_lock" required>
                            <option :value="0">UNLOCK</option>
                            <option :value="1">LOCK</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div v-if="showCheckbox" class="form-check" v-for="(role, index) in roles"
                         :key="`checkbox_${role.id}`">
                      <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" value="" :key="`checkbox_${role.id}`"
                               :checked="isRolesChecked(userRoles, role.id)" @click="handleCheckboxClick(role.id, $event.target.checked)
                            "/>{{ role.name }}
                      </label>
                    </div>
                  </div>
                </div>
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-all-add-edit py-2 px-5">
                    Thay đổi
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- add user -->
  <div class="row">
    <!-- Modal -->
    <div class="modal fade" id="ModalAddUser" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
         aria-hidden="true">
      <div class="modal-dialog p-lg-5 p-1 pt-5 pt-lg-5 d-flex justify-content-center" role="document">
        <div class="modal-content col-md-7">
          <div class="word_default p-4">
            <h3 class="text-center">Tạo tài khoản mới</h3>
            <button ref="btnCloseAddUser" type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <div class="row">
              <div class="col-md-12 d-flex flex-column align-items-center">
                <form @submit.prevent="createNewUser" class="col-md-12">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" placeholder="Enter Email" class="form-control" v-model="newUser.email"
                               required/>
                      </div>
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" placeholder="Enter Username" class="form-control" v-model="newUser.name"
                               required/>
                      </div>
                      <div class="form-group">
                        <div class="row">
                          <div class="col-6">
                            <label>Status</label>
                            <select class="form-select" v-model="newUser.status" required>
                              <option :value="1">OPEN</option>
                              <option :value="0">CLOSE</option>
                            </select>
                          </div>
                          <div class="col-6">
                            <label>Lock Status</label>
                            <select class="form-select" v-model="newUser.is_lock" required>
                              <option :value="0">UNLOCK</option>
                              <option :value="1">LOCK</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label>Role</label>
                        <select class="form-select" aria-label="Default select example" v-model="newUser.role" required>
                          <option v-for="role in roles" :key="role.id" :value="`${role.id}`">
                            {{ role.name }}
                          </option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-all-add-edit py-2 px-5">
                      Thêm
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
</template>

<style lang="scss"></style>

<script>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import $ from "jquery";
import {createApp, h} from "vue";

DataTable.use(DataTablesCore);
import {mapGetters, mapMutations, mapActions} from "vuex";

export default {
  data() {
    return {
      users: [],
      showUserForm: false,
      newUser: {
        name: "",
        email: "",
        role: 1,
        status: 1,
        is_lock: 0
      },
      userForm: [],
      userPasswwordForm: [],
      userRoles: [],
      roles: [],
      dataTableData: [],
      showCheckbox: true
    };
  },
  created() {
    this.axios
        .get("/api/admin/user/roles")
        .then((response) => {
          if (response.data.message === "success") {
            this.roles = response.data.data;
          }
        })
        .catch((error) => {
          if (error.response.status === 403) {
            this.logout();
          }
          if (error.response.status === 401) {
            this.logout();
          }
          this.$swal.fire({
            icon: "error",
            title: "Oops...",
            text: `Error ${error.response.status}: ${error.response.data.message}`,
          });

        });
    this.fetchData();
  },
  methods: {
    ...mapActions(["logout"]),
    addUser() {
      this.newUser = {
        name: "",
        email: "",
        role: "",
        status: 1,
        is_lock: 0
      };
      this.showUserForm = false;
    },
    createNewUser() {
      this.axios
          .post("/api/admin/user/create-new-user", this.newUser)
          .then((response) => {
            if (response.data.status === 200 && response.data.success === true) {
              const newUser = response.data.data.user_created;
              if (newUser) {
                this.addRowData(newUser);
              }
              this.$swal.fire({
                position: "top-end",
                icon: "success",
                title: `Add new user ${this.newUser.name} success`,
                showConfirmButton: false,
                timer: this.$config.notificationTimer ?? 1000,
              });
              this.newUser = {};
              this.$refs.btnCloseAddUser.click();
              this.reloadTable();
            } else {
              this.$swal.fire({
                position: "top-end",
                icon: "error",
                title: response.data.message,
                showConfirmButton: false,
                timer: this.$config.notificationTimer ?? 1000,
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
            this.$swal.fire({
              icon: "error",
              title: "Oops...",
              text: `Error ${error.response.status}: ${error.response.data.message}`,
            });
          })
          .finally(() => (this.loading = false));
    },
    updateUser() {
      this.axios
          .post(`/api/admin/user/change-role-user/${this.userForm.id}`, this.userForm)
          .then((response) => {
            if (response.data.status === 200) {
              this.updateRowData(
                  this.userForm.id,
                  response.data.data.user_update
              );
              this.$swal.fire({
                position: "top-end",
                icon: "success",
                title: `Change role ${this.userForm.name} Success`,
                showConfirmButton: false,
                timer: this.$config.notificationTimer ?? 1000,
              });
              this.$refs.btnCloseEditUser.click();
              this.reloadTable();
            }
          })
          .catch((error) => {
            if (error.response.status === 403) {
              this.logout();
            }
            if (error.response.status === 401) {
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
        {data: "id", title: "ID"},
        {data: "name", title: "Name"},
        {data: "email", title: "Email"},
        {
          data: "id",
          title: "Roles",
          class: "columns-list",
          createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
            const app = createApp({
              render() {
                return h(
                    "ul",
                    {class: "ul-list mb-0"},
                    rowData.roles.map((role) => {
                      return h("li", {}, [
                        h(
                            "p",
                            {
                              class: "mb-2",
                            },
                            role.name
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
          data: "status", title: "Status",
          render: function (data, type, row) {
            let statusClass = row.status === 1 ? 'success' : 'danger';
            let statusText = row.status === 1 ? 'Opening' : 'Closed';
            return `<span class="badge badge-${statusClass} p-2 mb-0 mt-1">${statusText}</span>`;
          }
        },
        {
          data: "is_lock", title: "Lock Status",
          render: function (data, type, row) {
            let lockClass = row.is_lock === 1 ? 'danger' : 'success';
            let lockText = row.is_lock === 1 ? 'Locked' : 'Unlock';
            return `<span class="badge badge-${lockClass} p-2 mb-0 mt-1">${lockText}</span>`;
          }
        },
        {
          data: "id",
          title: "Action",
          createdCell: function (cell, cellData, rowData, rowIndex, colIndex) {
            const app = createApp({
              render() {
                return [
                  h(
                      "a",
                      {
                        to: `/admin/user-manager/change-role-user/${rowData.id}`,
                        class: "btn btn-all-add-edit me-2",
                        onClick: () => {
                          self.userForm = {
                            name: rowData.name,
                            email: rowData.email,
                            id: rowData.id,
                            status: rowData.status,
                            is_lock: rowData.is_lock,
                          };
                          self.showCheckbox = false;
                          setTimeout(() => {
                            self.showCheckbox = true;
                            self.userRoles = rowData.roles;
                            self.$refs.myModalBtn.click();
                          }, 10); // xử lý chờ 10 ms để userRoles kịp xóa list checkbox cũ
                        },
                      },
                      "Edit"
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
          },
        },
      ];
    },
    fetchData() {
      this.axios
          .get("/api/admin/user/allusers")
          .then((response) => {
            if (
                response.data.message === "success" &&
                response.data.status === 200
            ) {
              this.roles = response.data.data.roles;
              this.setColumns();

              this.dataTableData = response.data.data.users;
              this.table = $(this.$refs.myTable).DataTable({
                data: this.dataTableData,
                columns: this.columns,
                scrollX: true,
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
    isRolesChecked(roles, roleId) {
      if (Array.isArray(roles)) {
        const isCheck = roles.some((role) => role.id === roleId);
        this.userForm["role_" + roleId] = isCheck;
        return isCheck;
      } else {
        return false;
      }
    },
    handleCheckboxClick(roleId, checked) {
      this.userForm["role_" + roleId] = checked;
    },
    updateRowData(id, userUpdate) {
      let elementToUpdate = this.dataTableData.find((item) => item.id === id);
      if (elementToUpdate) {
        elementToUpdate.roles = userUpdate.roles;
      }

      $(this.$refs.myTable).DataTable().destroy();
      this.table = $(this.$refs.myTable).DataTable({
        data: this.dataTableData,
        columns: this.columns,
        scrollX: true,
      });
    },
    addRowData(userUpdate) {
      this.dataTableData.push(userUpdate);

      $(this.$refs.myTable).DataTable().destroy();
      this.table = $(this.$refs.myTable).DataTable({
        data: this.dataTableData,
        columns: this.columns,
        scrollX: true,
      });
    },
    reloadTable() {
      $(this.$refs.myTable).DataTable().destroy();
      this.fetchData();
    }
  },
};
</script>
