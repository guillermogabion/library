<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title class="text-h5 font-weight-bold">
       Borrowed Books
        <v-spacer></v-spacer>
        <v-text-field
          v-model="search"
          append-icon="mdi-magnify"
          label="Search Book/s Borrowed"
          single-line
          hide-details
        ></v-text-field>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="borrows"
        :search="search"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.name ="{item}">
          {{item.borrowerable.first_name}} {{item.borrowerable.last_name}}
        </template>
        <template v-slot:item.action="{item}">
           <v-btn class="mr-2" small color="success" @click="returnBook(item)">
            Return Book
          </v-btn>
        </template>
      </v-data-table>
    </v-card>
</div>
</template>
<script>
// import moment from 'moment'
    export default {
      data() {
        return {
            footerProps :{
                "items-per-page-options" : [5,10,15,30,]
            },
            search: '',
            student:{},
            loading: true,
            borrows: [],
            headers: [
            {
                text: 'ID',
                align: 'center',
                sortable: false,
                value: 'id',
            },
            {text: 'Borrower Name', align: 'center', value: 'name'},
            {text: 'Book Name', align: 'center', value: 'book.book_title'},
            {text: 'Author', align: 'center', value: 'book.author'},
            {text: 'Borrowed On', align: 'center', value: 'date'},
            // {text: 'Status', align: 'center', value: 'status'},
            {text: 'Action', align: 'center', value: 'action'},
            ],
            editedIndex: -1,
            editedItem: {
            name: '',
            book: '',
            author: '',
            date: ''
          },
          defaultItem: {
            name: '',
            book: '',
            author: '',
            date: ''
          },
          timestamp: ""
        }
      },
      
      mounted () {
          this.initialize()
      },
      created() {
                setInterval(this.getNow, 1000);
      },
      methods : { 
        initialize(){
            this.$admin.get('api/borrow/index').then(({data}) => {
              this.borrows = data
              this.loading = false;

            })
        },

        returnBook(item){
          this.$admin.post('api/borrow/update/'+ item.id, item).then(({data}) => {
            console.log(item);
            this.successNotify('Return');
            this.initialize() 
          })
        },
        getNow() {
                    const today = new Date();
                    const date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
                    // const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                    const dateTime = date;
                    this.timestamp = dateTime;
        },
        countDate(){
          const a = this.timestamp;
          const b = this.date;
          this.delays = b - a;
        }

    

      }
      
  }

  
</script>