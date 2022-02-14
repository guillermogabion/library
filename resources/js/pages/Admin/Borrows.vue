<template>
  <div>
    <v-card
      class="mx-auto px-5 py-5"
      outlined
    >
        <v-card-title>
          <span class="text-h5">Book Information</span>
        </v-card-title>
      <v-row>
          <v-col
            cols="4"
            md="4"
            sm="4"
          >
            <v-img
                lazy-src="https://picsum.photos/id/11/10/6"
                max-height="250"
                max-width="250"
                height="200"
                :src="form.image ? form.image : 'https://cdn.vuetifyjs.com/images/parallax/material2.jpg'"
            ></v-img>
            <v-btn 
                icon 
                large
                color="light-blue" 
                @click="$refs.inputUpload.click()"
            >
                <!-- <v-icon>mdi-image-plus</v-icon>  -->Scan Qr
            </v-btn>
            <input v-show="false" ref="inputUpload" type="file" @change="processImage" >
          </v-col>
          <v-col
            cols="8"
            sm="8"
            md="8"
          >
          <v-row>
            <v-autocomplete
            v-model="values"
            :items="items"
            outlined
            dense
            chips
            small-chips
            label="Select Book/s"
            multiple
          ></v-autocomplete>
          </v-row>
          <v-row>
            <v-text-field
                class="mr-5"
                label="Count"
                outlined
                required
                disabled
            ></v-text-field>
            <v-text-field
                label="Status"
                outlined
                required
                disabled
            ></v-text-field>
          </v-row>
          <v-row>
            <v-text-field
                label="Author"
                outlined
                required
                v-model="form.name"
                disabled
            ></v-text-field>
          </v-row>
          </v-col>
      </v-row>
        <v-divider></v-divider>
          <v-card-title>
            <span class="text-h5">Borrower Information</span>
          </v-card-title>
        <v-row class="ml-2">
          <v-select
            class="col-3 mr-2"
            v-model="value"
            :items="items"
            chips
            label="User Type"
            multiple
            outlined
          ></v-select>
          <v-select
            class="col-5 mr-2"
            v-model="value"
            :items="items"
            chips
            label="Course"
            multiple
            outlined
          ></v-select>
          <v-select
            class="col-3"
            v-model="value"
            :items="items"
            chips
            label="Year"
            multiple
            outlined
          ></v-select>
        </v-row>
        <v-row class="ml-2">
          <v-autocomplete
            v-model="values"
            :items="items"
            outlined
            dense
            chips
            small-chips
            multiple
            label="User Name"
          ></v-autocomplete>
        </v-row>
    </v-card>
  </div>
</template>

<script>
export default {
  props: {
    form: {
        type: Object,
        required: true,
        default: {
            id:null,
            name:'',
            email:'',
            password:'',
            // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
    }
  },
  mounted() {
  },
  methods: {
  },
}
</script>

<style>

</style>