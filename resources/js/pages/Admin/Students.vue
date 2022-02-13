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
        :headers="headers"
        :items="students"
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
    <StudentForm :form="studentForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveStudent()" />

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
        students: [],
        loading: true,
        footerProps :{
          "items-per-page-options" : [5,10,15,30,]
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
          year: '',
          password: '',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('student/index')
          .then((data) => {
            // console.log(data);
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.students = data.data;
          });
    },
    addStudent(){
      this.studentForm = {
        id:null,
        name: '',
        email: '',
        course:'',
        year: '',
        password: '',
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
        // password: student.password,
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveStudent(){
      if(this.studentForm.id){
        console.log(this.studentForm);
        this.$admin.post('student/update/'+this.studentForm.id,this.studentForm).then(({data}) => {
          console.log(data);
          this.initialize()
        })
      }
      else{
          // console.log(this.studentForm);
          // return;
        this.$admin.post('student/create',this.studentForm).then(({data}) =>{
          this.initialize()
        })
      }
    },
    deleteStudent(student){
      this.$admin.delete('student/delete/'+ student.id).then(({data}) => {
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