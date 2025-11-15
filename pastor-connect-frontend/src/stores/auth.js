import { defineStore } from 'pinia'
import api from '../services/api'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: JSON.parse(localStorage.getItem('user')) || null,
    token: localStorage.getItem('token') || null,
  }),

  getters: {
    isAuthenticated: (state) => !!state.token,
    currentUser: (state) => state.user,
  },

  actions: {
    async register(userData) {
      try {
        const response = await api.register(userData)
        this.token = response.data.token
        this.user = response.data.user
        localStorage.setItem('token', this.token)
        localStorage.setItem('user', JSON.stringify(this.user))
        return response.data
      } catch (error) {
        throw error
      }
    },

    async login(credentials) {
      try {
        const response = await api.login(credentials)
        this.token = response.data.token
        this.user = response.data.user
        localStorage.setItem('token', this.token)
        localStorage.setItem('user', JSON.stringify(this.user))
        return response.data
      } catch (error) {
        throw error
      }
    },

    async logout() {
      try {
        await api.logout()
      } catch (error) {
        console.error('Logout error:', error)
      } finally {
        this.token = null
        this.user = null
        localStorage.removeItem('token')
        localStorage.removeItem('user')
      }
    },

    async fetchUser() {
      try {
        const response = await api.getUser()
        this.user = response.data.user
        localStorage.setItem('user', JSON.stringify(this.user))
        return response.data.user
      } catch (error) {
        throw error
      }
    },
  },
})
