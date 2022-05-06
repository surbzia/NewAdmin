<template>
  <div>
    <v-row no-gutters>
      <v-breadcrumbs :items="bread">
        <template v-slot:divider>
          <v-icon>mdi-forward</v-icon>
        </template>
      </v-breadcrumbs>
    </v-row>
    <v-row class="justify-end">
      <v-btn
        small color="secondary"
        @click="isHidden ? (isHidden = false) : (isHidden = true)"
        >  <v-icon>mdi-filter</v-icon>Filter </v-btn>
    </v-row>

    <v-container v-if="isHidden">
        <v-card style="padding: 29px 27px;">
      <v-row class="inline d-flex">
        <v-text-field
          v-model="filter.name_sku"
          label="Product Name/ SKU"
          class="mx-4"
        ></v-text-field>
      </v-row>
      <v-row class="inline d-flex">
        <v-select
          :items="categories"
          label="Categories"
          item-text="name"
          item-value="id"
          v-model="filter.category"
          dense
          class="mx-4 pt-5"
        ></v-select>
        <v-select
          :items="brands"
          label="Brands"
          v-model="filter.brand"
          item-text="name"
          item-value="id"
          dense
          class="mx-4 pt-5"
        ></v-select>
         <v-select
          :items="['Standard','Variant']"
          label="Product Type"
          item-text="name"
          item-value="id"
          v-model="filter.product_type"
          dense
          class="mx-4 pt-5"
        ></v-select>
        <v-btn elevation="1" color="primary" class="mt-5" raised v-on:click="applyFilter()"
          >Apply Filter</v-btn
        >
        <v-btn depressed  class="mt-5" raised v-on:click="resetFilter()">Reset</v-btn>
      </v-row>
        </v-card>
    </v-container>

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
      <template v-slot:item.has_variant="{ item }">
        <v-chip draggable>
     {{item.has_variant == 0 ? 'Standard' : 'Variant'}}
        </v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn
          color="info"
          fab
          x-small
          dark
          :to="{ name: 'auth.products.edit', params: { id: item.id } }"
        >
          <v-icon>mdi-pencil-plus</v-icon>
        </v-btn>
        <v-btn color="success" v-if="item.has_variant" fab x-small dark @click="editVariants(item)">
          <v-icon>mdi-delete-outline</v-icon>
        </v-btn>
        <v-btn color="error" fab x-small dark @click="deleteuser(item.id)">
          <v-icon>mdi-delete-outline</v-icon>
        </v-btn>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import Swal from "sweetalert2";
import productservice from "@services/auth/product";
import categoryservice from "@services/auth/category";
import brandservice from "@services/auth/brand";
export default {
  name: "auth.products.listing",
  data() {
    return {
      filter: {
        name_sku: "",
        product_type: "",
        category: "",
        brand: "",
      },
      isHidden: false,
      search: "",
      conditions: [],
      categories: [],
      brands: [],
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Product",
          to: { name: "auth.products.listing" },
          disabled: false,
          exact: true,
        },
      ],
      items: [],
      loading: true,
      totalRecords: 0,
      options: {},
      headers: [
        {
          text: "#",
          align: "start",
          sortable: true,
          value: "id",
        },

        {
          text: "SKU",
          align: "start",
          sortable: true,
          value: "sku",
        },

        {
          text: "Name",
          align: "start",
          sortable: true,
          value: "name",
        },
        {
          text: "Product Type",
          align: "start",
          sortable: true,
          value: "has_variant",
        },
        { text: "Actions", value: "actions", sortable: false },
      ],
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

    brandservice.getlist("?sortCol=name&sortByDesc=0").then((e) => {
      this.brands = e.data;
    });
    categoryservice.getlist("?sortCol=name&sortByDesc=0").then((e) => {
      this.categories = e.data;
    });
  },
  methods: {
         editVariants(item) {
        if(item.variant && item.variant.length > 0){
                this.$router.push({ name: "auth.products.variations.edit" , params: { id:item.id,has_variant:true }});
        }else{
                this.$router.push({ name: "auth.products.variations.add" , params: { id:item.id,has_variant:true }});
        }
        },
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
        await productservice.delete({
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
      if (this.options.sortBy.length > 0) {
        query += "&sortCol=" + this.options.sortBy[0];
      }
      if (this.options.sortDesc.length > 0) {
        //if 1 then by desc else asc
        query += "&sortByDesc=" + (this.options.sortDesc[0] == true ? 1 : 0);
      }
      query += "&perpage=" + this.options.itemsPerPage;
      if (this.search != "") {
        query += "&search=" + this.search;
      }
      if (this.filter.name_sku != "") {
        query += "&name_sku=" + this.filter.name_sku;
      }


        if (this.filter.brand != "") {
        query += "&brand=" + this.filter.brand;
      }
        if (this.filter.category != "") {
        query += "&category=" + this.filter.category;
      }
        if (this.filter.product_type != "") {
        query += "&product_type=" + this.filter.product_type;
      }
      return productservice.getlist(query);
    },
    applyFilter() {
        this.getDataFromApi();
    },
     resetFilter() {
        this.filter.name_sku = "",
        this.filter.part_num= "",
        this.filter.condition= "",
        this.filter.category= "",
        this.filter.brand= "",
        this.filter.product_type= "",
        this.isHidden = false,
        this.getDataFromApi();
     }
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
