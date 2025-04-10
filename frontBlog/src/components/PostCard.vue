<script lang="ts" setup>
import PostTitle from "./PostTitle.vue";
import PostContent from "./PostContent.vue";
import PostStats from "./PostStats.vue";
import PostAuthor from "./PostAuthor.vue";
import TagBadge from "./TagBadge.vue";

defineProps<{
  post: {
    id: number;
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
  <article class="mb-10 border-b border-gray-200 pb-6 md:pb-8 md:flex md:gap-6">
    <!-- Colonne gauche : date + author (desktop uniquement) -->
    <div
      class="hidden md:flex flex-col items-center w-24 text-sm text-gray-700 font-medium"
    >
      <span class="text-2xl font-extrabold text-black leading-none">
        {{ post.date.split("/")[0] }}
      </span>
      <span class="uppercase tracking-wide text-lg">
        {{ post.date.split("/")[1] }}
      </span>
      <span class="mt-6 -rotate-90 text-xs text-gray-500 font-light">
        @{{ post.author }}
      </span>
    </div>

    <!-- Colonne droite -->
    <div class="w-full">
      <PostTitle :title="post.title" />
      <PostContent :preview="post.content.slice(0, 200)" :postId="post.id" />
      <PostAuthor
        :date="post.date"
        :author="post.author"
        class="md:hidden mt-3"
      />
      <PostStats :likes="post.likes" :comments="post.comments" />
      <div class="mt-3 flex flex-wrap gap-2">
        <TagBadge v-for="tag in post.tags" :key="tag" :label="tag" />
      </div>
    </div>
  </article>
</template>
