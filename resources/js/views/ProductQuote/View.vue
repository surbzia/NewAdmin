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
    :value="form.email"
    label="Email"
    readonly
  ></v-text-field>
</v-col>

<v-col
  cols="6"
  sm="6"
  class="pb-0"
>
  <v-text-field
    :value="form.qty"
    label="Quantity"
    readonly
  ></v-text-field>
</v-col>
<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
<v-textarea
    outlined
    label="Message"
    :value="form.message"
></v-textarea>
</v-col>

<v-col
  cols="12"
  sm="12"
  class="pb-0"
>
Product: <a target="_blank" :href="MIX_FRONT_WEBSITE_URL+'/product/'+form.product.slug">{{form.product.sku}}</a>
</v-col>

</v-row>

</v-form>
</v-col>
</v-row>
  </div>
</template>

<script>
import productquoteservice from "@services/auth/productquote";
import productservice from "@services/auth/product";
export default {
  name: "auth.product_quotes.add",
  watch:{
    
  },
  methods: {
    
  },
  computed: {
    user() {
        return this.$store.getters.loggedInUser;
    },
  },
  data() {
    return {
      MIX_FRONT_WEBSITE_URL: process.env.MIX_FRONT_WEBSITE_URL,
      form:{
          id: (this.$route.params.id?this.$route.params.id:0),
          email: '',
          qty: 0,
          message: '',
          product_id: 0,
      },
      bread: [
        {
          text: "Dashboard",
          to: { name: "auth.dashboard" },
          disabled: false,
          exact: true,
        },
        {
          text: "Product Quote",
          to: { name: "auth.product_quotes.listing" },
          disabled: false,
          exact: true,
        },
        {
          text: "View",
          to: { name: "auth.product_quotes.edit", params: {id: this.$route.params.id} },
          disabled: true,
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
  async mounted(){
    if(this.$route.params.id){
        var res = await productquoteservice.get(this.form.id)
        this.form = {
            email: res.email,
            qty: res.qty,
            message: res.message,
            product_id: res.product_id,
            id: this.$route.params.id,
            product: res.product,
        }
        let formData = new FormData()
        formData.append('is_new',0)
        productquoteservice.update(formData, this.$route.params.id)
    }
  },
};
</script>
