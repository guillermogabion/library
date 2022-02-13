<template>
<div class="mx-2 my-2">
    <v-card
        class="mx-auto px-5 py-5"
        outlined
    >
      <v-card-title>
        Teachers
      <v-spacer></v-spacer>
        <v-icon
          large
          @click="addTeacher"
        >
          mdi-plus
        </v-icon>
      </v-card-title>
      <v-data-table
        :footer-props="footerProps"
        :headers="headers"
        :items="teachers"
        :loading="loading"
        class="elevation-1"
      >
        <template v-slot:item.actions="{item}">
          <v-icon
            class="mr-2"
            @click="editTeacher(item)"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            @click="deleteTeacher(item)"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
    <TeacherForm :form="teacherForm" :dialogState="addition_edition_dailog" @close="addition_edition_dailog = false" @save="addition_edition_dailog = false,saveTeacher()" />

</div>
</template>
<script>
  import TeacherForm from '../../components/adminForms/Teacher.vue'
  export default {
    components: {
      TeacherForm
    },
    data() {
      return {
        teachers: [],
        loading: true,
        footerProps :{
          "items-per-page-options" : [5,10,15, 30, ]
        },
        headers: [
          { text: "Name", value: "name" },
          { text: "Email", value: "email" },
          { text: "Actions", value: "actions", sortable: false, },
        ],
        addition_edition_dailog: false,
        teacherForm: {
          id:null,
          name: '',
          email: '',
          password:'',
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
        this.teacherForm = {
          id:null,
          name: '',
          email: '',
          password:'',
          // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
        }
        this.loading = true;
        this.$admin.get('teacher/index').then((data) => {
            //Then injecting the result to datatable parameters.
            this.loading = false;
            this.teachers = data.data;
            console.log(data);
            // this.page = data.page;
            // this.total = data.total;
            // this.numberOfPages = data.last_page;
          });
      // console.log(this.teachers);
    },
    addTeacher(){
      this.teacherForm = {
        id:null,
        name: '',
        email: '',
        password:'',
        // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
      }
      this.addition_edition_dailog = true
    },
    editTeacher(teacher){
      this.teacherForm = {
        id: teacher.id,
        name:  teacher.name ,
        email:  teacher.email, 
        // image: '/storage/'+product.image 
      }
      this.addition_edition_dailog = true
    },
    saveTeacher(){
      console.log(this.teacherForm)
      if(this.teacherForm.id){
        this.$admin.post('teacher/update/'+this.teacherForm.id,this.teacherForm).then(({data}) => {
          console.log(data);
          this.successNotify('update');
          this.initialize()
        })
      }
      else{
        this.$admin.post('teacher/create',this.teacherForm).then(({data}) =>{
          this.successNotify('created');
          this.initialize()
        })
      }
    },
    deleteTeacher(teacher){
      this.$admin.delete('teacher/delete/'+ teacher.id).then(({data}) => {
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