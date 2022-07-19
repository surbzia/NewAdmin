<template>
  <div>
    <breadcumbs :data="{ step1: 'Users', step2: '' }"></breadcumbs>
    <!-- <Loader></Loader> -->
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
            :to="{ name: 'auth.users.add' }"
            class="btn btn-success"
            >Add</router-link
          >
        </div>
          </div>

        <div class="col-md-12">
          <table class="table table-striped bg-light table-sm m-2 p-4">
            <thead>
              <tr>
                <td>ID</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Email</td>
                <td>Role</td>
                <td>Action</td>
              </tr>
            </thead>
            <tbody v-if="items.length > 0">
              <tr v-for="item in items" :key="item.id">
                <td>{{ item.id }}</td>
                <td>{{ item.first_name }}</td>
                <td>{{ item.last_name }}</td>
                <td>{{ item.email }}</td>
                <td>{{ item.role_name }}</td>
                <td>
                  <router-link
                    :to="{ name: 'auth.users.edit', params: { id: item.id } }"
                    class="btn btn-outline-secondary"
                  >
                    Edit
                  </router-link>
                  <a
                    href="javascript:;"
                    @click="deleteuser(item.id)"
                    class="btn btn-outline-danger"
                  >
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
    <!-- <v-row no-gutters>
      <v-breadcrumbs :items="bread">
        <template v-slot:divider>
          <v-icon>mdi-forward</v-icon>
        </template>
      </v-breadcrumbs>
    </v-row>
    <v-data-table
      :headers="headers"
      :items="items"
      :options.sync="options"
      :server-items-length="totalRecords"
      :loading="loading"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-text-field
          v-model="search"
          label="Search"
          class="mx-4"
        ></v-text-field>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn
          color="info"
          fab
          x-small
          dark
          :to="{ name: 'auth.users.edit', params: { id: item.id } }"
        >
          <v-icon>mdi-pencil-plus</v-icon>
        </v-btn>
        <v-btn color="error" fab x-small dark @click="deleteuser(item.id)">
          <v-icon>mdi-delete-outline</v-icon>
        </v-btn>
        <v-btn
          color="warning"
          fab
          x-small
          dark
          :to="{ name: 'auth.users.exemption.listing', params: { uid: item.id } }"
        >
          <v-icon>mdi-file-certificate-outline</v-icon>
        </v-btn>
      </template>
    </v-data-table> -->
  </div>
</template>
<script>
import Swal from "sweetalert2";
import userservice from "@services/auth/user";
import breadcumbs from "@/components/sidebars/breadcumbs.vue";
import Loader from "@/components/Loader.vue";
export default {
  components: {
    breadcumbs,
    Loader
  },
  name: "auth.users.listing",
  data() {
    return {
      search: "",
      items: [],
      loading: true,
      totalRecords: 0,
      options: {
        itemsPerPage: 10,
        page: 1,
        sortDesc: true,
        sortBy: "desc",
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
        await userservice.delete({
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
      // if (this.options.sortBy.length > 0) {
      //   query += "&sortCol=" + this.options.sortBy[0];
      // }
      // if (this.options.sortDesc.length > 0) {
      //   //if 1 then by desc else asc
      //   query += "&sortByDesc=" + (this.options.sortDesc[0] == true ? 1 : 0);
      // }
      query += "&perpage=" + this.options.itemsPerPage;
      if (this.search != "") {
        query += "&search=" + this.search;
      }
      return userservice.getlist(query);
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
