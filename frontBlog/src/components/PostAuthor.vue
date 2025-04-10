<template>
  <div class="text-sm text-gray-600 font-medium">
    <span class="mr-2">{{ date }}</span>
    <span class="ml-auto">@{{ author }}</span>
  </div>
</template>

<script setup lang="ts">
defineProps<{ date: string; author: string }>();
</script>
