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
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      date: null,
      msg: "",
    };
  },
  methods: {
    submitDel() {
      if (this.date) {
        var delSQLApiURL = `/cos30043/s103837447/ootd/resources/myOutfit.php?date=${encodeURIComponent(
          this.date
        )}&username=${encodeURIComponent(this.user.username)}`;

        const requestOptions = {
          method: "DELETE",
          headers: {
            "Content-Type": "application/json",
          },
        };
        fetch(delSQLApiURL, requestOptions)
          .then((response) => {
            return response.json();
          })
          .then((data) => {
            this.msg = data.message;
            this.$emit("dataDeleted");
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
</style>