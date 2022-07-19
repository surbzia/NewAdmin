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
        <input type="text" v-model="form.slug" class="form-control form-control-sm">
      </div>
     </div>
          <div class="row mt-4">
         <div class="col-md-6">
       <select class="form-control form-control-sm" v-model="form.module" @input.prevent="createModule($event)">
        <option value="">Select module</option>
        <option :value="mod.module" v-for="mod in modules" :key="mod.modules">{{mod.module}}</option>
       </select>
      </div>

     </div>
     <div class="row">
        <div class="col-md-12 text-right mt-30">
         <button type="button" @click="addpermission" class="btn btn-success">Update</button>
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
        var res = await permissionservice.get(this.form.id)
      this.form = {
          name: res.name,
          slug: res.slug,
          module: res.module,
          id: this.$route.params.id
      };
      this.GetAllModules();
  },
    methods: {
       async GetAllModules(){
       let res = await permissionservice.GetModules();
       this.modules = res.data;
      },
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
            var res = await permissionservice.update(formdata, this.form.id)
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
                   this.$toaster.success("Permission has been updated successfully.");
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
        modules:[],
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          name: '',
          slug: '',
            module: '',
      },
      errors: {
          name:[],
          title: []
      },
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Permissions",
          to: { name: "auth.permissions.listing" },
          disabled: false,
          exact: true,
        }
      ],
      loading: false,
      btnloading: false,
      rules: {
        required: (value) => !!value || "Required.",
      },
    };
  },
};
</script>
