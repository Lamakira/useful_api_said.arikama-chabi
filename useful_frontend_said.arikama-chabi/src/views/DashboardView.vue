<script setup>
import SideBar from "@/components/SideBar.vue";

</script>

<template>

  <SideBar/>
  <div class="p-4 sm:ml-64">
    <div class="p-4 border-2 border-gray-200 border-dashed rounded-lg dark:border-gray-700 h-screen">
      <RouterView/>
    </div>
  </div>

</template>

<style scoped>

</style>
