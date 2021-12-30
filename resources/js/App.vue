<template>
  <v-app app>
    <app-bar />
    <v-main>
      <toast />
      <image-container />
      <!-- <router-view></router-view> -->
    </v-main>
  </v-app>
</template>

<script>
import AppBar from "./components/AppBar.vue";
import Toast from "./components/Toast.vue";
import ImageContainer from "./components/ImageContainer.vue";
export default {
  name: "App",
  components: {
    AppBar,
    Toast,
    ImageContainer,
  },
};
</script>
