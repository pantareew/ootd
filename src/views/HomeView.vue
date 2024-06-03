<template>
  <div class="home">
    <AllCards
      :outfits="getItems"
      :heartClicked="false"
      :authenticated="authenticated"
    />
    <paginate
      class="justify-content-center"
      :page-count="getPageCount"
      :page-range="3"
      :prev-text="' < '"
      :next-text="' > '"
      :margin-pages="1"
      :click-handler="clickCallback"
    ></paginate>
  </div>
</template>

<script>
// Components
import AllCards from "@/components/AllCards.vue";
import VuejsPaginateNext from "vuejs-paginate-next";

export default {
  name: "HomeView",

  components: {
    AllCards,
    paginate: VuejsPaginateNext,
  },
  props: {
    authenticated: Boolean,
  },
  data() {
    return {
      perPage: 6,
      currentPage: 1,
      allOutfits: [
        {
          id: 1,
          image: require("@/assets/outfit1.png"),
          styler: "clairemadison",
        },
        {
          id: 2,
          image: require("@/assets/outfit2.png"),
          styler: "bellapatridge",
        },
        { id: 3, image: require("@/assets/outfit3.png"), styler: "mayah" },
        { id: 4, image: require("@/assets/outfit4.png"), styler: "sophieaman" },
        { id: 5, image: require("@/assets/outfit5.png"), styler: "emmach" },
        { id: 6, image: require("@/assets/outfit6.png"), styler: "annahills" },
        { id: 7, image: require("@/assets/outfit12.png"), styler: "angelina" },
      ],
    };
  },
  computed: {
    //calculating number of items to be rendered on each page
    getItems: function () {
      let current = this.currentPage * this.perPage;
      let start = current - this.perPage;
      return this.allOutfits.slice(start, current);
    },
    //returns total number of pages required according to the total rows of data
    getPageCount: function () {
      return Math.ceil(this.allOutfits.length / this.perPage);
    },
  },
  methods: {
    //sets the clicked page
    clickCallback: function (pageNum) {
      this.currentPage = Number(pageNum);
    },
  },
};
</script>
<style>
.pagination {
  --bs-pagination-color: black;
  --bs-pagination-border-color: black;
  --bs-pagination-bg: #d9d9d9;
  --bs-pagination-active-bg: black;
  --bs-pagination-active-border-color: black;
  --bs-pagination-disabled-border-color: black;
  --bs-pagination-hover-color: white;
  --bs-pagination-hover-bg: black;
  --bs-pagination-hover-border-color: black;
  --bs-pagination-focus-box-shadow: none;
  --bs-pagination-focus-color: black;
  --bs-pagination-focus-bg: #d9d9d9;
}
</style>