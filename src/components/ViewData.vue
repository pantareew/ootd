<template>
  <div>
    <AllCards :heart="false" :outfits="getItems" class="px-0" />
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
import AllCards from "@/components/AllCards.vue";
import VuejsPaginateNext from "vuejs-paginate-next";

export default {
  name: "ViewData",
  components: { AllCards, paginate: VuejsPaginateNext },
  data() {
    return {
      perPage: 6,
      currentPage: 1,
      myOutfits: [
        {
          id: 1,
          image: require("@/assets/my1.png"),
          styler: "Styler 1",
          date: "01/02/23",
        },
        {
          id: 2,
          image: require("@/assets/my2.png"),
          styler: "Styler 1",
          date: "02/02/23",
        },
      ],
    };
  },
  computed: {
    //calculating number of items to be rendered on each page
    getItems: function () {
      let current = this.currentPage * this.perPage;
      let start = current - this.perPage;
      return this.myOutfits.slice(start, current);
    },
    //returns total number of pages required according to the total rows of data
    getPageCount: function () {
      return Math.ceil(this.myOutfits.length / this.perPage);
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

