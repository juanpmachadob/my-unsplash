<template>
  <v-card class="rounded-lg">
    <v-img v-if="photo" class="white--text hover-photo" :src="getImage">
      <div class="d-flex flex-column photo-content" style="height: 100%">
        <v-card-actions>
          <v-spacer></v-spacer>
          <delete-dialog :index="index" :photo="photo" />
        </v-card-actions>
        <v-card-title class="mt-auto">{{ photo.label }}</v-card-title>
      </div>
    </v-img>
  </v-card>
</template>

<script>
import DeleteDialog from "./DeleteDialog.vue";
export default {
  name: "ImageItem",
  components: {
    DeleteDialog,
  },
  props: {
    index: String,
    photo: Object,
  },
  computed: {
    getImage() {
      var placeholderUrl = "https://via.placeholder.com/300x200?text=Image+doesn't+exist.";
      if (this.photo.url === null) {
        this.photo.url = placeholderUrl;
      } else {
        const img = new Image();
        img.src = this.photo.url;
        img.onerror = () => {
          this.photo.url = placeholderUrl;
        };
      }
      return this.photo.url;
    },
  },
};
</script>

<style>
.hover-photo .v-image__image,
.d-flex.photo-content {
  transition: all 0.3s;
}
.d-flex.photo-content {
  visibility: hidden;
  opacity: 0;
}
.hover-photo:hover .d-flex.photo-content {
  visibility: visible;
  opacity: 1;
  box-shadow: 0 0 200px rgba(0, 0, 0, 0.75) inset;
}
.hover-photo:hover .v-image__image {
  transform: scale(1.025);
  transition: all 0.3s;
}
</style>