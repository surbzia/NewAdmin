<template>
  <v-row>
    <v-col cols="12">
      <v-file-input v-model="file" label="Product CSV"></v-file-input>
    </v-col>
    <v-col cols="12">
      <v-btn
        color="secondary"
        elevation="1"
        large
        raised
        @click="uploadFile"
        :loading="btnloading"
        :disabled="btnloading"
        >Upload</v-btn
      >
    </v-col>
  </v-row>
</template>
<script>
const axios = require('axios');
import Swal from "sweetalert2";
export default {
  data() {
    return {
      file: undefined,
      btnloading: false,
    };
  },
  mounted() {},
  watch: {},
  methods: {
    async uploadFile() {
        if(this.btnloading==false){
            this.btnloading = true
            var formData = new FormData()
            formData.append('file',this.file)
            await axios.post('/api/a/products/uploadcsv',formData)
            this.file = undefined
            this.btnloading = false
            Swal.fire("Success!", "File Uploaded, Process is running in the background, Once Uploaded you will receive notificaiton", "success");
        }
    },
  },
  components: {},
  computed: {
    user() {
      return this.$store.getters.loggedInUser;
    },
  },
};
</script>