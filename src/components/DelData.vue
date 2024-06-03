<template>
  <form class="my-4" @submit.prevent="submitDel">
    <div class="mb-4">
      <label for="date" class="form-label">Date</label>
      <input
        type="date"
        class="form-control"
        id="date"
        v-model="date"
        name="date"
        required
      />
    </div>
    <button type="submit" class="btn btn-dark w-100">Delete this outfit</button>
    <h6 class="my-5">Status: {{ msg }}</h6>
  </form>
</template>

<script>
export default {
  name: "DelData",
  data() {
    return {
      date: null,
      msg: "",
    };
  },
  methods: {
    submitDel() {
      if (this.date) {
        var delSQLApiURL = "resources/apis.php/date/" + this.date;
        const requestOptions = {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            date: this.date,
          }),
        };
        fetch(delSQLApiURL, requestOptions)
          .then((response) => {
            return response.json();
          })
          .then(() => {
            this.msg = "Data deleted successfully";
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
</style>