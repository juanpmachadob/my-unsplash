<template>
  <div>
    <v-btn
      :disabled="dialog"
      color="success"
      class="ma-2 rounded-lg"
      @click="dialog = true"
    >
      Add a photo
      <v-icon right dark> mdi-image-plus </v-icon>
    </v-btn>
    <v-dialog v-model="dialog" max-width="500px" persistent>
      <v-card class="rounded-lg">
        <v-card-title>
          <span class="text-h5">Add a new photo</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  v-model="photo.label"
                  label="Label*"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-radio-group v-model="type" row>
                  <v-radio
                    label="Add photo URL"
                    color="blue"
                    value="add"
                  ></v-radio>
                  <v-radio
                    label="Upload photo"
                    color="red"
                    value="upload"
                  ></v-radio>
                </v-radio-group>
              </v-col>
              <v-col cols="12" v-if="type == 'add'">
                <v-text-field
                  v-model="photo.url"
                  label="Photo URL*"
                  required
                ></v-text-field>
              </v-col>
              <v-col cols="12" v-else>
                <v-file-input
                  show-size
                  label="Photo input*"
                  prepend-icon="mdi-image"
                  accept="image/png, image/jpg, image/jpeg"
                  type="file"
                  @change="get_photo"
                ></v-file-input>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            class="rounded-lg"
            color="secondary"
            :disabled="uploading"
            @click="dialog = false"
            >Cancel</v-btn
          >
          <v-btn
            class="rounded-lg"
            color="success"
            :loading="uploading"
            @click="submitPhoto()"
          >
            Submit
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "AddDialog",
  data: () => ({
    photo: {
      label: null,
      url: null,
      image: null,
    },
    type: "add",
    dialog: false,
    uploading: false,
  }),
  methods: {
    get_photo(e) {
      this.photo.image = e;
    },
    submitPhoto() {
      let photo;
      if (this.type == "upload") {
        this.photo.url = null;
        photo = new FormData();
        for (let key in this.photo) {
          photo.append(key, this.photo[key]);
        }
      } else {
        this.photo.image = null;
        photo = this.photo;
      }
      this.uploading = true;
      this.axios
        .post("/api/photos", photo)
        .then((res) => {
          this.$root.$emit("getPhotos");
          this.uploading = false;
          this.dialog = false;
        })
        .catch((err) => {
          alert(err);
          this.uploading = false;
        });
    },
  },
};
</script>