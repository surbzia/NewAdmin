<template>
  <div>
    <v-breadcrumbs :items="bread">
      <template v-slot:divider>
        <v-icon>mdi-forward</v-icon>
      </template></v-breadcrumbs
    >
</v-breadcrumbs>
<v-row no-gutters  class="grey lighten-5 pa-10 rounded elevation-10">
<v-col
cols="12"
sm="12"
>
<v-form
ref="form"
v-model="loading"
lazy-validation
>

<v-row>
    <v-col
  cols="6"
  sm="6"
  class="pb-0"
>
  <v-text-field
    v-model="form.name"
    :rules="[rules.required]"
    :error-messages="errors.name"
    label="Name"
  ></v-text-field>
</v-col>
<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
  <v-text-field
    v-model="form.code"
    :rules="[rules.required]"
    :error-messages="errors.code"
    label="Code"
  ></v-text-field>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-select
    v-model="form.discount_type"
    :items="[{id: 0,name: 'Percentage'},{id: 1,name: 'Amount'}]"
    label="Discount Type"
    item-text="name"
    item-value="id"
></v-select>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
  <v-text-field
    v-model="form.discount"
    type="number"
    :rules="[rules.required]"
    :error-messages="errors.discount"
    label="Discount"
  ></v-text-field>
</v-col>

<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
  <v-text-field
    v-model="form.minimum_cart_value"
    type="number"
    :error-messages="errors.minimum_cart_value"
    label="Minimum Cart Value"
  ></v-text-field>
</v-col>
<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
  <v-text-field
    v-model="form.maximum_cart_value"
    type="number"
    :error-messages="errors.maximum_cart_value"
    label="Maximum Cart Value"
  ></v-text-field>
</v-col>

 <v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-btn
    color="secondary"
    elevation="1"
    large
    raised
    @click="addpermission"
    :loading="btnloading"
    :disabled="btnloading"
  >{{form.id>0?'Update':'Add'}}</v-btn>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row>
  </div>
</template>

<script>
import couponservice from "@services/auth/coupon";
export default {
  name: "auth.coupons.add",
  async mounted() {
    if (this.$route.params.id) {
      var res = await couponservice.get(this.form.id);
      this.form = {
        code: res.code,
        discount: res.discount,
        discount_type: res.discount_type,
        minimum_cart_value: res.minimum_cart_value,
        maximum_cart_value: res.maximum_cart_value,
        id: this.$route.params.id,
      };
      this.bread.push({
        text: "Edit",
        to: {
          name: "auth.coupons.edit",
          params: { id: this.$route.params.id },
        },
        disabled: false,
        exact: true,
      });
    } else {
      this.bread.push({
        text: "Add",
        to: { name: "auth.coupons.add" },
        disabled: false,
        exact: true,
      });
    }
  },
  methods: {
    resetError() {
      this.errors = {
        code: [],
        discount: [],
        discount_type: [],
        minimum_cart_value: [],
        maximum_cart_value: [],
      };
    },
    addpermission: async function () {
      this.resetError();
      if (this.$refs.form.validate()) {
        this.btnloading = true;
        var formdata = new FormData();
        formdata.append("name", this.form.name);
        formdata.append("code", this.form.code);
        formdata.append("discount", this.form.discount);
        formdata.append("discount_type", this.form.discount_type);
        formdata.append("minimum_cart_value", this.form.minimum_cart_value);
        formdata.append("maximum_cart_value", this.form.maximum_cart_value);
        this.btnloading = false;
        if (this.form.id > 0) {
          var res = await couponservice.update(formdata, this.form.id);
        } else {
          var res = await couponservice.create(formdata);
        }
        if (!res.status) {
          if (res.data.code) {
            this.errors.code = res.data.code;
          }
          if (res.data.discount_type) {
            this.errors.discount_type = res.data.discount_type;
          }
          if (res.data.discount) {
            this.errors.discount = res.data.discount;
          }
          if (res.data.minimum_cart_value) {
            this.errors.minimum_cart_value = res.data.minimum_cart_value;
          }
          if (res.data.maximum_cart_value) {
            this.errors.maximum_cart_value = res.data.maximum_cart_value;
          }
          //errors here
        } else {
          //suuccess here
          this.$router.push({ name: "auth.coupons.listing" });
        }
      }
    },
  },
  computed: {
    user() {
      return this.$store.getters.loggedInUser;
    },
  },
  watch: {},
  data() {
    return {
      form: {
        id: this.$route.params.id ? this.$route.params.id : 0,
        name: "",
        code: "",
        discount_type: 0,
        discount: 0,
        minimum_cart_value: 0,
        maximum_cart_value: 0,
      },
      errors: {
        name: [],
        code: [],
        discount_type: [],
        discount: [],
        minimum_cart_value: [],
        maximum_cart_value: [],
      },
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Coupons",
          to: { name: "auth.coupons.listing" },
          disabled: false,
          exact: true,
        },
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
