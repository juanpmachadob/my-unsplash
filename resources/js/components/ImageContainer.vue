<template>
  <v-container>
    <v-row>
      <v-col v-for="(photo, index) in photos" :key="index" cols="6" md="4">
        <ImageItem :photo="photo" :index="index" />
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import ImageItem from "./ImageItem.vue";
export default {
  name: "ImageContainer",
  components: {
    ImageItem,
  },
  data: () => ({
    photos: [],
  }),
  mounted() {
    this.getPhotos();
    this.$root.$on("getPhotos", () => {
      this.getPhotos();
    });
  },
  methods: {
    getPhotos() {
      this.axios.get("/api/photos").then((res) => {
        this.photos = res.data;
      });
    },
  },
};
</script>