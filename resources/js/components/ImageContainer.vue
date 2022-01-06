<template>
  <v-container>
    <v-row v-if="!photos">
      <v-chip class="mt-3">There is no photo added. Please add one.</v-chip>
    </v-row>
    <v-row v-else-if="photos.length === 0">
      <v-col v-for="n in 18" :key="n" cols="6" md="4">
        <v-skeleton-loader
          class="ma-auto rounded-lg"
          type="image"
        ></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row v-else>
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
    }
  },
};
</script>