<template>
    <div>
        <v-breadcrumbs :items="bread">
            <template v-slot:divider>
                <v-icon>mdi-forward</v-icon>
            </template></v-breadcrumbs
        >
        <v-row no-gutters class="grey lighten-5 pa-10 rounded elevation-10">
            <v-col cols="12" sm="12">
                 <v-form ref="form" lazy-validation>
                    <v-row>
                        <v-col cols="2" sm="2" class="pb-0">
                            <v-text-field
                                v-model="form.sku"
                                :rules="[rules.required]"
                                :error-messages="errors.sku"
                                label="SKU"
                                :hint="form.id == 0 ? 'CRIS-' + form.sku : ''"
                                persistent-hint
                            ></v-text-field>
                        </v-col>
                        <v-col cols="5" sm="5" class="pb-0">
                            <v-text-field
                                v-model="form.name"
                                :rules="[rules.required]"
                                :error-messages="errors.name"
                                label="Name"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="5" sm="5" class="pb-0">
                            <v-text-field
                                v-model="form.slug"
                                :rules="[rules.required]"
                                :error-messages="errors.slug"
                                label="Slug"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="4" sm="4" class="pb-0">
                            <v-text-field
                                v-model.number="form.price"
                                :rules="[rules.required]"
                                :error-messages="errors.price"
                                label="Price"
                                type="number"
                                min="0"
                                step="any"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="4" sm="4" class="pb-0">
                            <v-text-field
                                v-model.number="form.sale_price"
                                :error-messages="errors.sale_price"
                                label="Sale Price"
                                type="number"
                                min="0"
                                step="any"
                            ></v-text-field>
                        </v-col>
                         <v-col cols="4" sm="4" class="pb-0">
                            <v-select
                                v-model="form.has_variant"
                                :rules="[rules.required]"
                                :error-messages="errors.has_variant"
                                :items="['Standard','Variant']"
                                label="Product type"
                            ></v-select>
                        </v-col>

                        <v-col cols="12" sm="12" class="pb-0">
                            <v-text-field
                                v-model="form.short_description"
                                :error-messages="errors.short_description"
                                label="Short Description"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" sm="12" class="pb-0">
                            <label>Description</label>
                            <v-alert
                                dense
                                outlined
                                type="error"
                                v-if="errors.description.length > 0"
                            >
                                {{ errors.description.join(", ") }}
                            </v-alert>
                            <ckeditor
                                :editor="editor"
                                v-model="form.description"
                                :config="editorConfig"
                            ></ckeditor>
                        </v-col>

                        <v-col cols="12" cm="12" class="pb-0">
                            <v-file-input
                                accept="image/*"
                                v-model="form.image"
                                :error-messages="errors.image"
                                label="Image"
                            ></v-file-input>
                        </v-col>
                        <v-col
                            v-if="form.id > 0 && form.image_url"
                            cols="12"
                            cm="12"
                            class="pb-0"
                        >
                            <v-img
                                :lazy-src="form.image_url"
                                max-height="150"
                                max-width="250"
                                :src="form.image_url"
                            ></v-img>
                        </v-col>
                        <v-col cols="4" sm="4" class="pb-0">
                            <v-checkbox
                                v-model="form.is_featured"
                                label="Is Featured?"
                            ></v-checkbox>
                        </v-col>
                        <v-col cols="4" sm="4" class="pb-0">
                            <v-checkbox
                                v-model="form.is_active"
                                label="Is Active?"
                            ></v-checkbox>
                        </v-col>
                                              <v-col cols="12" sm="12" class="pb-0">
                            <v-select
                                v-model="form.related_products"
                                :items="related_products"
                                label="Related Products"
                                item-text="name"
                                item-value="id"
                                return-object
                                multiple
                                chips
                                hint="Select All Products which you want to show in Related Products Grid on Product Detail Page"
                                persistent-hint
                            ></v-select>
                        </v-col>
                        <v-col cols="12" sm="12" class="pb-0">
                            <h3 class="mt-3">Stock Management</h3>
                        </v-col>
                        <v-col cols="3" sm="3" class="pb-0">
                            <v-checkbox
                                v-model="form.in_stock"
                                :error-messages="errors.in_stock"
                                label="In Stock?"
                            ></v-checkbox>
                        </v-col>

                        <v-col
                            cols="3"
                            sm="3"
                            class="pb-0"
                            v-if="form.in_stock"
                        >
                            <v-checkbox
                                v-model="form.manage_stock"
                                :error-messages="errors.manage_stock"
                                label="Manage Stock?"
                            ></v-checkbox>
                        </v-col>

                        <v-col
                            v-if="form.manage_stock && form.in_stock"
                            cols="3"
                            sm="3"
                            class="pb-0"
                        >
                            <v-text-field
                                v-model="form.stock_qty"
                                :error-messages="errors.stock_qty"
                                label="Stock Quantity"
                                type="number"
                                min="0"
                            ></v-text-field>
                        </v-col>

                        <v-col cols="12" sm="12" class="pb-0">
                            <v-divider></v-divider>
                        </v-col>
                        <v-col cols="12" sm="12" class="pb-0">
                            <v-select
                                v-model="form.brand_id"
                                :items="brands"
                                label="Brand"
                                item-text="name"
                                item-value="id"
                                :error-messages="errors.brand_id"
                            ></v-select>
                        </v-col>

                        <v-col cols="12" sm="12" class="pb-0">
                            <label>Primary Category</label>
                            <v-alert
                                dense
                                outlined
                                type="error"
                                v-if="errors.category_id.length > 0"
                            >
                                {{ errors.category_id.join(", ") }}
                            </v-alert>
                            <v-treeview
                                @update:active="getCurrentSelectionParent"
                                activatable
                                dense
                                :items="categories"
                                :active="default_category"
                                :open="default_category"
                            ></v-treeview>
                        </v-col>

                        <v-col cols="12" sm="12" class="pb-0">
                            <v-btn
                                color="secondary"
                                elevation="1"
                                large
                                raised
                                @click="addpermission"
                                :loading="btnloading"
                                :disabled="btnloading"
                                >{{ form.id > 0 ? "Update" : "Add" }}</v-btn
                            >
                                <v-btn v-if="form.id > 0 && form.has_variant == 'Variant'"
                                color="primary"
                                style="float: right;"
                                elevation="1"
                                large
                                raised
                                @click="editVariants"
                                :loading="btnloading"
                                :disabled="btnloading"
                                >Update Variants
                                <v-icon>mdi-arrow-right</v-icon>
                                </v-btn
                            >
                        </v-col>
                    </v-row>
                </v-form>
            </v-col>
        </v-row>
    </div>
</template>

<script>
import productservice from "@services/auth/product";
import categoryservice from "@services/auth/category";
import brandservice from "@services/auth/brand";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
export default {
    name: "auth.products.add",
    async mounted() {
        productservice.getlist("").then((e) => {
            this.related_products = e.data;
        });
        brandservice.getlist("?sortCol=name&sortByDesc=0").then((e) => {
            this.brands = e.data;
        });
        categoryservice.getlist("?sortCol=name&sortByDesc=0").then((e) => {
            this.categories.push(
                ...e.data.filter((e) => {
                    return e.parent_id == 0;
                })
            );
        });
        if (this.$route.params.id) {
            var res = await productservice.get(this.form.id);
            let related_to_select = res.related.map((e) => {
                return { name: e.reference.name, id: e.reference_product };
            });
            this.form = {
                name: res.name,
                slug: res.slug,
                price: res.price,
                sale_price: res.sale_price,
                has_variant: res.has_variant == 1 ? 'Variant' : 'Standard',
                variants: res.variant,
                description: res.description ? res.description : "",
                short_description: res.short_description
                    ? res.short_description
                    : "",
                image_url: res.image_url,
                category_id: res.category_id,
                brand_id: res.brand_id,
                stock_qty: res.stock_qty,
                in_stock: res.in_stock == 1 ? true : false,
                manage_stock: res.manage_stock == 1 ? true : false,
                is_featured: res.is_featured == 1 ? true : false,
                is_active: res.is_active == 1 ? true : false,
                id: this.$route.params.id,
                related_products: related_to_select,
                sku: res.sku,
            };
            this.default_category = [];
            this.default_category.push(res.category_id);
            this.bread.push({
                text: "Edit",
                to: {
                    name: "auth.products.edit",
                    params: { id: this.$route.params.id },
                },
                disabled: false,
                exact: true,
            });
            await this.$nextTick();
            this.form.slug = res.slug;
        } else {
            await productservice.getlist("?perpage=1").then((e) => {
                if (e.data.length > 0) {
                    this.form.sku = e.data[0].id + 1;
                } else {
                    this.form.sku = 1;
                }
            });
            this.bread.push({
                text: "Add",
                to: { name: "auth.products.add" },
                disabled: false,
                exact: true,
            });
        }
    },
    methods: {
        editVariants() {
                if(this.form.variants.length > 0){
                        this.$router.push({ name: "auth.products.variations.edit" , params: { id:this.form.id }});
                }else{
                        this.$router.push({ name: "auth.products.variations.add" , params: { id:this.form.id }});
                }
        },
        getCurrentSelectionParent(value) {
            this.form.category_id = value[0];
        },
        resetError() {
            this.errors = {
                name: [],
                slug: [],
                price: [],
                description: [],
                short_description: [],
                related_products: [],
                image: [],
                is_featured: [],
                is_active: [],
                category_id: [],
                brand_id: [],
                stock_qty: [],
                in_stock: [],
                manage_stock: [],
                sku: [],
            };
        },
        addpermission: async function () {
            this.resetError();
            if (this.$refs.form.validate()) {
                this.btnloading = true;
                var formdata = new FormData();
                formdata.append("name", this.form.name);
                formdata.append("slug", this.form.slug);
                formdata.append("description", this.form.description);
                formdata.append(
                    "short_description",
                    this.form.short_description
                );
                formdata.append("price", this.form.price);
                formdata.append("sale_price", this.form.sale_price);
                formdata.append("category_id", this.form.category_id);
                formdata.append("brand_id", this.form.brand_id);
                formdata.append("condition", this.form.condition);
                formdata.append(
                    "is_featured",
                    this.form.is_featured == true ? 1 : 0
                );
                formdata.append(
                    "is_active",
                    this.form.is_active == true ? 1 : 0
                );

                formdata.append("in_stock", this.form.in_stock == true ? 1 : 0);
                formdata.append(
                    "manage_stock",
                    this.form.manage_stock == true ? 1 : 0
                );
                if (
                    this.form.manage_stock == true &&
                    this.form.in_stock == true
                ) {
                    formdata.append("stock_qty", this.form.stock_qty);
                }
                let variation = this.form.has_variant == 'Variant'?1 :0;
                formdata.append("has_variant",variation);
                if (this.form.related_products.length > 0) {
                    for (
                        let i = 0;
                        i < this.form.related_products.length;
                        i++
                    ) {
                        formdata.append(
                            "related_products[" + i + "]",
                            this.form.related_products[i].id
                        );
                    }
                }
                if (this.form.image) {
                    formdata.append("image", this.form.image);
                }
                this.btnloading = false;
                if (this.form.id > 0) {
                    formdata.append("sku", this.form.sku);
                    var res = await productservice.update(
                        formdata,
                        this.form.id
                    );
                } else {
                    formdata.append("sku", "CRIS-" + this.form.sku);
                    var res = await productservice.create(formdata);
                }
                if (!res.status) {
                    console.log(res.data);
                    if (res.data.name) {
                        this.errors.name = res.data.name;
                    }
                    if (res.data.slug) {
                        this.errors.slug = res.data.slug;
                    }
                    if (res.data.description) {
                        this.errors.description = res.data.description;
                    }
                    if (res.data.short_description) {
                        this.errors.short_description =
                            res.data.short_description;
                    }
                    if (res.data.price) {
                        this.errors.price = res.data.price;
                    }
                    if (res.data.sale_price) {
                        this.errors.sale_price = res.data.sale_price;
                    }
                    if (res.data.image) {
                        this.errors.image = res.data.image;
                    }
                    if (res.data.related_products) {
                        this.errors.related_products =
                            res.data.related_products;
                    }
                    if (res.data.is_featured) {
                        this.errors.is_featured = res.data.is_featured;
                    }
                    if (res.data.is_active) {
                        this.errors.is_active = res.data.is_active;
                    }

                    if (res.data.category_id) {
                        this.errors.category_id = res.data.category_id;
                    }
                    if (res.data.brand_id) {
                        this.errors.brand_id = res.data.brand_id;
                    }
                    if (res.data.stock_qty) {
                        this.errors.stock_qty = res.data.stock_qty;
                    }

                    if (res.data.in_stock) {
                        this.errors.in_stock = res.data.in_stock;
                    }
                    if (res.data.manage_stock) {
                        this.errors.manage_stock = res.data.manage_stock;
                    }

                    if (res.data.condition) {
                        this.errors.condition = res.data.condition;
                    }
                    if (res.data.sku) {
                        this.errors.sku = res.data.sku;
                    }

                    //errors here
                } else {
                      //suuccess here
                    if(res.status == 1 && this.form.id == '' && res.data.has_variant == 1){
                        this.$router.push({ name: "auth.products.variations.add" , params: { id: res.data.id }});
                    }else{
                        this.$router.push({ name: "auth.products.listing" });
                    }

                }
            }
        },
    },
    computed: {
        user() {
            return this.$store.getters.loggedInUser;
        },
    },
    watch: {
        "form.name": function () {
            let _val = this.form.name;
            _val = _val.replace(/([^a-zA-Z0-9\-_\s]+)/gi, "");
            _val = _val.replace(/\s+/g, "-");
            this.form.slug = _val.toLowerCase();
        },
    },
    data() {
        return {
            related_products: [],
            categories: [],
            brands: [],
            editor: ClassicEditor,
            editorConfig: {},
            default_category: [],
            form: {
                id: this.$route.params.id ? this.$route.params.id : 0,
                name: "",
                slug: "",
                price: "0",
                sale_price: "0",
                description: "",
                short_description: "",
                image: undefined,
                related_products: [],
                is_featured: false,
                is_active: true,
                category_id: undefined,
                brand_id: 0,
                stock_qty: 0,
                in_stock: true,
                manage_stock: false,
                has_variant: '',
                variants:'',
                sku: "",
            },
            errors: {
                name: [],
                slug: [],
                price: [],
                sale_price: [],
                description: [],
                short_description: [],
                image: [],
                related_products: [],
                is_featured: [],
                is_active: [],
                category_id: [],
                brand_id: [],
                stock_qty: [],
                in_stock: [],
                manage_stock: [],
                sku: [],
            },
            bread: [
                {
                    text: "Dashboard",
                    to: { name: "auth.dashboard" },
                    disabled: false,
                    exact: true,
                },
                {
                    text: "Products",
                    to: { name: "auth.products.listing" },
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
