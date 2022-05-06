<template>
  <div>

  <breadcumbs :data="{step1:'Permissions',step2:'Edit'}"></breadcumbs>
<div class="container-fluid">
    <div class="row card p-3">
     <div class="row">
        <div class="col-md-6">
        <input type="text" v-model="form.name" class="form-control form-control-sm">
      </div>
      <div class="col-md-6">
        <input type="text" v-model="form.title" class="form-control form-control-sm">
      </div>
     </div>
     <div class="row">
        <div class="col-md-12 text-right">
         <button type="button" @click="addpermission" class="btn bg-gradient-primary btn-sm pl-3 pr-3 text-white">Submit</button>
       </div>
     </div>
    </div>
</div>
  </div>
</template>

<script>
import permissionservice from "@services/auth/permission";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
export default {
  components:{
breadcumbs
  },
  name: "auth.users.add",
  async mounted(){
 
  },
  methods: {
    resetError(){
        this.errors = {
          name:[],
          title: [],
      }
    },
    addpermission: async function () {
        this.resetError()

        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("name", this.form.name);
        formdata.append("title", this.form.title);
        this.btnloading = false;
  
            var res = await permissionservice.create(formdata)
    
        if(!res.status){
            if(res.data.name){
                this.errors.name = res.data.name
            }
            if(res.data.title){
                this.errors.title = res.data.title
            }
            //errors here
        }else{
            //suuccess here
                 this.$toaster.success("Permission has been added successfully.");
              setTimeout(() => 
             this.$router.push({ name: "auth.permissions.listing" }), 
              3000);
        }
     
    },
  },
  computed: {
    user() {
        return this.$store.getters.loggedInUser;
    },
  },
  data() {
    return {
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          name: '',
          title: '',
      },
      errors: {
          name:[],
          title: []
      },
      loading: false,
      btnloading: false,
    };
  },
};
</script>
