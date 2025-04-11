<script setup lang="ts">
import { useRoute } from "vue-router";
import PostTitle from "@/components/PostTitle.vue";
import PostStats from "@/components/PostStats.vue";
import TagBadge from "@/components/TagBadge.vue";

const route = useRoute();
const postId = Number(route.params.id);

// Exemple statique (à remplacer plus tard par une API)
const posts = [
  {
    id: 1,
    title: "15 Disadvantages Of Freedom And How You Can Workaround It.",
    content:
      "Ut tellus elementum sagittis vitae et leo. Cursus in hac habitasse platea dictumst quisque sagittis purus. Odio facilisis mauris sit amet...",
    date: "27/05/22",
    likes: 12,
    comments: 7,
    author: "samurai2099",
    tags: ["#mentalpeace", "#ludens"],
  },
  {
    id: 2,
    title: "The Death of Democracy.",
    content:
      "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
    date: "25/05/22",
    likes: 8,
    comments: 3,
    author: "anonymous",
    tags: ["#anarchy", "#silence"],
  },
];

const post = posts.find((p) => p.id === postId);
</script>

<template>
  <div class="max-w-3xl mx-auto px-4 pt-8 pb-16">
    <!-- Bouton retour -->
    <RouterLink
      to="/"
      class="flex items-center text-darkviolet hover:underline mb-6"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-5 h-5 mr-2"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
        />
      </svg>
      Back to posts
    </RouterLink>

    <div v-if="post">
      <!-- Titre -->
      <PostTitle :title="post.title" class="mb-4 text-purple-600 text-2xl" />

      <!-- Date + auteur -->
      <p class="text-sm text-gray-600 mb-2" v-if="post.author">
        {{ post.date }} — @{{ post.author }}
      </p>
      <p class="text-sm text-gray-600 mb-2" v-else>
        {{ post.date }}
      </p>

      <!-- Contenu -->
      <p class="text-gray-800 leading-relaxed mb-4">
        {{ post.content }}
      </p>

      <!-- Stats -->
      <PostStats :likes="post.likes" :comments="post.comments" class="mb-4" />

      <!-- Tags -->
      <div class="mt-4 flex flex-wrap gap-2">
        <TagBadge v-for="tag in post.tags" :key="tag" :label="tag" />
      </div>
    </div>

    <div v-else>
      <p class="text-red-500">Post not found.</p>
    </div>
  </div>
</template>
