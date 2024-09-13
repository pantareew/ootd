<template>
  <form
    ref="addForm"
    class="my-4"
    @submit.prevent="postData"
    enctype="multipart/form-data"
  >
    <div v-if="errors.length">
      <div class="alert alert-danger" role="alert">
        <p>Please correct the following error(s):</p>
        <ul>
          <li v-for="error in errors" :key="error">{{ error }}</li>
        </ul>
      </div>
    </div>
    <div class="mb-3">
      <label for="img" class="form-label">Add Image</label>
      <input
        type="file"
        class="form-control"
        id="img"
        name="img"
        ref="img"
        @change="validateImg"
        required
      />
    </div>
    <div class="mb-3">
      <label for="desc" class="form-label">Short Description</label>
      <textarea
        class="form-control"
        id="desc"
        rows="2"
        placeholder="Briefly describe your style!"
        v-model="input.desc"
        name="desc"
      />
    </div>
    <div class="mb-4">
      <label for="date" class="form-label">Date</label>
      <input
        type="date"
        class="form-control"
        id="date"
        v-model="input.date"
        name="date"
      />
    </div>
    <button type="submit" class="btn btn-dark w-100">Add this outfit</button>
    <h6 class="my-5">Status: {{ msg }}</h6>
  </form>
</template>

<script>
export default {
  name: "AddData",
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      input: {
        desc: "",
        date: null,
        image: null,
      },
      errors: [],
      msg: "",
    };
  },
  methods: {
    //only image file is allowed
    validateImg(event) {
      this.errors = [];
      const file = event.target.files[0];
      if (file.type === "image/jpeg" || file.type === "image/png") {
        this.input.image = file;
      } else {
        this.errors.push("Please select new file (jpeg/png)");
        this.input.image = null;
      }
    },
    //validation of the form
    checkForm() {
      this.errors = [];
      var valid = true;
      if (!this.input.desc) {
        this.errors.push(" Outfit description is required  ");
        valid = false;
      } else if (this.input.desc.length < 10) {
        this.errors.push("Outfit description must have at least 10 characters");
        valid = false;
      } else if (this.input.desc.length > 50) {
        this.errors.push("Outfit description can't be more than 50 characters");
        valid = false;
      }
      if (!this.input.date) {
        this.errors.push("Please select the date of this outfit ");
        valid = false;
      }
      return valid;
    },
    postData() {
      if (this.checkForm() && this.input.image) {
        const inputData = new FormData();
        inputData.append("styler", this.user.username);
        inputData.append("desc", this.input.desc);
        inputData.append("date", this.input.date);
        inputData.append("img", this.$refs.img.files[0]);

        fetch("/cos30043/s103837447/ootd/resources/myOutfit.php/", {
          method: "POST",
          body: inputData,
        })
          .then((res) => {
            return res.json();
          })
          .then((data) => {
            if (data.success) {
              this.$emit("dataAdded");
              this.msg = "The outfit is successfully added";
              this.input.desc = "";
              this.input.date = null;
              this.input.image = null;
              this.$refs.img = null;
            } else {
              this.msg = data.message;
            }
          })
          .catch((err) => {
            this.msg = "Error:" + err;
          });
      }
    },
  },
};
</script>

<style scoped>
textarea {
  background-color: #d9d9d9;
}
textarea::placeholder {
  color: #acaaaa;
}
</style>