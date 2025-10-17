import apiClient from './api.js'

class UsefulApiService {
  async register(params) {
    return await apiClient.post('/register', params)
  }
  async login(params) {
    return await apiClient.post('/login', params)

  }

  async logout() {
    return await apiClient.get('/logout')
  }

  async getAllModules() {
    return await apiClient.get('/modules')
  }

  async moduleActivate(moduleId) {
    return await apiClient.post(`/modules/${moduleId}/activate`)
  }

  async moduleDeactivate(moduleId) {
    return await apiClient.post(`/modules/${moduleId}/deactivate`)
  }
}
export default new UsefulApiService()
