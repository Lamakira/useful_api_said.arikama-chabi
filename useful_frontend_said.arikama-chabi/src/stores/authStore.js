import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import UsefulApiService from '@/services/service'
import router from '@/router/index.js'
import axios from '../services/api.js'

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null)
  const token = ref(null)
  const loading = ref(false)
  const errors = ref({})
  const isAuthenticated = computed(() => token.value !== null)

  function setAuthData(userData, authToken) {
    user.value = userData
    token.value = authToken
    axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
  }

  function clearAuthData() {
    user.value = null
    token.value = null
    delete axios.defaults.headers.common['Authorization']
  }

  async function login(credentials) {
      const response = await UsefulApiService.login(credentials)
      console.log("Response when login end", response)
      setAuthData(response.data.user, response.data.token)
      console.log('user from store ', response.data.user)
  }

  async function register(params) {
      console.log("Auth store register called")
      return await UsefulApiService.register(params)
  }

  async function logout() {
    if (isAuthenticated.value) {
      await UsefulApiService.logout()
    }
    clearAuthData()
    router.push('/auth/login')
  }


  return {
    user,
    token,
    loading,
    isAuthenticated,
    login,
    register,
    logout,
  }
}, {
  persist: true,
})
