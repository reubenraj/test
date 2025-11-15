import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../stores/auth'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: () => import('../views/auth/Login.vue'),
    meta: { requiresGuest: true },
  },
  {
    path: '/register',
    name: 'Register',
    component: () => import('../views/auth/Register.vue'),
    meta: { requiresGuest: true },
  },
  {
    path: '/forgot-password',
    name: 'ForgotPassword',
    component: () => import('../views/auth/ForgotPassword.vue'),
    meta: { requiresGuest: true },
  },
  {
    path: '/',
    name: 'Dashboard',
    component: () => import('../views/Dashboard.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/profile',
    name: 'Profile',
    component: () => import('../views/profile/Profile.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/pastors',
    name: 'Pastors',
    component: () => import('../views/pastors/PastorList.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/messages',
    name: 'Messages',
    component: () => import('../views/messages/Messages.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/sermons',
    name: 'Sermons',
    component: () => import('../views/sermons/SermonList.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/sermons/create',
    name: 'CreateSermon',
    component: () => import('../views/sermons/SermonForm.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/sermons/:id',
    name: 'SermonDetail',
    component: () => import('../views/sermons/SermonDetail.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/prayer-requests',
    name: 'PrayerRequests',
    component: () => import('../views/prayers/PrayerRequestList.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/prayer-requests/create',
    name: 'CreatePrayerRequest',
    component: () => import('../views/prayers/PrayerRequestForm.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/prayer-requests/:id',
    name: 'PrayerRequestDetail',
    component: () => import('../views/prayers/PrayerRequestDetail.vue'),
    meta: { requiresAuth: true },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()

  if (to.meta.requiresAuth && !authStore.isAuthenticated) {
    next('/login')
  } else if (to.meta.requiresGuest && authStore.isAuthenticated) {
    next('/')
  } else {
    next()
  }
})

export default router
