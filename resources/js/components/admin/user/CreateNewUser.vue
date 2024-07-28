<template>
  <div class="create_user">
    <div class="row d-flex justify-content-center">
      <div class="col-md-7">
        <div class="card show border border-0">
          <div class="card-body">
            <h4 class="card-title text-center fs-4">Create New User</h4>
            <div class="col-md-12">
              <form @submit.prevent="createNewUser">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" placeholder="Enter description" class="form-control" v-model="newUser.email"
                        required />
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" placeholder="Enter description" class="form-control" v-model="newUser.name"
                        required />
                    </div>
                    <!-- <div class="form-group">
                      <label>Password</label>
                      <input type="password" placeholder="Enter password" class="form-control" v-model="newUser.password"
                        required />
                    </div> -->
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
                    Add User
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
      roles: [],
      newUser: {
        // đối tượng người dùng mới
        password: "",
        email: "",
        role: "",
        name: "",
      },
    };
  },

  created() {
    this.axios.get("/api/admin/user/roles").then((response) => {
      if (response.data.message === 'success') {
        this.roles = response.data.data;
      }
    });
  },
  methods: {
    ...mapActions(["logout"]),
    createNewUser() {
      this.axios
        .post("/api/admin/user/create-new-user", this.newUser)
        .then((response) => {
          if (response.data.status === 200) {
            // if (response.data.success === true) {

            // }
            this.$swal.fire({
              position: 'top-end',
              icon: 'success',
              title: `Add new user ${this.newUser.name} success`,
              showConfirmButton: false,
              timer: this.$config.notificationTimer ?? 1000
            })
            this.newUser = {};
            // alert(response.data.message);
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
            icon: 'error',
            title: 'Oops...',
            text: `Error ${error.response.status}: ${error.response.data.message}`,
            // footer: '<a href="">Why do I have this issue?</a>'
          })
          // alert(`Error ${error.response.status}: ${error.response.data.message}`);

        })
        .finally(() => (this.loading = false));
    },
  },
};
</script>
