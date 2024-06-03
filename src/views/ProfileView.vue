<template>
  <div class="profile">
    <MyProfile v-if="authenticated" :user="user" />
    <div v-else class="alert alert-warning text-center" role="alert">
      Please
      <router-link to="/login" class="text-decoration-none text-danger"
        >log in</router-link
      >
      to view your profile
    </div>
  </div>
</template>
<script>
import MyProfile from "@/components/MyProfile.vue";

export default {
  name: "ProfileView",
  components: { MyProfile },
  props: {
    user: Object,
    authenticated: Boolean,
  },
};
</script>