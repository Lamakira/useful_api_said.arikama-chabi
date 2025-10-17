<script setup>
import {ref, computed} from 'vue'
import {useAuthStore} from "@/stores/authStore.js";
import router from '@/router/index.js'

const authStore = useAuthStore();
const errors = ref(null)
const formData = ref({
  "email": '',
  "password": '',
})

async function signin() {
  const submitData = new FormData();
  submitData.append("email", formData.value.email)
  submitData.append("password", formData.value.password)

  console.log("SubmitData", submitData)

  try {
    authStore.loading = true
    await authStore.login(submitData);
    formData.value.email = ""
    formData.value.password = ""
    router.push('/dashboard')
  } catch (error) {
    if (error.response?.status === 401) {
      errors.value = error.response.data.message
    }
    console.log("Error during login",errors.value)
  } finally {
    authStore.loading = false
  }
}
</script>

<template>
  <div class="w-screen h-screen flex items-center justify-center flex-col">
    <h1>Login Page</h1>
    <form @submit.prevent="signin" class="w-150">
      <span class="text-red-600 italic" v-if="errors">{{
          errors
        }}</span>
      <div class="mb-5">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Your email</label>
        <input v-model="formData.email" type="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@exemple.com" required />
      </div>
      <div class="mb-5">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Your password</label>
        <input v-model="formData.password" type="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required />
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">{{ authStore.loading ? 'In Progress' : 'Login' }}</button>
    </form>

    <div class="text-center mt-[3%] text-lg mb-[5%]">
      <span>New Here ? </span>
      <router-link to="/auth/register">
        <span class="hover:underline cursor-pointer">Register here</span></router-link
      >
    </div>
  </div>


</template>

<style scoped>

</style>
