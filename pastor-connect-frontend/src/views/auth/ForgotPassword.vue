<template>
  <v-container fluid class="fill-height" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="6" lg="4">
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Forgot Password</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form @submit.prevent="handleForgotPassword">
              <v-text-field
                v-model="email"
                label="Email"
                prepend-icon="mdi-email"
                type="email"
                required
              ></v-text-field>

              <v-alert v-if="successMessage" type="success" class="mb-4">
                {{ successMessage }}
              </v-alert>

              <v-alert v-if="errorMessage" type="error" class="mb-4">
                {{ errorMessage }}
              </v-alert>

              <v-btn
                color="primary"
                block
                type="submit"
                :loading="loading"
                size="large"
                class="mb-4"
              >
                Send Reset Link
              </v-btn>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-center pb-4">
            <router-link to="/login" class="text-decoration-none">
              Back to Login
            </router-link>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import api from '../../services/api'

const email = ref('')
const loading = ref(false)
const errorMessage = ref('')
const successMessage = ref('')

const handleForgotPassword = async () => {
  loading.value = true
  errorMessage.value = ''
  successMessage.value = ''

  try {
    await api.forgotPassword(email.value)
    successMessage.value = 'Password reset link sent to your email!'
  } catch (error) {
    errorMessage.value = error.response?.data?.message || 'Failed to send reset link.'
  } finally {
    loading.value = false
  }
}
</script>
