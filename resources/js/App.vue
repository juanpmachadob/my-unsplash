<template>
  <v-app app>
    <app-bar :labelToSearch="labelToSearch" @resetSearch="resetSearch()" />
    <v-main>
      <toast />
      <image-container
        ref="ImageContainer"
        v-on:getSearchPhotos="getSearchPhotos"
      />
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
  data: () => ({
    labelToSearch: null,
  }),
  methods: {
    getSearchPhotos(labelToSearch) {
      this.labelToSearch = labelToSearch;
    },
    resetSearch() {
      this.labelToSearch = null;
      this.$refs.ImageContainer.resetSearch();
    },
  },
};
</script>
