<template>
  <v-row class="no-gutters mt-3">
    <v-col cols="12">
      <v-row class="no-gutters">
        <v-text-field v-model="file_search" label="Search File"></v-text-field>
      </v-row>
      <v-row class="no-gutters">
        <v-file-input
          v-model="file"
          show-size
          truncate-length="20"
        ></v-file-input>
      </v-row>
      <v-divider></v-divider>
      <v-row class="no-gutters mt-3">
        <v-col v-for="fileL in files" :key="fileL.id" cols="4">
          <v-hover v-slot="{ hover }">
            <v-card class="ma-2" :elevation="hover ? 12 : 2">
              <v-card-title v-html="fileL.url"></v-card-title>
              <v-card-subtitle
                v-html="fileL.created_at_formatted"
              ></v-card-subtitle>
              <v-card-actions>
                <v-btn @click="$emit('selected_url',fileL)" outlined rounded text> Select File </v-btn>
              </v-card-actions>
            </v-card>
          </v-hover>
        </v-col>
      </v-row>
    </v-col>
  </v-row>
</template>
<script>
import fileservice from "@services/auth/file";
export default {
  props: {
    tablename: {
      type: String,
      default: "",
    },
  },
  methods: {
    getFiles() {
      fileservice
        .get("q=" + this.file_search + "&tablename=" + this.tablename)
        .then((e) => {
          this.files = e.data;
        });
    },
    async uploadFile() {
      if (this.file) {
        var formData = new FormData();
        formData.append("attachements[0]", this.file);
        formData.append("table_name", "album_songs");
        formData.append("ref_id", 0);
        formData.append("type", 2);
        var res = await fileservice.create(formData);
        this.file = null;
        this.files.push(res.data[0]);
      }
    },
  },
  data() {
    return {
      file_search: "",
      file: null,
      files: [],
    };
  },
  mounted() {
    this.getFiles();
  },
  watch: {
    file_search() {
      this.getFiles();
    },
    file() {
      this.uploadFile();
    },
  },
};
</script>