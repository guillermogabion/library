<template>
    <div>
        <div class="d-flex justify-space-between m-2" style="gap:20px" >
            <v-col lg="12" cols="12">
                <v-row>
                    <v-col cols="4" v-for="(item,index) in activityLog" :key="index">
                        <v-alert
                            class="mx-auto"
                            border="left"
                            colored-border
                            :color="item.color"
                            elevation="2"
                        >
                            <v-list-item three-line>
                                    <v-list-item-content>
                                        <v-list-item-title class="text-center text-h5 mb-1">
                                            {{item.title}}
                                        </v-list-item-title>
                                        <v-list-item-subtitle class="text-center text-h2">{{item.value}}</v-list-item-subtitle>
                                    </v-list-item-content>
                                    <v-list-item-avatar
                                        tile
                                        size="80"
                                    >
                                        <v-icon
                                            x-large
                                            :color="item.color"
                                        >
                                            {{item.icon}}
                                        </v-icon>
                                    </v-list-item-avatar>
                                </v-list-item>                    
                        </v-alert>
                    </v-col>
                </v-row>
            </v-col>
        
        </div>
        <div class="d-flex justify-space-between" style="gap:20px">
            <v-alert
                class="mx-auto"
                border="top"
                colored-border
                color="#446EA6"
                elevation="2"
            >
                <p class="text-h5 text-center pt-2">Transaction History (Borrowed Books)</p>
                <v-data-table
                    :headers="borrowedBooksHeaders"
                    :items="borrowedBooks"
                    item-key="name"
                    :items-per-page="5"
                    class="elevation-1 text-center"
                    :search="searchBorrowed"
                    :custom-filter="filterBorrowedBooksByName"
                    >
                     <template v-slot:item.name ="{item}">

                    {{item.borrowerable.first_name}} {{item.borrowerable.last_name}}
                    
                    </template>
                    <template v-slot:top>
                        <v-text-field
                        v-model="searchBorrowed"
                        label="Search"
                        class="mx-4"
                        ></v-text-field>
                    </template>
                    
                </v-data-table>
            </v-alert>
            <v-alert
                class="mx-auto"
                border="top"
                colored-border
                color="#304F8C"
                elevation="2"
            >
                <p class="text-h5 text-center pt-2">Transaction History (Returned Books)</p>
                <v-data-table
                        :headers="returnedBooksHeaders"
                        :items="returnedBooks"
                        item-key="name"
                        :items-per-page="5"
                        class="elevation-1"
                        :search="searchReturned"
                        :custom-filter="filterReturnedBooksByName"
                        >
                         <template v-slot:item.name ="{item}">

                        {{item.borrowerable.first_name}} {{item.borrowerable.last_name}}
                        
                        </template>
                        <template v-slot:top>
                            <v-text-field
                            v-model="searchReturned"
                            label="Search"
                            class="mx-4"
                            ></v-text-field>
                        </template>
                        
                </v-data-table>
            </v-alert>
        </div>
    </div>
</template>

<script>
export default {
    data : () => ({
        user : {},
        searchBorrowed: '',
        searchReturned: '',
        // calories: '',
        returnedBooks: [],
        borrowedBooks: [],
         activityLog: [
                    {title: 'Total Books', value: 0, icon: 'mdi-book-multiple', color: '#428C47'},
                    {title: 'Total Borrowed Books', value: 0, icon: 'mdi-book-multiple', color: '#BF8A49'},
                    {title: 'Total Users', value: 0, icon: 'mdi-account-multiple', color: '#F2D750'},
                ],

    }),
    mounted() {
        this.initialize()
    },
    computed: {
      headers () {
        return [
          {
            text: 'Dessert (100g serving)',
            align: 'start',
            sortable: false,
            value: 'name',
          },
          {
            text: 'Calories',
            value: 'calories',
            filter: value => {
              if (!this.calories) return true

              return value < parseInt(this.calories)
            },
          },
          { text: 'Fat (g)', value: 'fat' },
          { text: 'Carbs (g)', value: 'carbs' },
          { text: 'Protein (g)', value: 'protein' },
          { text: 'Iron (%)', value: 'iron' },
        ]
      },
      returnedBooksHeaders () {
          return [
           
                { text: 'Title of the Book', value: 'book.book_title' },
                { text: 'Name of Borrower', value: 'name' },
                { text: 'Date of Transaction', value: 'return_date' },
          ]
      },
      borrowedBooksHeaders () {
          return [

                { text: 'Title of the Book', value: 'book.book_title' },
                { text: 'Name of Borrower', value: 'name' },
                { text: 'Date of Transaction', value: 'date'},
          ]
      },
    },
    methods: {
      filterBorrowedBooksByName (value,searchBorrowed, item) {
        return value != null && 
          searchBorrowed != null &&
          typeof value === 'string' &&
          value.toString().indexOf(searchBorrowed) !== -1
      },
      filterReturnedBooksByName (value,searchReturned, item) {
        return value != null &&
          searchReturned != null &&
          typeof value === 'string' &&
          value.toString().indexOf(searchReturned) !== -1
      },
      initialize() {
         this.$admin.get('api/borrow/index').then(({data}) => {
              this.borrowedBooks = data
              this.loading = false;

            })

             this.$admin.get('api/borrow/returned').then(({data}) => {
              this.returnedBooks = data
              this.loading = false;

            })

            this.$admin.get('api/dashboard/getData').then(({data})=> {
                    this.activityLog[0].value= data.books
                    this.activityLog[1].value= data.borroweds
                    this.activityLog[2].value= data.users
                    

            })
      }


    },

};
</script>
<style scoped>
</style>