<template>
  <div>
    <AllCards
      :heartClicked="true"
      :outfits="getItems"
      class="px-0"
      :user="user"
      :authenticated="true"
      @favRemoved="fetchData"
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
import AllCards from "@/components/AllCards.vue";
import VuejsPaginateNext from "vuejs-paginate-next";

export default {
  name: "FavData",
  components: { AllCards, paginate: VuejsPaginateNext },
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      perPage: 6,
      currentPage: 1,
      favOutfits: [],
    };
  },
  created() {
    this.fetchData();
  },
  computed: {
    //calculating number of items to be rendered on each page
    getItems: function () {
      let current = this.currentPage * this.perPage;
      let start = current - this.perPage;
      return this.favOutfits.slice(start, current);
    },
    //returns total number of pages required according to the total rows of data
    getPageCount: function () {
      return Math.ceil(this.favOutfits.length / this.perPage);
    },
  },
  methods: {
    //sets the clicked page
    clickCallback: function (pageNum) {
      this.currentPage = Number(pageNum);
    },
    fetchData() {
      const getSQLApiURL = `/cos30043/s103837447/ootd/resources/fav.php?username=${encodeURIComponent(
        this.user.username
      )}`;
      fetch(getSQLApiURL, { method: "GET" })
        .then((res) => {
          return res.json();
        })
        .then((data) => {
          this.favOutfits = data.data;
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
  },
};
</script>