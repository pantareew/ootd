<template>
  <div class="card" style="width: 18rem">
    <img :src="outfit.image" class="card-img-top" alt="Outfit Image" />
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
      <div v-else class="float-end">
        <p class="card-text fw-medium fs-6 py-3">
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
    heart: {
      type: Boolean,
      default: true,
    },
    heartClicked: { type: Boolean },
    authenticated: { type: Boolean },
  },
  data() {
    return {
      toggleHeart: this.heartClicked,
    };
  },
  methods: {
    setHeart() {
      this.toggleHeart = !this.toggleHeart;
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
</style>