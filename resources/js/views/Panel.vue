<template><div>
   <breadcumbs :data="{step1:'Dashboard', step2:''}"></breadcumbs>
  <div class="container-fluid">
    <div class="row m-3">
       <div class="col-md-4 card">
         <div style=" text-align: center;">
           <img src="https://www.pavilionweb.com/wp-content/uploads/2017/03/man-300x300.png" height="165px" class="responsive" alt="">
         </div>
       </div>
      <div class="col-md-8 card">
      <table class="table table-bordered">
        <tr>
            <td>User Name :</td>
            <td>{{user.name}}</td>
        </tr>
        <tr>
            <td>User Email :</td>
            <td>{{user.email}}</td>
        </tr>
        <tr>
            <td>User Phone :</td>
            <td>{{(user.phone != null) ? user.phone : 'N/A' }}</td>
        </tr>
      </table>

      </div>
     
    </div>
  </div>
</div>
    
</template>
<script>
import Swal from "sweetalert2";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
const axios = require('axios');
export default {
  components: {
    breadcumbs
  },
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
