<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-10">
        <h1 class="text-center my-5">Welcome, {{ user.fName }} !</h1>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-10">
        <ul class="nav nav-tabs justify-content-between">
          <li class="nav-item" v-for="(item, index) in tabItems" :key="index">
            <span
              class="nav-link px-2 px-md-3 px-lg-4 px-xl-5"
              :class="{ active: tab === index }"
              @click="tab = index"
              >{{ item }}</span
            >
          </li>
        </ul>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-11 px-4">
        <ViewData v-show="tab === 0" :user="user" ref="viewData"></ViewData>
        <FavData v-show="tab === 4" :user="user" ref="viewFav"></FavData>
      </div>
      <div class="col-10 col-sm-8 col-md-4">
        <AddData
          v-show="tab === 1"
          :user="user"
          @dataAdded="fetchView"
        ></AddData>
        <UpdateData
          v-show="tab === 2"
          :user="user"
          @dataUpdated="fetchView"
        ></UpdateData>
        <DelData
          v-show="tab === 3"
          :user="user"
          @dataDeleted="fetchView"
        ></DelData>
      </div>
    </div>
  </div>
</template>

<script>
import ViewData from "@/components/ViewData.vue";
import AddData from "@/components/AddData.vue";
import DelData from "@/components/DelData.vue";
import UpdateData from "@/components/UpdateData.vue";
import FavData from "@/components/FavData.vue";
export default {
  name: "MyProfile",
  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      tab: 0,
      tabItems: [
        "My OOTD",
        "Add OOTD",
        "Edit OOTD",
        "Delete OOTD",
        "View Favs",
      ],
    };
  },
  components: {
    ViewData,
    AddData,
    UpdateData,
    DelData,
    FavData,
  },
  methods: {
    fetchView() {
      this.$refs.viewData.fetchData();
    },
  },
};
</script>

<style>
.nav-tabs {
  border-bottom-color: black;
}
.nav-item .nav-link {
  color: black;
}
.nav-item .nav-link.active {
  color: white;
  background-color: black;
}
.nav-item .nav-link:hover {
  border-color: black;
}
</style>