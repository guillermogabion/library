<template>
    <div>
        <div class="d-flex justify-space-between m-2" style="gap:20px">
        <v-alert
            class="mx-auto"
            border="left"
            colored-border
            color="#428C47"
            elevation="2"
        >
           <v-list-item three-line>
                    <v-list-item-content>
                        <v-list-item-title class="text-center text-h5 mb-1">
                            Total Books
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-center text-h2">5000</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-avatar
                        tile
                        size="80"
                    >
                        <v-icon
                            x-large
                            color="#428C47"
                        >
                            mdi-book-multiple
                        </v-icon>
                    </v-list-item-avatar>
                
                </v-list-item>
               
        </v-alert>
        <v-alert
            class="mx-auto"
            border="left"
            colored-border
            color="#BF8A49"
            elevation="2"
        >
           <v-list-item three-line>
                    <v-list-item-content>
                        <v-list-item-title class="text-center text-h5 mb-1">
                            Total borrowed Books
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-center text-h2">50</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-avatar
                        tile
                        size="80"
                    >
                        <v-icon
                            x-large
                            color="#BF8A49"
                        >
                            mdi-book-multiple
                        </v-icon>
                    </v-list-item-avatar>
                
                </v-list-item>
                
        </v-alert>
        <v-alert
            class="mx-auto"
            border="left"
            colored-border
            color="#F2D750"
            elevation="2"
        >
           <v-list-item three-line>
                    <v-list-item-content>
                        <v-list-item-title class="text-center text-h5 mb-1">
                            Number of Users
                        </v-list-item-title>
                        <v-list-item-subtitle class="text-center text-h2">2350</v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-avatar
                        tile
                        size="80"
                    >
                        <v-icon
                            x-large
                            color="#F2D750"
                        >
                            mdi-account-multiple
                        </v-icon>
                    </v-list-item-avatar>
                
                </v-list-item>
               
        </v-alert>
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
                    <template v-slot:top>
                        <v-text-field
                        v-model="searchBorrowed"
                        label="Search"
                        class="mx-4"
                        ></v-text-field>
                    </template>
                    <template v-slot:body.append>
                        <tr>
                        <td></td>
                        <td colspan="4"></td>
                        </tr>
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
                        <template v-slot:top>
                            <v-text-field
                            v-model="searchReturned"
                            label="Search"
                            class="mx-4"
                            ></v-text-field>
                        </template>
                        <template v-slot:body.append>
                            <tr>
                            <td></td>
                            <td colspan="4"></td>
                            </tr>
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
        returnedBooks: [
            {
                bookTitle: 'book-1',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            },
            {
                bookTitle: 'book-2',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            },
            {
                bookTitle: 'book-3',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            },
            {
                bookTitle: 'book-4',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            },
            {
                bookTitle: 'book-5',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            }
        ],
        borrowedBooks: [
             {
                bookTitle: 'book-1',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            },
            {
                bookTitle: 'book-2',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            },
            {
                bookTitle: 'book-3',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            },
            {
                bookTitle: 'book-4',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            },
            {
                bookTitle: 'book-5',
                borrower: 'Daniel Batican',
                dateOfTransaction: '02/08/2022',
            }
        ],

    }),
    mounted() {
        console.log(Date.now())
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
            // {
            //     text: 'ID',
            //     align: 'start',
            //     sortable: false,
            //     value: 'name',
            // },
            // {
            //     text: 'Calories',
            //     value: 'calories',
            //     filter: value => {
            //     if (!this.calories) return true

            //     return value < parseInt(this.calories)
            //     },
            // },
                { text: 'Title of the Book', value: 'bookTitle' },
                { text: 'Name of Borrower', value: 'borrower' },
                { text: 'Date of Transaction', value: 'dateOfTransaction' },
          ]
      },
      borrowedBooksHeaders () {
          return [
            // {
            //     text: 'ID',
            //     align: 'start',
            //     sortable: false,
            //     value: 'name',
            // },
            // {
            //     text: 'Calories',
            //     value: 'calories',
            //     filter: value => {
            //     if (!this.calories) return true

            //     return value < parseInt(this.calories)
            //     },
            // },
                { text: 'Title of the Book', value: 'bookTitle' },
                { text: 'Name of Borrower', value: 'borrower' },
                { text: 'Date of Transaction', value: 'dateOfTransaction'},
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
          console.log('naman');
      }
    },

};
</script>
<style scoped>
</style>