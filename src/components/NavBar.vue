<template>
  <nav class="navbar bg-white shadow d-flex justify-content-between px-5 py-2">
    <router-link to="/"
      ><img alt="OOTD logo" src="@/assets/logo.png"
    /></router-link>

    <div class="d-flex align-items-center w-50">
      <span class="mdi mdi-magnify searchIcon"></span>
      <input type="text" class="form-control searchBox" placeholder="Search" />
    </div>

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

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.searchBox {
  background-color: #d9d9d9;
  border: 1px solid black;
  border-radius: 0 12px 12px 0;
  border-left: none;
}
.searchBox::placeholder {
  color: #acaaaa;
}
.searchBox:focus {
  box-shadow: none;
  background-color: #d9d9d9;
  border: 1px solid black;
  border-left: none;
}
.searchIcon {
  font-size: 22px;
  background-color: #d9d9d9;
  border: 1px solid black;
  border-radius: 12px 0 0 12px;
  border-right: none;
  padding: 0 10px;
}
</style>
