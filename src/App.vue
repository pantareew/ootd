<template>
  <div id="app">
    <NavBar
      :authenticated="authenticated"
      :user="authenticatedUser"
      @logout="logout"
      v-if="!isSignupOrLogin"
    />
    <router-view
      @authenticated="setAuthenticated"
      :authenticated="authenticated"
      :user="authenticatedUser"
    />
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
export default {
  name: "App",

  data() {
    return {
      authenticated: false,
      authenticatedUser: null,
    };
  },
  computed: {
    isSignupOrLogin() {
      //check if the current route is signup or Login
      return this.$route.name === "signup" || this.$route.name === "login";
    },
  },
  components: { NavBar },
  methods: {
    setAuthenticated({ status, user }) {
      this.authenticated = status;
      this.authenticatedUser = user;
    },
    logout() {
      this.$router.replace({ name: "login" });
      this.authenticated = false;
      this.authenticatedUser = null;
    },
  },
};
</script>
<style>
@import url("https://fonts.googleapis.com/css2?family=Hanuman:wght@100;300;400;700;900&display=swap");
#app {
  font-family: Hanuman, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}
</style>