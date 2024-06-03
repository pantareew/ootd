<template>
  <div class="row d-flex">
    <div class="col-6">
      <form ref="form" @submit.prevent="signup" novalidate>
        <div class="mb-3">
          <label for="fName" class="form-label">First Name</label>
          <input
            type="text"
            class="form-control"
            id="fName"
            placeholder="Enter your first name here"
            v-model="input.fName"
            name="fName"
          />
        </div>
        <div class="mb-3">
          <label for="lName" class="form-label">Last Name</label>
          <input
            type="text"
            class="form-control"
            id="lName"
            placeholder="Enter your last name here"
            v-model="input.lName"
            name="lName"
          />
        </div>
        <div class="mb-3">
          <label for="userName" class="form-label">Username</label>
          <input
            type="text"
            class="form-control"
            id="userName"
            placeholder="Set your username here"
            v-model="input.userName"
            name="userName"
          />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input
            type="password"
            class="form-control"
            id="password"
            placeholder="Set your password here"
            v-model="input.pwd"
            name="password"
          />
        </div>
        <div class="mb-3">
          <label for="repassword" class="form-label">Confirm Password</label>
          <input
            type="password"
            class="form-control"
            id="repassword"
            v-model="input.repwd"
            name="repassword"
            placeholder="Re-enter your password"
          />
        </div>
        <div class="mb-3">
          <label for="inputEmail" class="form-label">Email address</label>
          <input
            type="email"
            class="form-control"
            id="inputEmail"
            placeholder="Enter your email here"
            name="email"
            v-model="input.email"
          />
        </div>

        <button type="submit" class="btn btn-dark w-100">Submit</button>
      </form>
    </div>
    <div class="col-6">
      <div class="float-end" v-if="errors.length">
        <div class="alert alert-danger" role="alert">
          <p>Please correct the following error(s):</p>
          <ul>
            <li v-for="error in errors" :key="error">{{ error }}</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      input: {
        fName: "",
        lName: "",
        userName: "",
        pwd: "",
        repwd: "",
        email: "",
      },
      errors: [],
    };
  },
  methods: {
    checkForm() {
      var valid = true;
      this.errors = [];
      const letters = /^[a-zA-Z]+$/;
      const specialChar = /[$%^&*]/;
      const emailPattern = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/;
      if (!this.input.fName) {
        this.errors.push("First name is required");
        valid = false;
      } else if (!letters.test(this.input.fName)) {
        this.errors.push("First name must be letters only");
        valid = false;
      }
      if (!this.input.lName) {
        this.errors.push("Last name is required");
        valid = false;
      } else if (!letters.test(this.input.lName)) {
        this.errors.push("Last name must be letters only");
        valid = false;
      }
      if (!this.input.userName) {
        this.errors.push("Username is required");
        valid = false;
      } else if (this.input.userName.length < 3) {
        this.errors.push("Username must be at least 3 characters");
        valid = false;
      }
      if (!this.input.pwd) {
        this.errors.push("Password is required");
        valid = false;
      } else if (this.input.pwd.length < 8) {
        this.errors.push("Password must be at least 8 characters");
        valid = false;
      } else if (!specialChar.test(this.input.pwd)) {
        this.errors.push(
          "Password requires at least one special character $ % & * ^"
        );
        valid = false;
      }
      if (this.input.pwd && !this.input.repwd) {
        this.errors.push("Confirm Password is required");
        valid = false;
      } else if (this.input.pwd != this.input.repwd) {
        this.errors.push("Confirm password does not match");
        valid = false;
      }
      if (!this.input.email) {
        this.errors.push("Email is required");
        valid = false;
      } else if (!emailPattern.test(this.input.email)) {
        this.errors.push("Invalid email");
        valid = false;
      }
      return valid;
    },
    signup() {
      if (this.checkForm()) {
        // check if the username already exists
        fetch("http://localhost:3000/users")
          .then((res) => res.json())
          .then((users) => {
            const existingUser = users.find(
              (user) => user.username === this.input.userName
            );
            if (existingUser) {
              this.errors.push("Username already exists");
            } else {
              const requestOptions = {
                method: "POST",
                headers: {
                  "Content-Type": "application/json",
                },
                body: JSON.stringify({
                  fName: this.input.fName,
                  lName: this.input.lName,
                  username: this.input.userName,
                  password: this.input.pwd,
                  email: this.input.email,
                }),
              };

              fetch("http://localhost:3000/users", requestOptions)
                .then((res) => {
                  return res.json();
                })
                .then(() => {
                  this.$router.replace({ name: "login" });
                  this.$refs.form.reset();
                })
                .catch((err) => {
                  this.errors.push("Error:" + err);
                });
            }
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