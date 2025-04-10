<template>
  <nav class="fixed bottom-4 left-0 right-0 z-50 flex justify-center md:hidden">
    <div
      class="flex justify-between items-center w-[90%] max-w-sm px-6 py-3 border border-purple-500 rounded-lg bg-white text-purple-600 text-xl shadow-sm"
    >
      <!-- Avatar rond -->
      <button
        class="w-8 h-8 bg-purple-600 text-white rounded-full font-semibold flex items-center justify-center text-sm"
      >
        S
      </button>

      <!-- Loupe -->
      <button>
        <span class="material-symbols-outlined">search</span>
      </button>

      <!-- Plus -->
      <button>
        <span class="material-symbols-outlined">add</span>
      </button>

      <!-- Flèche / explore -->
      <button>
        <span class="material-symbols-outlined">trending_up</span>
      </button>
    </div>
  </nav>
</template>

<script setup lang="ts">
// pas de logique JS pour l’instant
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined");

.material-symbols-outlined {
  font-family: "Material Symbols Outlined";
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-block;
  white-space: nowrap;
  direction: ltr;
  -webkit-font-feature-settings: "liga";
  -webkit-font-smoothing: antialiased;
}
</style>
