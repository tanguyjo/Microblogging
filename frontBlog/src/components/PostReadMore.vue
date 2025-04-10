<template>
  <RouterLink
    :to="`/posts/${postId}`"
    class="text-purple-600 cursor-pointer hover:underline"
  >
    ...read more
  </RouterLink>
</template>

<script setup lang="ts">
defineProps<{ postId: number }>();
</script>
