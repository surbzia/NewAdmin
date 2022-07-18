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
        small
        color="secondary"
        @click="isHidden ? (isHidden = false) : (isHidden = true)"
      >
        <v-icon>mdi-filter</v-icon>Filter
      </v-btn>
    </v-row>
    <v-container v-if="isHidden">
      <v-card style="padding: 29px 27px">
        <v-row class="inline d-flex">
          <v-select
            :items="statuses"
            label="Status"
            item-text="name"
            v-model="filter.status"
            item-value="id"
            dense
            class="mx-4 pt-5"
          ></v-select>
          <v-btn
            elevation="1"
            color="primary"
            class="mt-5"
            v-on:click="applyFilter()"
            raised
            >Apply Filter</v-btn
          >
          <v-btn depressed class="mt-5" v-on:click="resetFilter()" raised
            >Reset</v-btn
          >
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
      <template v-slot:item.billing_first_name="{ item }">
        {{ item.billing_first_name }} {{ item.billing_last_name }}
      </template>
       <template v-slot:item.shipping_first_name="{ item }">
        {{ item.shipping_first_name }} {{ item.shipping_last_name }}
      </template>
      <template v-slot:item.total="{ item }"> $ {{ item.total }} </template>

      <template v-slot:item.order_status="{ item }">
        <OrderStatus :order_status="item.order_status" />
      </template>
      <template v-slot:item.actions="{ item }">
        <v-btn v-if="permissions.indexOf(160) >= 0" color="info" fab x-small dark :to="{ name: 'auth.orders.view', params: { id: item.id } }">
          <v-icon>mdi-eye-outline</v-icon>
        </v-btn>
      </template>
    </v-data-table>
  </div>
</template>
<script>
import Swal from "sweetalert2";
import defaultservice from "@services/auth/default";
import OrderStatus from "@/components/orders/status.vue";
const service = new defaultservice("orders");
export default {
  name: "auth.orders.listing",
  components: {
    OrderStatus,
  },
  computed: {
    permissions() {
      return this.$store.getters.getPermissions;
    },
  },
  data() {
    return {
      search: "",
      isHidden: false,
      filter: {
        status: "",
      },
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Orders",
          to: { name: "auth.orders.listing" },
          disabled: false,
          exact: true,
        },
      ],
      items: [],
      loading: true,
      statuses: [
        { id: 1, name: "Pending" },
        { id: 2, name: "Processing" },
        { id: 3, name: "Holded" },
        { id: 4, name: "Canceled" },
        { id: 5, name: "Completed/Delivered" },
      ],
      totalRecords: 0,
      options: {},
      headers: [
        {
          text: "ID",
          align: "start",
          sortable: true,
          value: "id",
        },
        {
          text: "Billing Email",
          align: "start",
          sortable: true,
          value: "billing_email",
        },
        {
          text: "Date",
          align: "start",
          sortable: true,
          value: "created_date_formatted_us",
        },
        {
          text: "Bill To",
          align: "start",
          sortable: true,
          value: "billing_first_name",
        },
        {
          text: "Ship To",
          align: "start",
          sortable: true,
          value: "shipping_first_name",
        },
        {
          text: "Total",
          align: "start",
          sortable: true,
          value: "total",
        },
        {
          text: "Status",
          align: "start",
          sortable: true,
          value: "order_status",
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
  },
  methods: {
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
      if (this.filter.status != "") {
        query += "&status=" + this.filter.status;
      }
      return service.getlist(query);
    },
    applyFilter() {
      this.getDataFromApi();
    },
    resetFilter() {
      (this.isHidden = false), (this.filter.status = ""), this.getDataFromApi();
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
