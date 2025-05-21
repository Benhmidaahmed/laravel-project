<template>
  <div class="forbidden-page">
    <h1>403 - Access Forbidden</h1>
    <p>You do not have permission to view this page.</p>
    <router-link to="/">Go back home</router-link>
  </div>
</template>

<script setup lang="ts">
</script>

<style scoped>
.forbidden-page {
  text-align: center;
  margin-top: 100px;
}
</style>
