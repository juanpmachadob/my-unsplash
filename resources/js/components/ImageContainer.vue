<template>
  <v-container>
    <v-row v-if="!photos">
      <v-chip class="mt-3">There is no photo added. Please add one.</v-chip>
    </v-row>
    <v-row v-else-if="photos.length === 0 && !searching">
      <v-col v-for="n in 18" :key="n" cols="6" md="4">
        <v-skeleton-loader
          class="ma-auto rounded-lg"
          type="image"
        ></v-skeleton-loader>
      </v-col>
    </v-row>
    <v-row v-else-if="photos.length === 0 && searching">
      <v-chip class="mt-3"
        >No photo could be found with the specified label.</v-chip
      >
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
    searching: null,
  }),
  mounted() {
    this.getPhotos();
    this.$root.$on("getPhotos", () => {
      this.getPhotos();
    });
    this.$root.$on("getSearchPhotos", (labelToSearch, data) => {
      this.getSearchPhotos(labelToSearch, data);
    });
  },
  methods: {
    getPhotos() {
      if (!this.searching) {
        this.axios.get("/api/photos").then((res) => {
          this.photos = res.data;
        });
      } else {
        this.$root.$emit("searchPhotos", this.searching);
      }
    },
    getSearchPhotos(labelToSearch, data) {
      this.searching = labelToSearch;
      this.photos = data;
      this.$emit("getSearchPhotos", labelToSearch);
    },
    resetSearch() {
      this.searching = null;
      this.getPhotos();
    },
  },
};
</script>