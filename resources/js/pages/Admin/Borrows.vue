<template>
  <div>
    <v-card
      class="mx-auto px-5 py-5"
      outlined
    >
        <v-card-title>
          <span class="text-h5 font-weight-bold">Borrow Books</span>
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
              :items="items"
              :filter="customFilter"
              item-text="book_title"
              label="Search Book/s"
              hide-no-data
              @change="(event)=>change(event)"
              return-object
              class="ml-15 "
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
                v-model="form.available"
                class="mr-15 ml-15"
                label="Number of Available"
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
          <v-row  >
            <v-col 
              cols="8"
              sm="10"
              md="10"
              class="ml-15">
              <v-row>
                <v-autocomplete
                :items="users"
                :filter="userFilter"
                item-text="last_name"
                label="Search User"
                hide-no-data
                @change="(event)=>changeUser(event)"
                return-object
                
                >
                  <template v-slot:item ="{item}">
                    {{item.first_name}} {{item.last_name}} ({{item.type}})
                  </template>
                  <template v-slot:selection ="{item}">
                    {{item.first_name}} {{item.last_name}} ({{item.type}})
                  </template>

                </v-autocomplete>
              </v-row>
              <v-row class="ml-2 mr-2">
                <v-text-field
                    v-model="form.first_name"
                    label="First Name"
                    outlined
                    disabled
                    required
                    class="mr-15"
                ></v-text-field>
                <v-text-field
                    v-model="form.last_name"
                    label="Last Name"
                    disabled
                    outlined
                    required
                ></v-text-field>
              </v-row>
              <v-row  class="ml-2 mr-2">
                <v-text-field
                    v-model="form.phone_number"
                    label="Phone Number"
                    outlined
                    disabled
                    required
                    class="mr-15"
                ></v-text-field>
                <v-text-field
                    v-model="form.email"
                    label="Email"
                    outlined
                    disabled
                    required
                ></v-text-field>
              </v-row>
            </v-col>
            
          </v-row>
       
        
        <v-divider />
        <div class="d-flex justify-center mt-5 mb-6 mr-15">
          <v-btn
            rounded
            class="ma-2"
            color="info"
            @click="borrowBook()"
          >
            Borrow
          </v-btn>
        </div>
    </v-card>
  </div>
</template>

<script>
export default {
    data(){
      return{
        items:[],
        users: [],
        student:[],
        teacher:[],
        visitor:[],

        form: {
              id:null,
              book_title:'',
              author: '',
              available:'',
              status:'',


              user_id: null,
              user_type: '',
              first_name:'',
              last_name:'',
              phone_number:'',
              email:''


          }
      }
    },
  mounted() {
    this.initialize()
  },
  methods: {

    initialize(){

      this.form ={
         id:null,
              book_title:'',
              author: '',
              available:'',
              status:'',


              user_id: null,
              user_type: '',
              first_name:'',
              last_name:'',
              phone_number:'',
              email:''
      }
      
      this.$admin.get('api/book/index').then(({data})=> {
          this.items = data
          
      })
      this.$admin.get('api/student/index').then(({data})=> {
          this.student = data

          this.users = data.map((Student) => {
            return {
              ...Student,
              type : 'Student'
            }
          })
          var vm = this

          this.$admin.get('api/teacher/index').then(({data})=> {
            vm.teacher = data.map((Teacher)=> {

              return {
                ...Teacher,
                type: 'Teacher'
              }
            })

            vm.users.push.apply(vm.users, vm.teacher)

          })

          this.$admin.get('api/visitor/index').then(({data})=> {
            vm.visitor = data.map((Visitor)=> {

              return {
                ...Visitor,
                type: 'Visitor'
              }
            })

            vm.users.push.apply(vm.users,vm.visitor)
          
          })

          
      })
      

    },

    customFilter (item, queryText, itemText) {
      const textOne = item.book_title.toLowerCase()
      const textTwo = item.author.toLowerCase()
      const searchText = queryText.toLowerCase()

      return textOne.indexOf(searchText) > -1 ||
        textTwo.indexOf(searchText) > -1
    },
    userFilter (item, queryText, itemText) {
      const textOne = item.first_name.toLowerCase()
      const textTwo = item.last_name.toLowerCase()
      const searchText = queryText.toLowerCase()

      return textOne.indexOf(searchText) > -1 ||
        textTwo.indexOf(searchText) > -1
    },
    
    change(item){
      console.log('ten',item)
      this.form.id = item.id
      this.form.book_title = item.book_title
      this.form.author = item.author
      this.form.available = item.available
      this.form.status = item.status == 1? 'Available' : 'Unavailable'

    },
    changeUser(user) {
        this.form.user_id = user.id
        this.form.user_type = user.type
        this.form.first_name = user.first_name
        this.form.last_name = user.last_name
        this.form.phone_number = user.phone_number
        this.form.email = user.email
    },

    borrowBook(){
      this.$admin.post('api/borrow/create',this.form).then(({data}) =>{
        if(data == 'Error1'){
          this.errorNotify('User Already Borrowed Same Book');
        }
        else if(data == 'Error2'){
          this.errorNotify('User Already Borrowed 3 Books');
        }
        else if(data == 'Error3'){
          this.errorNotify('Book Is Not Available');
        }
        else{
          this.successNotify('Borrow');
        }
        this.initialize()
      })
    }
    
   
  }
}
</script>


