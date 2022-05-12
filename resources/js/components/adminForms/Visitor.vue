<template>
  <v-row justify="center">
    <v-dialog
      v-model="addVisitorDialog"
      persistent
      max-width="600px"
    >
    
      <v-card>
        <v-card-title>
          <span class="text-h5">{{form.id ?'Edit' :'Add New'}} Visitor</span>
        </v-card-title>
        <v-card-text>
          <v-container>
            <v-row>
                <v-col      
                    cols="12"
                    sm="12"
                    md="12"
                >
                    <v-row>
                        <v-col>
                            <v-text-field
                                label="*First Name"
                                required
                                v-model="form.first_name"
                            ></v-text-field><v-text-field
                                label="*Last Name"
                                required
                                v-model="form.last_name"
                            ></v-text-field><v-text-field
                                label="*Phone Number"
                                required
                                v-model="form.phone_number"
                            ></v-text-field>
                            <v-text-field
                                label="*Email"
                                type="email"
                                required
                                v-model="form.email"
                            ></v-text-field>
                            
                            <p>*indicates required field</p>
                        </v-col>
                        
                        
                    </v-row>
                </v-col>
            
            </v-row>
          </v-container>
       
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            text
            @click="$emit('close')"
          >
            Close
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="$emit('save')"
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
  export default {
    props: {
        dialogState: {
            type: Boolean,
            required: true
        },
        form: {
            type: Object,
            required: true,
            default: {
                id:null,
                first_name: '',
                last_name: '',
                phone_number: '',
                email:'',
                // image: 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F2180657%2Fadd_add_photo_upload_plus_icon&psig=AOvVaw2bCaC6AsrefFBHZ3Id8IAP&ust=1632066273765000&source=images&cd=vfe&ved=0CAsQjRxqFwoTCIC3-ejuiPMCFQAAAAAdAAAAABAD',
            }
        }
    },
    data: () => ({
      dialog: false,
    }),
    methods : {
       
    },
    mouted(){
        
    },
    computed : {
        addVisitorDialog(){
            return this.dialogState
        }
    }
    
  }
</script>