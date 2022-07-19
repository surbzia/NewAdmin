<template>
        <div class="row align-items-center">
            <div class="col-md-4">
                <img style="height: 100px !important" src="/templete/vendors/images/banner-img.png"
                    alt="">
            </div>
            <div class="col-md-8">
                <h4 class="font-20 weight-500 mb-10 text-capitalize">
                    Welcome back <div class="weight-800 font-50" style="color: #036c76; font-size: 53px;">
                       {{user.name}}</div>
                </h4>
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
