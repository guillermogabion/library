<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title>
        Students
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addStudent"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :page="page"
        :pageCount="numberOfPages"
        :headers="headers"
        :items="students"
        :options.sync="options"
        :server-items-length="total"
        :items-per-page="options.itemsPerPage"
        @update:options="initialize"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.actions="{item}">
          <v-icon
            class="mr-2"
            @click="editStudent(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteStudent(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <StudentForm :form="studentForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveProduct()" />

</div>
</template>
<script>
  import StudentForm from '../../components/adminForms/Student.vue'
  export default {
    components: {
      StudentForm
    },
    data() {
      return {
        page: 0,
        total: 0,
        numberOfPages: 0,
        students: [
            {
              id: '1',
              name: 'Daniel Batican',
              email: 'danny@sins.com',
              course: 'CIT',
              year: 0,
            },

        ],
        loading: true,
        options: {
          itemsPerPage: 10
        },
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          { text: "Name", value: "name" },
          { text: "Email", value: "email" },
          { text: "Course", value: "course" },
          { text: "Year", value: "year" },
          { text: "Actions", value: "actions", sortable: false, },
        ],
        addition_edition_dailog: false,
        studentForm: {
          id:null,
          name: '',
          email: '',
          course:'',
          year: null,
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
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
        this.studentForm = {
          id:null,
          name: '',
          email: '',
          course:'',
          year: null,
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        const { page, itemsPerPage } = this.options;
        let params = { 
          page: page,
          per_page: itemsPerPage
        } 
        this.$admin.get('/product/all', { params })
          .then(({data}) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            // this.students = data.data;
            this.page = data.page;
            this.total = data.total;
            this.numberOfPages = data.last_page;
          });
    },
    addStudent(){
      this.studentForm = {
        id:null,
        name: '',
        email: '',
        course:'',
        year: null,
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editStudent(student){
      this.studentForm = {
        id: student.id,
        name:  student.name ,
        email:  student.email ,
        course: student.course ,
        year: student.year ,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveProduct(){
      if(this.studentForm.id){
        this.$admin.put('/product/update/'+this.studentForm.id,this.studentForm).then(({data}) => {
          this.initialize()
        })
      }
      else{
        this.$admin.post('/product/create',this.studentForm).then(({data}) =>{
      
          this.initialize()
        })
      }
    },
    deleteStudent(student){
      this.$admin.delete('/product/delete/'+ student.id).then(({data}) => {
        this.initialize() 
      })
    }
  },
  
  //this will trigger in the onReady State
  mounted() {
    this.initialize();
  },
  }
</script>