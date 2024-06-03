<template>
  <form @submit.prevent="login" novalidate ref="form">
    <div v-if="errors.length">
      <div class="alert alert-danger" role="alert">
        <p>Please correct the following error(s):</p>
        <ul>
          <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul>
      </div>
    </div>
    <div class="mb-3">
      <label for="inputUsername" class="form-label">Username</label>
      <input
        type="text"
        class="form-control"
        placeholder="Enter your username here"
        id="inputUsername"
        v-model="input.username"
        name="inputUsername"
      />
    </div>
    <div class="mb-4">
      <label for="inputPassword" class="form-label">Password</label>
      <input
        type="password"
        class="form-control"
        id="inputPassword"
        placeholder="Enter your password here"
        v-model="input.password"
        name="inputPassword"
      />
    </div>
    <button type="submit" class="btn btn-dark w-100">Log in</button>
  </form>
</template>

<script>
export default {
  name: "LoginForm",
  data() {
    return {
      input: {
        username: "",
        password: "",
      },
      errors: [],
    };
  },
  methods: {
    checkForm() {
      this.errors = [];
      var valid = true;
      if (!this.input.username) {
        this.errors.push("Username is required");
        valid = false;
      } else if (this.input.username.length < 3) {
        this.errors.push("Username must be at least 3 characters");
        valid = false;
      }
      if (!this.input.password) {
        this.errors.push("Password is required");
        valid = false;
      } else if (this.input.password.length < 8) {
        this.errors.push("Password must be at least 8 characters");
        valid = false;
      }
      return valid;
    },
    login() {
      if (this.checkForm()) {
        const requestOptions = {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: this.input.username,
            password: this.input.password,
          }),
        };
        fetch("resources/user.php/", requestOptions)
          .then((res) => {
            return res.json();
          })
          .then((data) => {
            if (!data) {
              this.errors.push("username or password is incorrect");
            } else {
              this.$emit("authenticated", { status: true, data });
              this.$router.replace({
                name: "profile",
                params: { username: data.username },
              });
            }
          })
          .catch((err) => {
            this.errors.push("Error:" + err);
          });
      }
    },
  },
};
</script>
<style scoped>
input {
  background-color: #d9d9d9;
}
input::placeholder {
  color: #acaaaa;
}
</style>