<template>
    <div>
        <v-breadcrumbs :items="bread">
            <template v-slot:divider>
                <v-icon>mdi-forward</v-icon>
            </template>
        </v-breadcrumbs>

        <v-row no-gutters class="lighten-5 pa-10 rounded elevation-1">
            <v-col cols="12" sm="12">
                <v-row>
                    <v-col
                        cols="12"
                        sm="12"
                        class="pb-0"
                        style="text-align: right"
                    >
                        <v-btn
                            type="Submit"
                            v-on:click="Submit"
                            color="primary"
                            :loading="btnloading"
                            :disabled="btnloading"
                        >
                            {{ is_edit == true ? "Update" : "Submit" }}
                        </v-btn>
                    </v-col>
                </v-row>
                <v-row>
                    <v-col cols="4" sm="4" class="pb-0">
                        <v-text-field
                            v-model="attribute_1"
                            ref="attribute_1"
                            label="Attribute 1"
                            type="text"
                            outlined
                            :disabled="validate1 ? '' : disabled"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4" sm="4" class="pb-0">
                        <v-text-field
                            v-model="attribute_2"
                            ref="attribute_2"
                            label="Attribute 2"
                            type="text"
                            outlined
                            :disabled="validate2 ? '' : disabled"
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4" sm="4" class="pb-0">
                        <v-text-field
                            v-model="attribute_3"
                            ref="attribute_3"
                            label="Attribute 3"
                            type="text"
                            outlined
                            :disabled="validate3 ? '' : disabled"
                        ></v-text-field>
                    </v-col>
                </v-row>
                <v-row style="margin-bottom: -37px">
                    <v-col cols="4" sm="4" class="pb-0">
                        <v-text-field
                            v-model="attr1_value"
                            label="Write attribute 1 value and press enter."
                            type="text"
                            outlined
                            v-on:keyup.enter="getValue(1)"
                            hint="Write attribute 1 value and press enter."
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4" sm="4" class="pb-0">
                        <v-text-field
                            v-model="attr2_value"
                            label="Write attribute 2 value and press enter."
                            type="text"
                            outlined
                            v-on:keyup.enter="getValue(2)"
                            hint="Write attribute 2 value and press enter."
                        ></v-text-field>
                    </v-col>
                    <v-col cols="4" sm="4" class="pb-0">
                        <v-text-field
                            v-model="attr3_value"
                            label="Write attribute 3 value and press enter."
                            type="text"
                            outlined
                            v-on:keyup.enter="getValue(3)"
                            hint="Write attribute 3 value and press enter."
                        ></v-text-field>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
        <v-form ref="form" v-model="valid" lazy-validation>
            <v-row
                v-if="data.variants.length > 0"
                no-gutters
                class="lighten-5 pa-10 rounded elevation-1"
            >
                <v-col cols="12" sm="12" class="mt-5">
                    <v-simple-table>
                        <template>
                            <thead>
                                <tr>
                                    <th
                                        width="10%"
                                        class="text-left"
                                        v-if="is_edit"
                                    >
                                        Image
                                    </th>
                                    <th width="20%" class="text-left">
                                        Variation
                                    </th>
                                    <th class="text-center" width="10%">SKU</th>
                                    <th class="text-center" width="10%">
                                        Stock
                                    </th>
                                    <th class="text-center" width="10%">
                                        Sale Price
                                    </th>
                                    <th class="text-center" width="10%">
                                        File Input
                                    </th>
                                    <th class="text-center" width="10%">
                                        Status
                                    </th>
                                    <th class="text-center" width="10%">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(variant, index) in filteredVariants"
                                    :key="index"
                                >
                                    <td v-if="is_edit">
                                        <v-img
                                            :lazy-src="variant.image_url"
                                            max-height="60"
                                            max-width="60"
                                            :src="variant.image_url"
                                        ></v-img>
                                    </td>
                                    <td>
                                        <span
                                            style="color: blue"
                                            class="font-weight-medium"
                                            >{{
                                                variant.attribute_1_value
                                            }}</span
                                        >
                                        <span
                                            style="color: #cd050f"
                                            class="font-weight-medium"
                                            >{{
                                                variant.attribute_2_value
                                            }}</span
                                        >
                                        <span
                                            style="color: #503504"
                                            class="font-weight-medium"
                                            >{{
                                                variant.attribute_3_value
                                            }}</span
                                        >
                                    </td>
                                    <td>
                                        <v-text-field
                                            style="
                                                margin-top: 12px;
                                                margin-bottom: -14px;
                                            "
                                            v-model="variant.sku"
                                            outlined
                                            dense
                                            :rules="[rules.required]"
                                            type="text"
                                        ></v-text-field>
                                    </td>
                                    <td>
                                        <v-text-field
                                            style="
                                                margin-top: 12px;
                                                margin-bottom: -14px;
                                            "
                                            v-model="variant.stock"
                                            outlined
                                            dense
                                            type="number"
                                        ></v-text-field>
                                    </td>
                                    <td>
                                        <v-text-field
                                            style="
                                                margin-top: 12px;
                                                margin-bottom: -14px;
                                            "
                                            v-model="variant.sale_price"
                                            outlined
                                            dense
                                            type="number"
                                        ></v-text-field>
                                    </td>
                                    <td>
                                        <v-file-input
                                            v-model="variant.image"
                                            accept="image/*"
                                            label="File input"
                                        ></v-file-input>
                                    </td>
                                    <td class="text-center">
                                        <v-switch
                                            v-model="variant.is_active"
                                        ></v-switch>
                                    </td>
                                    <td class="text-center">
                                        <v-icon v-on:click="remveVariant(index)"
                                            >mdi-trash-can</v-icon
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
            </v-row>
        </v-form>
    </div>
</template>

<script>
import VariantService from "@services/auth/variant";
export default {
    name: "auth.products.variations.add",
    async mounted() {
         if(this.$route.params.has_variant != true){
             this.$router.push({name: "auth.products.listing"});
         }
        if (this.$route.name == "auth.products.variations.edit") {
            this.is_edit = true;
            var res = await VariantService.get(this.$route.params.id);
            if(!res.has_variant){
                this.$router.push({name: "auth.products.listing"});
            }
            res.variants.forEach((variant) => {
                this.data.variants.push({
                    id: variant.id,
                    image: undefined,
                    image_url:
                        variant.image != null? variant.image.full_url: variant.not_found,
                    attribute_1: variant.attribute_1,
                    attribute_2: variant.attribute_2,
                    attribute_3: variant.attribute_3,
                    attribute_1_value: variant.attribute_1_value,
                    attribute_2_value: variant.attribute_2_value,
                    attribute_3_value: variant.attribute_3_value,
                    sku: variant.sku,
                    stock: variant.stock,
                    sale_price: variant.sale_price,
                    is_active: variant.is_active == 1 ? true : false,
                    is_removed: false,
                });
            });


            this.attribute_1 = res.attrb.attr1_array[0].key;
            this.attr1.values = res.attrb.attr1_array[0].values;
            this.attribute_2 = res.attrb.attr2_array[0].key;
            this.attr2.values = res.attrb.attr2_array[0].values;
            this.attribute_3 = res.attrb.attr3_array[0].key;
            this.attr3.values = res.attrb.attr3_array[0].values;
            res.attributes.forEach((attr) => {
                this.attribute.push(attr.attribute);
                this.getAttribute();
            });
            await VariantService.getlist("?perpage=1").then((e) => {
                this.sku = e.data[0].id;
            });
        } else {
            this.sku = 1;
        }
    },
    computed: {
        filteredVariants() {
            return this.data.variants.filter((e) => e.is_removed == false);
        },
    },
    data() {
        return {
            is_edit: false,
            valid: true,
            sku: "",
            validate1: false,
            validate2: false,
            validate3: false,
            loading: false,
            btnloading: false,
            attribute_1: "",
            attribute_2: "",
            attribute_3: "",
            attr1_value: "",
            attr2_value: "",
            attr3_value: "",
            attr1: {
                values: [],
            },
            attr2: {
                values: [],
            },
            attr3: {
                values: [],
            },
            data: {
                product_id: this.$route.params.id,
                attributes: [],
                variants: [],
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
                {
                    text: "Variation",
                    to: { name: "auth.products.variations.add" },
                    disabled: true,
                    exact: true,
                },
            ],
            rules: {
                required: (value) => !!value || "Required.",
            },
        };
    },
    methods: {
        //     remove (item) {
        //     this.chips.splice(this.chips.indexOf(item), 1)
        //     this.chips = [...this.chips]
        //   },
        Submit: async function () {
            this.setAttribues();
            this.btnloading = true;
            if (this.$refs.form.validate()) {
                var formdata = new FormData();
                formdata.append("data", JSON.stringify(this.data));
                let variants = this.data.variants;

                for (let i = 0; i < variants.length; i++) {
                    if (variants[i].image) {
                        formdata.append(
                            "image[" + i + "]",
                            variants[i].image,
                            variants[i].sku
                        );
                    }
                    continue;
                }
                this.btnloading = false;
                if (this.$route.name != "auth.products.variations.edit") {
                    var res = await VariantService.create(formdata);
                } else {
                    var res = await VariantService.update(
                        formdata,
                        this.$route.params.id
                    );
                }
                this.btnloading = false;
                if (res.status != 0) {
                    setTimeout(
                        () =>
                            this.$router.push({
                                name: "auth.products.listing",
                            }),
                        1000
                    );
                }
            }
        },
        validate(attribute_num) {
            if (attribute_num == 1) {
                if (this.attribute_1 == "") {
                    this.attr1_value = "";
                    this.$refs.attribute_1.focus();
                    return false;
                } else {
                    this.validate1 = true;
                    return true;
                }
            }
            if (attribute_num == 2) {
                if (this.attribute_2 == "") {
                    this.attr2_value = "";
                    this.$refs.attribute_2.focus();
                    return false;
                } else {
                    this.validate2 = true;
                    return true;
                }
            }
            if (attribute_num == 3) {
                if (this.attribute_3 == "") {
                    this.attr3_value = "";
                    this.$refs.attribute_3.focus();
                    return false;
                } else {
                    this.validate3 = true;
                    return true;
                }
            }
        },
        getValue(attribute_num) {
            if (this.validate(attribute_num)) {
                this.data.variants = [];
                this.filterAttributeOnEnter();
                let variant;
                for (let i = 0; i < this.attr1.values.length; i++) {
                    if (this.attr2.values.length == 0) {
                        variant = this.generateVariants(this.attr1.values[i]);
                        this.data.variants.push(variant);
                        continue;
                    }
                    for (let j = 0; j < this.attr2.values.length; j++) {
                        if (this.attr3.values.length == 0) {
                            variant = this.generateVariants(
                                this.attr1.values[i],
                                this.attr2.values[j]
                            );
                            this.data.variants.push(variant);
                            continue;
                        }
                        for (let k = 0; k < this.attr3.values.length; k++) {
                            variant = this.generateVariants(
                                this.attr1.values[i],
                                this.attr2.values[j],
                                this.attr3.values[k]
                            );
                            this.data.variants.push(variant);
                        }
                    }
                }
                this.attr1_value = "";
                this.attr2_value = "";
                this.attr3_value = "";
                this.filterVariants();
            }
        },
        generateVariants(attr_1_value, attr_2_value, attr_3_value) {
            let sku = this.sku + 1;
            this.sku = sku;
            return {
                id: null,
                image: undefined,
                image_url: undefined,
                attribute_1: this.attribute_1,
                attribute_2: this.attribute_2,
                attribute_3: this.attribute_3,
                attribute_1_value: attr_1_value == null ? " " : attr_1_value,
                attribute_2_value:
                    attr_2_value == null ? " " : "-" + attr_2_value,
                attribute_3_value:
                    attr_3_value == null ? " " : "-" + attr_3_value,
                sku: sku,
                stock: 0,
                sale_price: 0.0,
                is_active: true,
                is_removed: false,
            };
        },
        filterVariants() {
            let value1 = this.attr1_value;
            let value2 = this.attr2_value;
            let value3 = this.attr3_value;
            var filter1 = this.data.variants.filter((variant) => {
                let res1 =
                    variant.attribute_1_value.indexOf(value1) > -1 &&
                    value1 != "";
                let res3 =
                    variant.attribute_3_value.indexOf(value3) > -1 &&
                    value3 != "";
                let res2 =
                    variant.attribute_2_value.indexOf(value2) > -1 &&
                    value2 != "";
                return res1 == true && res2 == true && res3 == true
                    ? true
                    : false;
            });
            return filter1;
        },
        filter(array, key) {
            return array.includes(key);
        },
        setAttribues() {
            this.data.attributes.push({
                attribute: this.attribute_1,
                values: [],
            });
            this.data.attributes.push({
                attribute: this.attribute_2,
                values: [],
            });
            this.data.attributes.push({
                attribute: this.attribute_3,
                values: [],
            });
            this.data.attributes.forEach((attribute) => {
                if (attribute.attribute == this.attribute_1) {
                    this.attr1.values.forEach((attr1) => {
                        attribute.values.push(attr1);
                    });
                } else if (attribute.attribute == this.attribute_2) {
                    this.attr2.values.forEach((attr2) => {
                        attribute.values.push(attr2);
                    });
                } else if (attribute.attribute == this.attribute_3) {
                    this.attr3.values.forEach((attr3) => {
                        attribute.values.push(attr3);
                    });
                }
            });
        },
        filterAttributeOnEnter() {
            if (
                !this.filter(this.attr1.values, this.attr1_value) &&
                this.attr1_value != ""
            ) {
                this.attr1.values.push(
                    this.attr1_value == undefined ? "" : this.attr1_value
                );
            }
            if (
                !this.filter(this.attr2.values, this.attr2_value) &&
                this.attr2_value != ""
            ) {
                this.attr2.values.push(
                    this.attr2_value == undefined ? "" : this.attr2_value
                );
            }
            if (
                !this.filter(this.attr3.values, this.attr3_value) &&
                this.attr3_value != ""
            ) {
                this.attr3.values.push(
                    this.attr3_value == undefined ? "" : this.attr3_value
                );
            }
        },
        resetVariations() {
            this.attribute = [];
            this.attr1.status = false;
            this.attr2.status = false;
            this.attr3.status = false;

            this.attr1.values = [];
            this.attr2.values = [];
            this.attr3.values = [];

            this.data.variants = [];

            this.attr1_value = "";
            this.attr2_value = "";
            this.attr3_value = "";
        },
        remveVariant: function (index) {
            this.data.variants.splice(index, 1);
            this.data.variants[index].is_removed == true;
        },
    },
};
</script>
