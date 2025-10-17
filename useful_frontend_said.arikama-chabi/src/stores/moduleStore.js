import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import UsefulApiService from '@/services/service'
import router from '@/router/index.js'
import axios from '../services/api.js'

export const useModuleStore = defineStore('module', () => {
  const modules = ref([])
  const loading = ref(false)
  const userModulesActive = ref([])


  async function getAllModules() {
    const response = await UsefulApiService.getAllModules()
    modules.value = response.data
  }

  return {
   modules,
    getAllModules
  }
}, {
  persist: true,
})
