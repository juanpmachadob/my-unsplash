<template>
  <v-container>
    <v-row>
      <v-col v-for="n in 9" :key="n" cols="6" md="4">
        <v-card class="rounded-lg">
          <v-img
            class="white--text hover-photo"
            src="https://cdn.vuetifyjs.com/images/cards/docks.jpg"
          >
            <div class="d-flex flex-column photo-content" style="height: 100%">
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-chip close close-icon="mdi-delete" color="red" outlined
                  >Delete</v-chip
                >
              </v-card-actions>
              <v-card-title class="mt-auto"
                >Top 10 Australian beaches</v-card-title
              >
            </div>
          </v-img>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "ImageContainer",
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
  box-shadow: 0 0 200px rgba(0,0,0,0.75) inset;
}
.hover-photo:hover .v-image__image {
  transform: scale(1.025);
  transition: all 0.3s;
}
</style>