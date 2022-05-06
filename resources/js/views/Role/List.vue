<template>
  <div>
     <breadcumbs :data="{step1:'Roles',step2:''}"></breadcumbs>
<div class="container-fluid">
    <div class="row card">
                <div class="row mt-2 ml-2 mr-2">
              <div class="col-md-8">
          <input
            type="text"
            v-model="search"
            class="form-control form-control-sm"
            placeholder="Search Here"
          />
        </div>
        <div class="col-md-4 text-right">
          <router-link
            :to="{ name: 'auth.roles.add' }"
            class="btn bg-gradient-primary btn-sm pl-3 pr-3"
            >Add</router-link
          >
        </div>
          </div>
       <div class="col-md-12">
          <table class="table table-striped bg-light table-sm m-2 p-4">
            <thead>
              <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Title</td>
                <td>Action</td>
              </tr>
            </thead>
            <tbody v-if="items.length > 0">
              <tr v-for="item in items" :key="item.id">
                <td>{{item.id}}</td>
                <td>{{item.name}}</td>
                <td>{{item.title}}</td>
                <td>
                  <router-link v-if="item.name != 'superadmin'" :to="{ name: 'auth.roles.edit', params: { id: item.id } }" class="btn bg-gradient-primary btn-xs">
                    Edit
                  </router-link>
                  <a href="javascript:;" v-if="item.name != 'superadmin'"  @click="deleteuser(item.id)" class="btn bg-gradient-danger btn-xs">
                    Delete
                  </a>
                </td>
              </tr>
            </tbody>
            <tbody v-else>
              <h4>No Data Found</h4>
            </tbody>
          </table>
       </div>
    </div>
</div>
  </div>
</template>
<script>
import Swal from "sweetalert2";
import rolesservice from "@services/auth/roles";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
export default {
  name: "auth.roles.listing",
  components:{
    breadcumbs
  },
  data() {
    return {
      search: "",
      items: [],
      loading: true,
      totalRecords: 0,
      options: {
        itemsPerPage:10,
        page:1,
        sortDesc:true,
        sortBy:'desc'
      },
     
    };
  },
  watch: {
    $route() {
      this.getDataFromApi();
    },
    perpage() {
      this.getDataFromApi();
    },
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
  },
  mounted() {
    this.getDataFromApi();
  },
  methods: {
    deleteuser: async function (id) {
      const isConfirmed = await Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          return true;
        }
      });
      if (isConfirmed) {
        await rolesservice.delete({
          id: id,
        });
        Swal.fire("Deleted!", "Your record has been deleted.", "success");
        this.getDataFromApi();
      }
    },
    async getDataFromApi() {
      var data = await this.fakeApiCall();
      this.items = data.data;
      try {
        this.totalRecords = data.meta.total;
      } catch (ex) {
        //this.totalRecords=0
      }
      this.loading = false;
    },
    fakeApiCall() {
      this.loading = true;
      // this.items = []
      var query = "";
      var page = this.options.page;
      query += "?page=" + page;
   
      // if (this.options.sortDesc) {
      //   //if 1 then by desc else asc
      //   query += "&sortByDesc=" + (this.options.sortDesc == true ? 1 : 0);
      // }
      query += "&perpage=" + this.options.itemsPerPage;
      if (this.search != "") {
        query += "&search=" + this.search;
      }
      return rolesservice.getlist(query);
    },
  },
  watch: {
    options: {
      handler() {
        this.getDataFromApi();
      },
      deep: true,
    },
    search() {
      this.getDataFromApi();
    },
  },
};
</script>
