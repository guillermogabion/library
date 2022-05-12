<template>
  <v-app id="inspire">
    <v-app-bar
      app absolute  
      color="primary" 
      class="text-white"
    >
      <v-avatar
          class="mr-10"
      >
      <img
          src="/images/logo.png"
        class="at-logo" >
      </v-avatar>
      
      <v-btn
          v-for="(link, i) in links"
          :key="i"
          text
          @click="$router.push(link.link)"
        >
          {{ link.text }}
        </v-btn>
      <v-spacer></v-spacer>
      <v-btn small @click="logoutUser">
        <v-icon >
          mdi-logout
        </v-icon>
        Logout
      </v-btn>
      
    </v-app-bar>

    <!-- <v-main class="light-green accent-2 "> -->
    <v-main class="yellow lighten-1 ">
      <v-container>
        <transition 
                  
          >
              <router-view> </router-view>
        </transition>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
  export default {
    data: () => ({
      links: [
        { text : 'Books',link : 'dashboard'},
        { text : 'Borrowed Book/s',link : 'borroweds'},
      
        // { text : 'Enrolled Subjects',link : '/enrolled_subjects'},
      ],
    }),
    methods : {
        logoutUser(){
            this.$admin.post(`/${localStorage.getItem('user_type')}/logout`).then((response) => {
                localStorage.removeItem("token")
                localStorage.removeItem('user_type')
                this.$router.push('/login')
            })
        },
    },
  }
</script>