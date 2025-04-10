<template>
  <span
    class="text-xs px-3 py-1 border border-purple-600 rounded-full text-purple-600 font-sans"
  >
    {{ label }}
  </span>
</template>

<script lang="ts" setup>
defineProps<{ label: string }>();
</script>
