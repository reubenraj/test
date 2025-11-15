import axios from 'axios'

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// Add auth token to requests
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

// Handle responses
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

export default {
  // Auth
  register(data) {
    return apiClient.post('/register', data)
  },
  login(credentials) {
    return apiClient.post('/login', credentials)
  },
  logout() {
    return apiClient.post('/logout')
  },
  forgotPassword(email) {
    return apiClient.post('/forgot-password', { email })
  },
  resetPassword(data) {
    return apiClient.post('/reset-password', data)
  },
  getUser() {
    return apiClient.get('/user')
  },

  // Pastor Profiles
  getProfiles() {
    return apiClient.get('/profiles')
  },
  getProfile(id) {
    return apiClient.get(`/profiles/${id}`)
  },
  getMyProfile() {
    return apiClient.get('/profile/my-profile')
  },
  saveProfile(data) {
    return apiClient.post('/profiles', data)
  },
  updateProfile(id, data) {
    return apiClient.put(`/profiles/${id}`, data)
  },
  deleteProfile(id) {
    return apiClient.delete(`/profiles/${id}`)
  },

  // Educations
  getEducations() {
    return apiClient.get('/educations')
  },
  createEducation(data) {
    return apiClient.post('/educations', data)
  },
  updateEducation(id, data) {
    return apiClient.put(`/educations/${id}`, data)
  },
  deleteEducation(id) {
    return apiClient.delete(`/educations/${id}`)
  },

  // Work Experiences
  getWorkExperiences() {
    return apiClient.get('/work-experiences')
  },
  createWorkExperience(data) {
    return apiClient.post('/work-experiences', data)
  },
  updateWorkExperience(id, data) {
    return apiClient.put(`/work-experiences/${id}`, data)
  },
  deleteWorkExperience(id) {
    return apiClient.delete(`/work-experiences/${id}`)
  },

  // Follows
  getPastors() {
    return apiClient.get('/pastors')
  },
  follow(userId) {
    return apiClient.post(`/follow/${userId}`)
  },
  unfollow(userId) {
    return apiClient.delete(`/unfollow/${userId}`)
  },
  getFollowers() {
    return apiClient.get('/followers')
  },
  getFollowing() {
    return apiClient.get('/following')
  },

  // Messages
  getMessages() {
    return apiClient.get('/messages')
  },
  getConversations() {
    return apiClient.get('/messages/conversations')
  },
  getConversation(userId) {
    return apiClient.get(`/messages/conversation/${userId}`)
  },
  sendMessage(data) {
    return apiClient.post('/messages', data)
  },
  markAsRead(id) {
    return apiClient.patch(`/messages/${id}/read`)
  },
  getUnreadCount() {
    return apiClient.get('/messages/unread-count')
  },

  // Sermons
  getSermons() {
    return apiClient.get('/sermons')
  },
  getSermon(id) {
    return apiClient.get(`/sermons/${id}`)
  },
  getMySermons() {
    return apiClient.get('/sermons/my-sermons')
  },
  createSermon(data) {
    return apiClient.post('/sermons', data)
  },
  updateSermon(id, data) {
    return apiClient.put(`/sermons/${id}`, data)
  },
  deleteSermon(id) {
    return apiClient.delete(`/sermons/${id}`)
  },

  // Prayer Requests
  getPrayerRequests() {
    return apiClient.get('/prayer-requests')
  },
  getPrayerRequest(id) {
    return apiClient.get(`/prayer-requests/${id}`)
  },
  getMyPrayerRequests() {
    return apiClient.get('/prayer-requests/my-requests')
  },
  createPrayerRequest(data) {
    return apiClient.post('/prayer-requests', data)
  },
  updatePrayerRequest(id, data) {
    return apiClient.put(`/prayer-requests/${id}`, data)
  },
  deletePrayerRequest(id) {
    return apiClient.delete(`/prayer-requests/${id}`)
  },
  updatePrayerRequestStatus(id, status) {
    return apiClient.patch(`/prayer-requests/${id}/status`, { status })
  },

  // Prayer Request Replies
  createPrayerReply(prayerRequestId, data) {
    return apiClient.post(`/prayer-requests/${prayerRequestId}/replies`, data)
  },
  updatePrayerReply(id, data) {
    return apiClient.put(`/prayer-request-replies/${id}`, data)
  },
  deletePrayerReply(id) {
    return apiClient.delete(`/prayer-request-replies/${id}`)
  },
}
