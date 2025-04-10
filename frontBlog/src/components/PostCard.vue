<script lang="ts" setup>
import PostTitle from "./PostTitle.vue";
import PostContent from "./PostContent.vue";
import PostMeta from "./PostMeta.vue";
import PostReadMore from "./PostReadMore.vue";
import TagBadge from "./TagBadge.vue";

defineProps<{
  post: {
    title: string;
    content: string;
    date: string;
    likes: number;
    comments: number;
    author: string;
    tags: string[];
  };
}>();
</script>

<template>
  <div class="mb-8">
    <PostTitle :title="post.title" />
    <PostContent :content="post.content" />
    <PostReadMore />
    <PostMeta
      :date="post.date"
      :likes="post.likes"
      :comments="post.comments"
      :author="post.author"
    />
    <div class="mt-3 flex flex-wrap gap-2">
      <TagBadge v-for="tag in post.tags" :key="tag" :label="tag" />
    </div>
  </div>
</template>
