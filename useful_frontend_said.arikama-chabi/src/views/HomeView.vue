<script setup>
</script>

<template>
  <main>
    <h1>HOme</h1>
    <div class="mt-[3%] text-lg mb-[5%]">
      <span>Already have an account ? </span>
      <router-link to="/auth/login">
        <span class="hover:underline cursor-pointer">Log in</span></router-link
      >
    </div>
    <div class="mt-[3%] text-lg mb-[5%]">
      <span>New Here ? </span>
      <router-link to="/auth/register">
        <span class="hover:underline cursor-pointer">Register here</span></router-link
      >
    </div>
  </main>
</template>
