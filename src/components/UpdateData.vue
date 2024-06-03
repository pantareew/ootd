<template>
  <form class="my-4" @submit.prevent="putData" novalidate>
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
      }
      return valid;
    },
    putData() {
      if (this.validateData()) {
        var putSQLApiURL = "resources/apis.php/date/" + this.date;

        // POST request using fetch with error handling
        const requestOptions = {
          method: "PUT",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            date: this.date,
            desc: this.desc,
          }),
        };

        fetch(putSQLApiURL, requestOptions)
          .then((response) => {
            //turning the response into the usable data
            return response.json();
          })
          .then(() => {
            this.msg = "Successfully updated";
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