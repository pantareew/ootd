<template>
  <form class="my-4" @submit.prevent="putData" novalidate ref="updateForm">
    <div class="mb-3">
      <label for="date" class="form-label">Date</label>
      <input
        type="date"
        class="form-control"
        id="date"
        v-model="date"
        name="date"
      />
    </div>
    <div class="mb-4">
      <label for="desc" class="form-label">Short Description</label>
      <textarea
        class="form-control"
        id="desc"
        rows="2"
        placeholder="Add short description of your style!"
        name="desc"
        v-model="desc"
      />
    </div>
    <button type="submit" class="btn btn-dark w-100">Edit this outfit</button>
    <div v-if="errors.length">
      <div class="alert alert-danger mt-4" role="alert">
        <p>Please correct the following error(s):</p>
        <ul>
          <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul>
      </div>
    </div>
    <h6 class="my-5">Status: {{ msg }}</h6>
  </form>
</template>

<script>
export default {
  name: "UpdateData",
  data() {
    return {
      date: null,
      desc: "",
      msg: "",
      errors: [],
    };
  },
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  methods: {
    validateData() {
      this.errors = [];
      var valid = true;
      if (!this.date) {
        this.errors.push("Date of the outfit is required");
        valid = false;
      }
      if (!this.desc) {
        this.errors.push("Please enter the outfit's description");
        valid = false;
      } else if (this.desc.length < 10) {
        this.errors.push("Outfit description must have at least 10 characters");
        valid = false;
      } else if (this.desc.length > 50) {
        this.errors.push("Outfit description can't be more than 50 characters");
        valid = false;
      }
      return valid;
    },
    putData() {
      if (this.validateData()) {
        var putSQLApiURL = `/cos30043/s103837447/ootd/resources/myOutfit.php?date=${encodeURIComponent(
          this.date
        )}&username=${encodeURIComponent(this.user.username)}`;

        // POST request using fetch with error handling
        const requestOptions = {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            desc: this.desc,
          }),
        };
        fetch(putSQLApiURL, requestOptions)
          .then((response) => {
            return response.json();
          })
          .then((data) => {
            this.msg = data.message;
            this.$emit("dataUpdated");
            this.desc = "";
            this.date = null;
          })
          .catch((error) => {
            this.msg = "Error: " + error;
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
textarea {
  background-color: #d9d9d9;
}
textarea::placeholder {
  color: #acaaaa;
}
</style>