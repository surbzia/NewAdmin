<template>
<div class="main-container">
    <div class="card-box pd-20 mb-30">
       Front end
    </div>
</div>

</template>
<script>
import Swal from "sweetalert2";
const axios = require('axios');
export default {
  data(){
    return {

    }
  },
  methods:{
  },
   mounted(){

  },
  computed: {
    user() {
      return this.$store.getters.loggedInUser;
    },
  },
};
</script>
