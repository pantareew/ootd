<template>
  <div class="container">
    <div class="row">
      <div
        class="col-md-4 my-5 d-flex justify-content-center"
        v-for="outfit in outfits"
        :key="outfit.id"
      >
        <OutfitCard
          :outfit="outfit"
          :heart="heart"
          :heartClicked="heartClicked"
          :authenticated="authenticated"
          :user="user"
          @favRemoved="handleFavRemoved"
        />
      </div>
    </div>
  </div>
</template>

<script>
import OutfitCard from "@/components/OutfitCard.vue";

export default {
  components: {
    OutfitCard,
  },
  props: {
    user: {
      type: Object,
      required: true,
    },
    outfits: {
      type: Array,
      required: true,
    },
    heart: {
      type: Boolean,
      default: true,
    },
    heartClicked: { type: Boolean, required: true },
    authenticated: Boolean,
  },
  methods: {
    handleFavRemoved() {
      this.$emit("favRemoved");
    },
  },
};
</script>
