<!-- Start of Selection -->
<script setup lang="ts">
import { onMounted } from "vue";
import { fetchCurrentUser } from "./composables/useAuth";

onMounted(async () => {
  try {
    await fetchCurrentUser();
  } catch (error) {
    console.error("Error retrieving the current user:", error);
  }
});
</script>

<template>
  <router-view />
</template>

<style scoped>
.logo {
  height: 6em;
  padding: 1.5em;
  will-change: filter;
  transition: filter 300ms;
}
.logo:hover {
  filter: drop-shadow(0 0 2em #646cffaa);
}
.logo.vue:hover {
  filter: drop-shadow(0 0 2em #42b883aa);
}
</style>
