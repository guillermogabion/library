<template>
  <div>
    <v-card
      class="mx-auto px-5 py-5"
      outlined
    >
        <v-card-title>
          <span class="text-h5">Borrow Books</span>
        </v-card-title>
      <v-row>
          <v-col
            cols="8"
            sm="10"
            md="10"
            class="ml-15"

          >
          <v-row  >
            <v-autocomplete
              v-model="form.book_title"
              :items="items"
              :filter="customFilter"
              item-text="book_title"
              label="Search Book/s"
              hide-no-data
              @change="(event)=>change(event)"
              return-object
              class="ml-15"
            ></v-autocomplete>
          </v-row>
          <v-row>
            <v-text-field
              v-model="form.book_title"
                class="mr-15 ml-15"
                label="Book Title"
                outlined
                required
                disabled
            ></v-text-field>
            <v-text-field
              v-model="form.author"
                label="Author"
                outlined
                required
                disabled
            ></v-text-field>
          </v-row>
          <v-row>
            <v-text-field
                v-model="form.count"
                class="mr-15 ml-15"
                label="Count"
                outlined
                required
                disabled
            ></v-text-field>
            <v-text-field
                label="Status"
                outlined
                required
                v-model="form.status"
                disabled
            ></v-text-field>
          </v-row>
          </v-col>
      </v-row>
        <v-divider></v-divider>
          <v-card-title>
            <span class="text-h5">Input Borrower Information</span>
          </v-card-title>
        <v-row class="ml-2 mr-2">
          <v-text-field
              label="First Name"
              outlined
              required
              class="mr-15"
          ></v-text-field>
           <v-text-field
              label="Last Name"
              outlined
              required
          ></v-text-field>
        </v-row>
        <v-row  class="ml-2 mr-2">
           <v-text-field
              label="Phone Number"
              outlined
              required
              class="mr-15"
          ></v-text-field>
          <v-text-field
              label="Email"
              outlined
              required
          ></v-text-field>
        </v-row>
        <v-divider />
        <div class="d-flex justify-center mt-5 mb-6 mr-15">
          <v-btn
            depressed
            color="blue darken-1"
            text
            @click="$emit('save')"
          >
            Borrow
          </v-btn>
        </div>
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
              book_title:'',
              author: '',
              count:'',
              status:'',
          }
      }
    },
    data(){
      return{
        items:[]
      }
    },
  mounted() {
    this.initialize()
  },
  methods: {
    initialize(){
      this.$admin.get('book/index').then(({data})=> {
          this.items = data
          
      })
    },

    customFilter (item, queryText, itemText) {
      const textOne = item.book_title.toLowerCase()
      const textTwo = item.author.toLowerCase()
      const searchText = queryText.toLowerCase()

      return textOne.indexOf(searchText) > -1 ||
        textTwo.indexOf(searchText) > -1
    },

    change(item){
      this.form.book_title = item.book_title
      this.form.author = item.author
      this.form.count = item.count
      this.form.status = item.status

    },
  }
}
</script>

