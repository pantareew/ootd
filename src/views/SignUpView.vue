<template>
  <div class="container">
    <div class="row">
      <div class="col-4 my-2 my-lg-3">
        <router-link to="/"
          ><img alt="OOTD logo" src="@/assets/logo.png"
        /></router-link>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <h2 class="my-3">Sign Up</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-8">
        <SignUpForm />
      </div>
    </div>
  </div>
</template>
<script>
import SignUpForm from "@/components/SignUpForm.vue";
export default {
  name: "SignUpView",
  components: { SignUpForm },
};
</script>