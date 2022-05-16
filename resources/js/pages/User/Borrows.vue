<template>
    <div >
        <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
        Borrowed Book/s
        <v-spacer></v-spacer>
        
      </v-card-title>

      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="books"
        :loading="loading"
        :search="search"
        class="elevation-1"
      >
        <template v-slot:item.status ="{ item }">
                        {{item.status == 1 ? 'Available' : 'Unavailable'}}
        </template>
        
      </v-data-table>
    </v-card>
    </div>
</template>
<script>
  export default {
    
    data() {
      return {
        search: '',
        books: [],
        loading: true,
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          {
            text: 'ID',
            align: 'center',
            sortable: false,
            value: 'id',
          },
          { text: "Book Title", value: "book.book_title", align: 'center'},
          { text: "Author", value: "book.author", align: 'center'},
          { text: "Borrowed On", value: "date", align: 'center' },
        ],
        addition_edition_dailog: false,
        
      };
  },
  //this one will populate new data set when user changes current page. 
  watch: {
    options: {
      handler(val) {
        this.initialize() 
      },
    },
    deep: true,
  },
  methods: {
    //Reading data from API method. 
    initialize() {
        
        this.loading = true;
        this.$admin.get(`${localStorage.getItem('user_type')}/getBorrowed`).then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.books = data;
            console.log(data);
          });
    },

   
  },
  
  //this will trigger in the onReady State
  mounted() {
    this.initialize();
  },
  }
</script> 