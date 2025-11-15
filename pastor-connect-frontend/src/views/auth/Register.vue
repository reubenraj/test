<template>
  <v-container fluid class="fill-height" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <v-row align="center" justify="center">
      <v-col cols="12" sm="10" md="8" lg="6">
        <v-card class="elevation-12">
          <v-toolbar color="primary" dark flat>
            <v-toolbar-title>Register for Pastor Connect</v-toolbar-title>
          </v-toolbar>
          <v-card-text>
            <v-form @submit.prevent="handleRegister">
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    v-model="formData.name"
                    label="Full Name"
                    prepend-icon="mdi-account"
                    required
                    :error-messages="errors.name"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="formData.first_name"
                    label="First Name"
                    required
                    :error-messages="errors.first_name"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="formData.last_name"
                    label="Last Name"
                    required
                    :error-messages="errors.last_name"
                  ></v-text-field>
                </v-col>

                <v-col cols="12">
                  <v-text-field
                    v-model="formData.email"
                    label="Email"
                    prepend-icon="mdi-email"
                    type="email"
                    required
                    :error-messages="errors.email"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="formData.phone"
                    label="Phone (Optional)"
                    prepend-icon="mdi-phone"
                    :error-messages="errors.phone"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-textarea
                    v-model="formData.address"
                    label="Address (Optional)"
                    prepend-icon="mdi-map-marker"
                    rows="1"
                    :error-messages="errors.address"
                  ></v-textarea>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="formData.password"
                    label="Password"
                    prepend-icon="mdi-lock"
                    type="password"
                    required
                    :error-messages="errors.password"
                  ></v-text-field>
                </v-col>

                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="formData.password_confirmation"
                    label="Confirm Password"
                    prepend-icon="mdi-lock-check"
                    type="password"
                    required
                    :error-messages="errors.password_confirmation"
                  ></v-text-field>
                </v-col>
              </v-row>

              <v-alert v-if="errorMessage" type="error" class="mb-4 mt-2">
                {{ errorMessage }}
              </v-alert>

              <v-btn
                color="primary"
                block
                type="submit"
                :loading="loading"
                size="large"
                class="mt-4"
              >
                Register
              </v-btn>
            </v-form>
          </v-card-text>
          <v-card-actions class="justify-center pb-4">
            <span class="text-body-2">Already have an account?</span>
            <router-link to="/login" class="ml-2 text-decoration-none">
              Login
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

const formData = ref({
  name: '',
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  address: '',
  password: '',
  password_confirmation: '',
})

const loading = ref(false)
const errorMessage = ref('')
const errors = ref({})

const handleRegister = async () => {
  loading.value = true
  errorMessage.value = ''
  errors.value = {}

  try {
    await authStore.register(formData.value)
    router.push('/')
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors || {}
    }
    errorMessage.value = error.response?.data?.message || 'Registration failed. Please try again.'
  } finally {
    loading.value = false
  }
}
</script>
