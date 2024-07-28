<template>
  <div class="col-lg-9">
    <div class="text-center">
      <a href="/" class="logo">
        <img src="/images/logo.jpg" height="50" alt="logo" />
      </a>
      <h4 class="font-size-18 mt-4">Log in</h4>
    </div>
    <div class="p-2 mt-5">
      <form class="form-horizontal" @submit.prevent="loginSubmit">
        <div class="form-group auth-form-group-custom mb-4">
          <i class="ri-mail-line auti-custom-input-icon"></i>
          <label for="email">Email</label>
          <input type="email" v-model="loginData.email" class="form-control" id="email" placeholder="Enter email" />
        </div>
        <div class="form-group auth-form-group-custom mb-4">
          <i class="ri-lock-2-line auti-custom-input-icon"></i>
          <label for="userpassword">Password</label>
          <input v-model="loginData.password" type="password" class="form-control" id="userpassword"
            placeholder="Enter password" required />
        </div>
        <div class="mt-4 text-center">
          <button class="btn btn-all-add-edit w-md waves-effect waves-light" type="submit">
            Log In
          </button>
        </div>
      </form>
    </div>

    <div class="mt-5 text-center">
      <p>
        © 2024 Nam Anh
        <i class="mdi mdi-heart text-danger"></i> Shop
      </p>
    </div>
  </div>
</template>
<script>
import { mapGetters, mapMutations, mapActions } from "vuex";

export default {
  data() {
    return {
      loginData: {
        email: this.$route.query.email ?? null,
      },

    };
  },
  computed: {},
  created() {
    document.body.classList.add("auth-body-bg");
  },
  methods: {
    ...mapActions(["firstLogin", "login"]),
    loginSubmit() {
      this.login(this.loginData);
    },
  },
  mounted() {
  },
};
</script>
