<template>
  <div class="flex items-center text-sm mt-4 font-medium text-gray-800">
    <span>{{ date }}</span>
    <span class="mx-2">♡ {{ likes }}</span>
    <span>💬 {{ comments }}</span>
    <span class="ml-auto text-gray-600">{{ author }}</span>
  </div>
</template>

<script lang="ts" setup>
defineProps<{
  date: string;
  likes: number;
  comments: number;
  author: string;
}>();
</script>
