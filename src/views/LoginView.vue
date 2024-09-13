<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-4 text-center">
        <h1 class="mt-5">Log in</h1>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-10 col-sm-6 col-xl-4">
        <LoginForm @authenticated="setAuthenticated" />
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-10 col-sm-6 col-xl-4 my-4">
        <h6>
          Don't have an account with us?
          <router-link
            to="/signup"
            class="text-decoration-none text-body-tertiary float-end"
            >Sign up here</router-link
          >
        </h6>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="text-center">
        <router-link to="/">
          <img src="@/assets/logo.png" alt="OOTD Logo"
        /></router-link>
      </div>
    </div>
  </div>
</template>
<script>
import LoginForm from "@/components/LoginForm.vue";
export default {
  name: "LoginView",
  components: { LoginForm },
  methods: {
    setAuthenticated(status) {
      this.$emit("authenticated", status);
    },
  },
};
</script>
