<template>
  <header id="page-topbar">
    <div class="navbar-header">
      <div class="d-flex">
        <!-- LOGO -->
        <div class="navbar-brand-box">
          <router-link to="/admin" class="logo logo-dark">
            <span class="logo-sm">
              <span class="text-f">NA<span class="text-l">S</span></span>
            </span>
            <span class="logo-lg">
              <span class="text-f">NAM ANH <span class="space"></span><span class="text-l">SHOP</span></span>
            </span>
          </router-link>
          <router-link to="/admin" class="logo logo-light">
            <span class="logo-sm">
              <span class="text-f">NA<span class="text-l">S</span></span>
            </span>
            <span class="logo-lg">
              <span class="text-f">NAM ANH <span class="space"></span><span class="text-l">SHOP</span></span>
            </span>
          </router-link>
        </div>

        <button
          type="button"
          class="btn btn-sm px-3 font-size-24 header-item waves-effect"
          id="vertical-menu-btn"
        >
          <i class="ri-menu-2-line align-middle"></i>
        </button>
      </div>

      <div class="d-flex">
        <div class="dropdown d-inline-block d-lg-none ml-2">
          <button
            type="button"
            class="btn header-item noti-icon waves-effect"
            id="page-header-search-dropdown"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <i class="ri-search-line"></i>
          </button>
          <div
            class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
            aria-labelledby="page-header-search-dropdown"
          >
            <form class="p-3">
              <div class="form-group m-0">
                <div class="input-group">
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search ..."
                  />
                  <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                      <i class="ri-search-line"></i>
                    </button>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="dropdown d-none d-lg-inline-block ml-1">
          <button
            type="button"
            class="btn header-item noti-icon waves-effect"
            data-toggle="fullscreen"
          >
            <i class="ri-fullscreen-line"></i>
          </button>
        </div>

        <div class="dropdown d-inline-block user-dropdown">
          <button
            type="button"
            class="btn header-item waves-effect"
            id="page-header-user-dropdown"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
          >
            <img
              class="rounded-circle header-profile-user"
              src="/assets/images/users/avatar-default.gif"
              alt="Header Avatar"
            />
            <span class="d-none d-xl-inline-block ml-1">{{
              UserForm.name
            }}</span>
            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right">
            <router-link class="dropdown-item" :to="{ name: 'Profile User' }"
              ><i class="ri-user-line align-middle mr-1"></i>
              Profile</router-link>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item text-danger" href="#" @click="logoutSubmit"
              ><i class="ri-shut-down-line align-middle mr-1 text-danger"></i>
              Logout</a
            >
          </div>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
import { mapGetters, mapMutations, mapActions } from "vuex";
export default {
  data() {
    return {

    };
  },
  created() {
    this.fetchData();
    const body = document.querySelector("body");
    if (body.getAttribute("data-sidebar") === "light") {
      body.setAttribute("data-sidebar", "dark");
    }
  },
  methods: {
    ...mapActions(["logout"]),
    logoutSubmit() {
      this.logout();
    },
    reloadPage() {
      location.reload();
    },
    goToProject(index){
      console.log(index);
    },
    fetchData() {

    }
  },
  computed: {
    authUser() {
      if (this.$store.getters.getAuthUser.id !== undefined) {
        return this.$store.getters.getAuthUser;
      }
      return JSON.parse(localStorage.getItem("authUser"));
    },
    UserForm() {
      return {
        name: this.authUser ? this.authUser.name : "",
      };
    },
  },
  mounted() {
  },
};
</script>
