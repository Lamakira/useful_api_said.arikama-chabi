<script setup>
import {ref, computed} from 'vue'
import {useAuthStore} from "@/stores/authStore.js";
import router from '@/router/index.js'

const authStore = useAuthStore();
const errors = ref({})
const formData = ref({
  "name": "",
  "email": '',
  "password": '',
  "password_confirmation": "",
})

async function saveNewUser() {
  const submitData = new FormData();
  submitData.append("name", formData.value.name)
  submitData.append("email", formData.value.email)
  submitData.append("password", formData.value.password)
  submitData.append("password_confirmation", formData.value.password_confirmation)

  console.log("SubmitData", submitData)

  try {
    authStore.loading = true
    await authStore.register(submitData);
    formData.value.name = ""
    formData.value.email = ""
    formData.value.password = ""
    formData.value.password_confirmation = ""
    alert('Registration successfull')
    router.push('/auth/login')
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors
    }
    console.log("Error during registration",errors.value)
  } finally {
    authStore.loading = false
  }
}
</script>

<template>
  <div class="flex flex-col justify-center items-center h-screen w-screen">
    <h1>Registration page</h1>
    <form @submit.prevent="saveNewUser" class="w-150">
      <div class="mb-5">
        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Your name</label>
        <input v-model="formData.name" type="text" id="name"
               class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
               placeholder="John Doe" required/>
        <span class="text-red-600 italic" v-if="errors?.name">{{
            errors.name[0]
          }}</span>
      </div>
      <div class="mb-5">
        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Your email</label>
        <input v-model="formData.email" type="email" id="email"
               class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
               placeholder="name@exemple.com" required/>
        <span class="text-red-600 italic" v-if="errors?.email">{{
            errors.email[0]
          }}</span>
      </div>
      <div class="mb-5">
        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 ">Your
          password</label>
        <input v-model="formData.password" type="password" id="password"
               class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
               required/>
        <span class="text-red-600 italic" v-if="errors?.password">{{
            errors.password[0]
          }}</span>
      </div>
      <div class="mb-5">
        <label for="repeat-password" class="block mb-2 text-sm font-medium text-gray-900 ">Repeat
          password</label>
        <input v-model="formData.password_confirmation" type="password" id="repeat-password"
               class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-xs-light"
               required/>
        <span class="text-red-600 italic" v-if="errors?.password">{{
            errors.password[0]
          }}</span>
      </div>
      <button type="submit"
              class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">
        {{ authStore.loading ? 'In Progress' : 'Register new account' }}
      </button>
    </form>

  </div>
</template>

<style scoped>

</style>
