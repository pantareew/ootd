<template>
  <div class="card" style="width: 18rem">
    <img
      :src="`/cos30043/s103837447/ootd/resources/uploads/${outfit.image}`"
      class="card-img-top"
      alt="Outfit Image"
    />
    <div class="card-body px-3 py-0">
      <div
        v-if="heart"
        class="d-flex justify-content-between align-items-center"
      >
        <p class="card-text fw-medium fs-6 mt-3">
          Style by <span class="styler">{{ outfit.styler }}</span>
        </p>
        <span
          v-if="authenticated"
          class="mdi fs-2"
          :class="toggleHeart ? 'mdi-heart' : 'mdi-heart-outline'"
          @click="setHeart"
        ></span>

        <router-link
          v-else
          to="/login"
          class="mdi mdi-heart-outline fs-2 text-dark"
        ></router-link>
      </div>
      <div v-else class="m-1">
        <p class="card-text fw-normal fs-6 float-start">
          {{ outfit.desc }}
        </p>

        <p class="card-text fw-medium fs-6 float-end">
          {{ outfit.date }}
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "OutfitCard",
  props: {
    outfit: {
      type: Object,
      required: true,
    },
    user: {
      type: Object,
      required: true,
    },
    heart: {
      type: Boolean,
      default: true,
    },
    heartClicked: { type: Boolean, required: true },
    authenticated: { type: Boolean },
  },
  data() {
    return {
      toggleHeart: this.heartClicked,
    };
  },
  watch: {
    heartClicked(newClick) {
      this.toggleHeart = newClick; //update toggleHeart when props value is changed
    },
  },
  mounted() {
    if (this.user) {
      this.favStatus();
    }
  },
  methods: {
    setHeart() {
      //remove from fav if the user clicks heart that is already been faved
      if (this.toggleHeart) {
        this.removeFav();
      } else {
        this.addFav();
      }
      this.toggleHeart = !this.toggleHeart;
    },
    addFav() {
      const postSQLApiURL = "/cos30043/s103837447/ootd/resources/fav.php/";
      const postRequest = {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          username: this.user.username,
          id: this.outfit.id,
        }),
      };
      fetch(postSQLApiURL, postRequest)
        .then((res) => {
          return res.json();
        })
        .then(() => {})
        .catch((err) => {
          console.error(err);
        });
    },
    removeFav() {
      const deleteURL = `/cos30043/s103837447/ootd/resources/fav.php?username=${encodeURIComponent(
        this.user.username
      )}&id=${encodeURIComponent(this.outfit.id)}`;
      const delRequest = {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
        },
      };
      fetch(deleteURL, delRequest)
        .then((res) => {
          return res.json();
        })
        .then(() => {
          this.$emit("favRemoved");
        })
        .catch((err) => {
          console.error(err);
        });
    },
    //check if the outfit has been faved or not
    favStatus() {
      const statusURL = `resources/favStatus.php?username=${encodeURIComponent(
        this.user.username
      )}&id=${encodeURIComponent(this.outfit.id)}`;
      fetch(statusURL)
        .then((res) => {
          return res.json();
        })
        .then((data) => {
          this.toggleHeart = data.isFav;
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>

<style scoped>
.styler {
  color: #acaaaa;
  text-transform: lowercase;
}
span {
  cursor: pointer;
}

img {
  width: 100%;
  height: 350px;
  object-fit: cover;
}
</style>