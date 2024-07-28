<template>
  <div class="add_permission">
    <div class="row d-flex justify-content-center">
      <div class="col-md-7">
        <div class="card show border border-0">
          <div class="card-body">
            <h4 class="card-title text-center fs-4">Add Permission</h4>
            <div class="col-md-12">
              <form @submit.prevent="addPermission">
                <div class="form-group">
                  <label for="permission-name">Permission name</label>
                  <input id="permission-name" type="text" placeholder="Enter permission name" class="form-control"
                    v-model="permission.name" required />
                </div>
                <div class="form-group">
                  <label for="permission-description">Description</label>
                  <textarea id="permission-description" type="text" placeholder="Enter description" class="form-control"
                    cols="70" rows="7" v-model="permission.description"></textarea>
                </div>
                <div class="d-flex justify-content-center">
                  <button type="submit" class="btn btn-all-add-edit">
                    Add Permission
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
      permission: {},
    };
  },
  methods: {
    ...mapActions(["logout"]),
    addPermission() {
      // Gọi API để thêm ngôn ngữ mới
      this.axios
        .post("/api/admin/permission/add", this.permission)
        .then((response) => {
          if (response.data.status === 200) {
            this.$swal.fire({
              position: "top-end",
              icon: "success",
              title: `Add permission ${this.permission.name} success`,
              showConfirmButton: false,
              timer: this.$config.notificationTimer ?? 1000,
            });
            this.permission = {};
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
