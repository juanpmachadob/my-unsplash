<template>
  <div>
    <v-btn
      :disabled="dialog"
      class="rounded-lg"
      color="red darken-2"
      outlined
      @click="dialog = true"
    >
      <v-icon>mdi-delete</v-icon>
    </v-btn>
    <v-dialog v-model="dialog" max-width="500px" persistent>
      <v-card class="rounded-lg">
        <v-card-title>
          <span class="text-h5">Delete photo</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12" align="center">
                <v-img
                  max-width="250px"
                  :src="photo.url"
                ></v-img>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  label="Password*"
                  type="password"
                  required
                ></v-text-field>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            class="rounded-lg"
            color="secondary"
            :disabled="deleting"
            @click="dialog = false"
            >Cancel</v-btn
          >
          <v-btn
            class="rounded-lg"
            color="danger"
            dark
            :loading="deleting"
            @click="deletePhoto()"
          >
            Delete
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "DeleteDialog",
  data: () => ({
    dialog: false,
    deleting: false,
  }),
  props: {
    index: String,
    photo: Object
  },
  methods: {
    deletePhoto() {
      this.deleting = true;
      this.axios
        .delete(`/api/photo/${this.index}`, this.photo)
        .then((res) => {
          this.$root.$emit("getPhotos");
          this.deleting = false;
          this.dialog = false;
        })
        .catch((err) => {
          alert(err);
          this.deleting = false;
        });
    },
  },
};
</script>