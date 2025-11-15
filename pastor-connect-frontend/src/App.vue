<template>
  <v-app>
    <v-app-bar v-if="authStore.isAuthenticated" app color="primary" dark>
      <v-app-bar-title>Pastor Connect</v-app-bar-title>

      <v-spacer></v-spacer>

      <v-btn icon to="/" title="Dashboard">
        <v-icon>mdi-view-dashboard</v-icon>
      </v-btn>

      <v-btn icon to="/pastors" title="Pastors">
        <v-icon>mdi-account-group</v-icon>
      </v-btn>

      <v-btn icon to="/messages" title="Messages">
        <v-icon>mdi-message</v-icon>
      </v-btn>

      <v-btn icon to="/sermons" title="Sermons">
        <v-icon>mdi-book-open-variant</v-icon>
      </v-btn>

      <v-btn icon to="/prayer-requests" title="Prayer Requests">
        <v-icon>mdi-hands-pray</v-icon>
      </v-btn>

      <v-btn icon to="/profile" title="Profile">
        <v-icon>mdi-account</v-icon>
      </v-btn>

      <v-btn icon @click="handleLogout" title="Logout">
        <v-icon>mdi-logout</v-icon>
      </v-btn>
    </v-app-bar>

    <v-main>
      <router-view />
    </v-main>
  </v-app>
</template>

<script setup>
import { useAuthStore } from './stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const handleLogout = async () => {
  await authStore.logout()
  router.push('/login')
}
</script>

<style scoped>
</style>
