<template>
  <div class="home">
    <!--Search-->
    <div class="d-flex justify-content-center align-items-center w-100 mt-3">
      <div class="d-flex align-items-center w-75">
        <span class="mdi mdi-magnify searchIcon"></span>
        <input
          type="text"
          class="form-control searchBox"
          placeholder="Search result is based on the outfit's description"
          v-model="input.desc"
        />
        <span class="mdi mdi-filter fs-1 filterIcon" @click="showModal"></span>
        <!--Modal-->
        <div class="modal fade" tabindex="-1" id="filterModal">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-body">
                <label for="inputStyler mr-2"
                  >Choose the styler you like:
                </label>
                <select
                  v-model="input.styler"
                  id="inputStyler"
                  name="inputStyler"
                >
                  <option selected value="">Any styler</option>
                  <option
                    v-for="styler in allStylers"
                    :key="styler"
                    :value="styler"
                  >
                    {{ styler }}
                  </option>
                </select>
              </div>
              <div class="modal-footer">
                <button
                  type="button"
                  class="btn btn-dark"
                  data-bs-dismiss="modal"
                >
                  Close
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <AllCards
      :outfits="getItems"
      :heartClicked="false"
      :authenticated="authenticated"
      :user="user"
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
import { Modal } from "bootstrap";
export default {
  name: "HomeView",

  components: {
    AllCards,
    paginate: VuejsPaginateNext,
  },
  props: {
    authenticated: Boolean,
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      perPage: 6,
      currentPage: 1,
      allOutfits: [],
      input: {
        styler: "",
        desc: "",
      },
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
      return this.filterOutfits.slice(start, current);
    },
    //returns total number of pages required according to the total rows of data
    getPageCount: function () {
      return Math.ceil(this.filterOutfits.length / this.perPage);
    },
    filterOutfits() {
      return this.allOutfits.filter(
        (outfit) =>
          outfit.desc.toLowerCase().match(this.input.desc.toLowerCase()) &&
          outfit.styler.toLowerCase().match(this.input.styler.toLowerCase())
      );
    },
    allStylers() {
      const stylers = this.allOutfits.map((outfit) => outfit.styler);
      return [...new Set(stylers)];
    },
  },
  methods: {
    //sets the clicked page
    clickCallback: function (pageNum) {
      this.currentPage = Number(pageNum);
    },
    fetchData() {
      let getSQLApiURL;
      if (this.user && this.user.username) {
        getSQLApiURL = `/cos30043/s103837447/ootd/resources/allOutfits.php?username=${encodeURIComponent(
          this.user.username
        )}`;
      } else {
        getSQLApiURL = `/cos30043/s103837447/ootd/resources/allOutfits.php`;
      }
      fetch(getSQLApiURL, { method: "GET" })
        .then((res) => {
          return res.json();
        })
        .then((data) => {
          if (data.success) {
            this.allOutfits = data.data;
          } else {
            console.error("Failed to fetch data: ", data.message);
          }
        })
        .catch((error) => {
          console.error("Error:", error);
        });
    },
    showModal() {
      const modal = new Modal(document.getElementById("filterModal"));
      modal.show();
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
.searchBox {
  background-color: #d9d9d9;
  border: 1px solid black;
  border-radius: 0 12px 12px 0;
  border-left: none;
}
.searchBox::placeholder {
  color: #acaaaa;
}
.searchBox:focus {
  box-shadow: none;
  background-color: #d9d9d9;
  border: 1px solid black;
  border-left: none;
}
.searchIcon {
  font-size: 22px;
  background-color: #d9d9d9;
  border: 1px solid black;
  border-radius: 12px 0 0 12px;
  border-right: none;
  padding: 0 7px;
}

.filterIcon {
  cursor: pointer;
}
</style>