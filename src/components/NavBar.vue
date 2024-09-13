<template>
  <nav
    class="navbar bg-white shadow d-flex justify-content-between px-md-5 px-2 py-2"
  >
    <!--Logo-->
    <router-link to="/"
      ><img alt="OOTD logo" src="@/assets/logo.png"
    /></router-link>

    <!--Button-->
    <div class="button">
      <router-link to="/login" v-if="!authenticated"
        ><button class="btn btn-dark" type="button">
          Share your OOTD
        </button></router-link
      >
      <div v-else>
        <router-link
          v-if="this.$route.name === 'home'"
          :to="{ name: 'profile', params: { username: user.username } }"
        >
          <button class="btn btn-dark" type="button">
            My Account <span class="mdi mdi-account-outline fs-5"></span>
          </button>
        </router-link>

        <button v-else class="btn btn-dark" @click="logout">Log out</button>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "NavBar",
  props: {
    authenticated: Boolean,
    user: Object,
  },
  methods: {
    logout() {
      this.$emit("logout");
    },
  },
};
</script>

