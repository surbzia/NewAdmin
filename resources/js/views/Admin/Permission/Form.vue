<template>
  <div>

  <breadcumbs :data="{step1:'Permissions',step2:'Add'}"></breadcumbs>
<div class="container-fluid">
    <div class="row card p-3">
     <div class="row">
        <div class="col-md-6">
        <input type="text" v-model="form.name" class="form-control form-control-sm" @input.prevent="createSlug($event)" placeholder="Name">
      </div>
      <div class="col-md-6">
        <input type="text" v-model="form.slug" class="form-control form-control-sm" placeholder="Slug">
      </div>

     </div>
     <div class="row mt-4">
        <div class="col-md-6" v-if="form.isNewModule">
        <input type="text" v-model="form.module" class="form-control form-control-sm"  placeholder="New Module Name">
      </div>
         <div class="col-md-6">
       <select class="form-control form-control-sm" v-model="form.module" @input.prevent="createModule($event)">
        <option value="">Select module</option>
        <option value="add" class="text-primary">Add Module</option>
        <option :value="mod.module" v-for="mod in modules" :key="mod.modules">{{mod.module}}</option>
       </select>
      </div>

     </div>
     <div class="row">
        <div class="col-md-12 text-right mt-30">
         <button type="button" @click="addpermission" class="btn btn-success">Submit</button>
       </div>
     </div>
    </div>
</div>
  </div>
</template>

<script>
import permissionservice from "@services/auth/permission";
import DefaultService from "@services/auth/default.js";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
export default {
  components:{
breadcumbs
  },
  name: "auth.users.add",
  mounted() {
    this.GetAllModules();
  },
  methods: {
    resetError(){
        this.errors = {
          name:[],
          title: [],
      }
      },
   async GetAllModules(){
       let res = await permissionservice.GetModules();
       this.modules = res.data;
      },
      createSlug(e) {
          let text = e.target.value;
          if (this.form.module != '') {
            text= (text.trim)? text.trim(): text.replace(/^\s+|\s+$/g,'');
              this.form.slug = text.split(/\s+/).join('-') + '-' + this.form.module;
                if (text == '') {
              this.form.slug = '';
            }
          } else {
              this.form.name = '';
              alert('Please select module first..');
          }


    },
      createModule(e) {
          if (e.target.value == 'add') {
              this.form.isNewModule = true;
          } else {
              this.form.isNewModule = false;
          }
    },
    addpermission: async function () {
        this.resetError()

        this.btnloading = true;
        this.btnloading = false;

            var res = await permissionservice.create(this.form)

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
        modules:[],
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          name: '',
          module: '',
          isNewModule: false,
          slug: '',
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
