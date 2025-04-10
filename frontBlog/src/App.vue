<script setup lang="ts"></script>

<template>
  <div>
    <a href="https://vite.dev" target="_blank">
      <h1 class="text-3xl font-bold text-purple-600">Hello Tailwind 🎉</h1>
      <h1 class="font-title text-3xl">Titre principal</h1>
      <p class="font-sans text-sm">Texte courant</p>
      <router-view />
    </a>
  </div>
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
