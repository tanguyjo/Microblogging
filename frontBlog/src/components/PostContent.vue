<template>
  <p class="text-sm text-gray-700 mt-2 font-sans">
    {{ content }}
  </p>
</template>

<script lang="ts" setup>
defineProps<{ content: string }>();
</script>
