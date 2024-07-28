<template>
  <div class="add_role">
    <div class="row d-flex justify-content-center">
      <div class="col-md-7">
        <div class="card show border border-0">
          <div class="card-body">
            <h4 class="card-title text-center fs-4">Add Role</h4>
            <div class="col-md-12">
              <form @submit.prevent="addRole">
                <div class="form-group">
                  <label for="role-name">Role name</label>
                  <input id="role-name" type="text" placeholder="Enter role name" class="form-control" v-model="role.name"
                    required />
                </div>
                <div class="form-group">
                  <label for="role-description">Description</label>
                  <textarea id="role-description" type="text" placeholder="Enter description" class="form-control"
                    cols="70" rows="7" v-model="role.description"></textarea>
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
</template>
<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
export default {
  data() {
    return {
      role: {},
    };
  },
  methods: {
    ...mapActions(["logout"]),
    addRole() {
      // Gọi API để thêm ngôn ngữ mới
      this.axios
        .post("/api/admin/role/add", this.role)
        .then((response) => {
          if (response.data.status === 200) {
            this.$swal.fire({
              position: "top-end",
              icon: "success",
              title: `Add role ${this.role.name} success`,
              showConfirmButton: false,
              timer: this.$config.notificationTimer ?? 1000,
            });
            this.role = {};
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
  },
};
</script>
<style lang="scss"></style>
