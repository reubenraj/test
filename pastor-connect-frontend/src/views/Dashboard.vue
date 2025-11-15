<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <h1 class="text-h3 mb-4">Welcome, {{ authStore.currentUser?.first_name }}!</h1>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" md="4">
        <v-card>
          <v-card-title class="bg-primary">
            <v-icon class="mr-2">mdi-account-group</v-icon>
            Pastors
          </v-card-title>
          <v-card-text class="text-center pa-6">
            <div class="text-h4">{{ stats.pastorsCount }}</div>
            <div>Connect with other pastors</div>
          </v-card-text>
          <v-card-actions>
            <v-btn block color="primary" to="/pastors">View Pastors</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="12" md="4">
        <v-card>
          <v-card-title class="bg-info">
            <v-icon class="mr-2">mdi-book-open-variant</v-icon>
            Sermons
          </v-card-title>
          <v-card-text class="text-center pa-6">
            <div class="text-h4">{{ stats.sermonsCount }}</div>
            <div>Share your sermons</div>
          </v-card-text>
          <v-card-actions>
            <v-btn block color="info" to="/sermons">View Sermons</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>

      <v-col cols="12" md="4">
        <v-card>
          <v-card-title class="bg-success">
            <v-icon class="mr-2">mdi-hands-pray</v-icon>
            Prayer Requests
          </v-card-title>
          <v-card-text class="text-center pa-6">
            <div class="text-h4">{{ stats.prayerRequestsCount }}</div>
            <div>Pray for one another</div>
          </v-card-text>
          <v-card-actions>
            <v-btn block color="success" to="/prayer-requests">View Prayer Requests</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()

const stats = ref({
  pastorsCount: 0,
  sermonsCount: 0,
  prayerRequestsCount: 0,
})

onMounted(async () => {
  // Load stats here
})
</script>
