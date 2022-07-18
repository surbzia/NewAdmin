<template>
  <div>
     <breadcumbs :data="{step1:'Roles',step2:'Edit'}"></breadcumbs>
<div class="container-fluid">
    <div class="row card">
     <div class="row pl-3 pr-3 pt-2">
          <div class="col-md-6 text-left">
        <div class="icheck-info d-inline">
            <input type="checkbox" @click="select_all" v-model="select_all_check" id="select_all">
            <label for="select_all">
            Select All
            </label>
          </div>
       </div>
        <div class="col-md-6 text-right">
         <button type="button" @click="addpermission" class="btn bg-gradient-primary btn-sm pl-3 pr-3 text-white" >Update</button>
       </div>
     </div>
      <div class="row p-3">
         <div class="col-md-6">
         <input type="text" v-model="form.name" class="form-control " placeholder="Role Name">
         <p class="text-danger" v-if="errors.name.length > 0" >{{errors.name[0]}}</p>
       </div>
       <div class="col-md-6">
         <input type="text" v-model="form.title" class="form-control " placeholder="Role Title">
         <p class="text-danger" v-if="errors.title.length > 0" >{{errors.title[0]}}</p>
       </div>
      </div>
      <hr>
       <div class="col-md-12">
        <div class="row">
        <div class="col-md-3" v-for="permission  in permissions" :key="permission.id">
             <div class="icheck-primary d-inline">
            <input type="checkbox" v-bind:id="permission.id" v-bind:value='permission.id'  v-model='form.permissions'>
            <label v-bind:for="permission.id">
             {{permission.title}}
            </label>
          </div>
         </div>
        </div>
       </div>
    </div>
</div>
  </div>
</template>

<script>
import rolesservice from "@services/auth/roles";
import permissionservice from "@services/auth/permission";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
export default {
  components:{
    breadcumbs
  },
  name: "auth.roles.add",
  async mounted(){
    this.permissions = await permissionservice.get('')
        var res = await rolesservice.get(this.form.id)
        let permissions_to_select = res.permissions.map(e=>{
            return e.permission_id;
        });

        this.form = {
            name: res.name,
            title: res.title,
            id: this.$route.params.id,
            permissions: permissions_to_select,
        }
        // this.form.permissions = permissions_to_select;
         if(this.permissions.length == this.form.permissions.length){
          this.select_all_check = true;
        }
  },
  methods: {
    resetError(){
        this.errors = {
          name:[],
          title: [],
          permissions: [],
      }
    },
     select_all: function() {
      if(this.permissions.length == this.form.permissions.length){
          this.form.permissions =[];
      }else{
        this.form.permissions =[];
      for( var key in this.permissions){
      this.form.permissions.push(this.permissions[key].id);
      }
      }
    },
    addpermission: async function () {
        this.resetError()
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("name", this.form.name);
        formdata.append("title", this.form.title);
        console.log(this.form.permissions);
        for(let i = 0; i < this.form.permissions.length; i++){
            formdata.append("permissions["+i+"]", this.form.permissions[i]);
        }
            var res = await rolesservice.update(formdata, this.form.id)
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
             this.$toaster.success("Role has been updated successfully.");
              setTimeout(() => 
             this.$router.push({ name: "auth.roles.listing" }), 
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
      select_all_check:false,
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          name: '',
          title: '',
          permissions: [],
      },
      errors: {
          name:[],
          title: [],
          permissions: [],
      },
      permissions: [],
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Roles",
          to: { name: "auth.roles.listing" },
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
