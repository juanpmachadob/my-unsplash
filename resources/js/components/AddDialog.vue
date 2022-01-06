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
        <v-form v-model="valid" @submit.prevent="submitPhoto()" ref="form">
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
                    :rules="rules.label"
                    :counter="28"
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
                    :rules="rules.url"
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
                    :rules="rules.image"
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
              type="button"
              :disabled="uploading"
              @click="dialog = false"
              >Cancel</v-btn
            >
            <v-btn
              class="rounded-lg"
              color="success"
              type="submit"
              :loading="uploading"
            >
              Submit
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  name: "AddDialog",
  data: () => ({
    valid: false,
    dialog: false,
    uploading: false,
    type: "add",
    photo: {
      label: "",
      url: null,
      image: null,
    },
    rules: {
      label: [
        (v) => !!v || "Label is required.",
        (v) => v.length <= 28 || "Label must be less than 28 characters." + v,
        (v) => v.length >= 4 || "Label must be at least 4 characters length.",
      ],
      url: [
        (v) => !!v || "Url is required.",
        (v) => (v || "").indexOf(" ") < 0 || "No spaces are allowed.",
      ],
      image: [(v) => !!v || "Photo is required."],
    },
  }),
  methods: {
    get_photo(e) {
      this.photo.image = e;
    },
    async submitPhoto() {
      let photo;
      this.uploading = true;
      if (this.type == "upload") {
        this.photo.url = null;
        photo = new FormData();
        for (let key in this.photo) {
          if (this.photo[key]) {
            photo.append(key, this.photo[key]);
          }
        }
      } else {
        this.photo.image = null;
        await this.validateImage(this.photo.url)
          .then((status) => {
            photo = this.photo;
          })
          .catch((err) => {
            this.$root.$emit("showToast", "The image could not be loaded.", 4);
            this.uploading = false;
          });
      }
      if (this.uploading) {
        this.axios
          .post("/api/photos", photo)
          .then((res) => {
            this.$root.$emit("getPhotos");
            this.uploading = false;
            this.dialog = false;
            this.$root.$emit("showToast", res.data, 2);
            this.clear();
          })
          .catch((err) => {
            this.uploading = false;
            if (err.response.status === 422) {
              this.$root.$emit("showToast", err.response.data.errors, 4);
            } else {
              this.$root.$emit(
                "showToast",
                "An error has occurred. Try again.",
                4
              );
              console.log("Error:", err);
            }
          });
      }
    },
    validateImage(path) {
      return new Promise((resolve, reject) => {
        const img = new Image();
        img.onload = () => resolve({ path, status: "ok" });
        img.onerror = () => reject({ path, status: "error" });
        img.src = path;
      });
    },
    clear() {
      this.$refs.form.reset();
      this.photo = {
        label: "",
        url: null,
        image: null,
      };
      this.type = "add";
    },
  },
};
</script>