<script lang="ts" setup>
import PostTitle from "./PostTitle.vue";
import PostContent from "./PostContent.vue";
import PostStats from "./PostStats.vue";
import PostAuthor from "./PostAuthor.vue";
import TagBadge from "./TagBadge.vue";
import { useRouter } from "vue-router";

const router = useRouter();

defineProps<{
  post: {
    id: number;
    title: string;
    content: string;
    created_at: string;
    likes: number;
    comments: number;
    author: string;
    tags: string[];
  };
}>();

function formatDateTime(
  dateString: string,
  mode: "full" | "short" | "hour" = "full"
): string {
  const date = new Date(dateString);
  if (isNaN(date.getTime())) return "Invalid date";

  if (mode === "short") {
    return new Intl.DateTimeFormat("en-GB", {
      day: "2-digit",
      month: "2-digit",
      year: "numeric",
    }).format(date);
  }

  if (mode === "hour") {
    return new Intl.DateTimeFormat("en-GB", {
      hour: "2-digit",
      minute: "2-digit",
      hour12: false,
    }).format(date);
  }

  return new Intl.DateTimeFormat("en-GB", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
    hour12: false,
  })
    .format(date)
    .replace(",", "");
}

function goToProfile(username: string) {
  router.push(`/profile/${username}`);
}
</script>

<template>
  <article class="mb-10 border-b border-gray-200 pb-6 md:pb-8 md:flex md:gap-6">
    <!-- Colonne gauche : date + author (desktop uniquement) -->
    <div
      class="hidden md:flex flex-col items-center w-24 text-sm text-gray-700 font-medium"
    >
      <!-- Desktop only -->
      <span class="hidden md:block text-sm text-gray-800">
        {{ formatDateTime(post.created_at) }}
      </span>

      <!-- Mobile only -->
      <span class="block md:hidden text-sm text-gray-600">
        {{ formatDateTime(post.created_at) }}
      </span>

      <button
        v-if="post.author && post.author.trim() !== ''"
        @click="goToProfile(post.author)"
        class="mt-6 -rotate-90 text-xs text-gray-500 font-light bg-transparent border-none p-0"
      >
        @{{ post.author }}
      </button>
    </div>

    <!-- Colonne droite -->
    <div class="w-full">
      <PostTitle :title="post.title" />
      <PostContent :preview="post.content.slice(0, 200)" :postId="post.id" />
      <PostAuthor
        :created_at="post.created_at"
        :author="post.author"
        class="md:hidden mt-3"
      />
      <PostStats
        :likes="post.likes"
        :comments="post.comments"
        :postId="post.id"
      />
      <div class="mt-3 flex flex-wrap gap-2">
        <TagBadge v-for="tag in post.tags" :key="tag" :label="tag" />
      </div>
    </div>
  </article>
</template>
