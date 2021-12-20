<template>
  <v-container>
    <v-row>
      <v-col v-for="n in 9" :key="n" cols="6" md="4">
        <ImageItem />
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
};
</script>