<template>
  <v-container fluid class="fill-height" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="6" lg="4">
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Login to Pastor Connect</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form @submit.prevent="handleLogin">
              <v-text-field
                v-model="credentials.email"
                label="Email"
                prepend-icon="mdi-email"
                type="email"
                required
                :error-messages="errors.email"
              ></v-text-field>

              <v-text-field
                v-model="credentials.password"
                label="Password"
                prepend-icon="mdi-lock"
                type="password"
                required
                :error-messages="errors.password"
              ></v-text-field>

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
                Login
              </v-btn>

              <div class="text-center">
                <router-link to="/forgot-password" class="text-decoration-none">
                  Forgot password?
                </router-link>
              </div>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-center pb-4">
            <span class="text-body-2">Don't have an account?</span>
            <router-link to="/register" class="ml-2 text-decoration-none">
              Register
            </router-link>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const authStore = useAuthStore()

const credentials = ref({
  email: '',
  password: '',
})

const loading = ref(false)
const errorMessage = ref('')
const errors = ref({})

const handleLogin = async () => {
  loading.value = true
  errorMessage.value = ''
  errors.value = {}

  try {
    await authStore.login(credentials.value)
    router.push('/')
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors || {}
    }
    errorMessage.value = error.response?.data?.message || 'Login failed. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>
