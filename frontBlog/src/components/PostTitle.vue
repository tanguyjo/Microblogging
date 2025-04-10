<template>
  <h3 class="text-lg font-bold text-purple-700 font-serif leading-snug">
    {{ title }}
  </h3>
</template>

<script lang="ts" setup>
defineProps<{ title: string }>();
</script>
