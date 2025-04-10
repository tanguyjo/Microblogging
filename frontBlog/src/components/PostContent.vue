<script setup lang="ts">
import PostReadMore from "./PostReadMore.vue";

defineProps<{
  preview: string;
  postId: number;
}>();
</script>

<template>
  <p class="text-sm text-gray-700 mt-2 font-sans text-left">
    {{ preview }}
    <PostReadMore :postId="postId" />
  </p>
</template>
