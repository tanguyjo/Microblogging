<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const postId = Number(route.params.id);
// Variables pour la gestion de l'état
const post = ref<Post | null>(null);
const isLoading = ref(true);
const error = ref<string | null>(null);


// Pour l'exemple : on pourrait remplacer ça par un fetch API plus tard
// const posts = [
//   {
//     id: 1,
//     title: "15 Disadvantages Of Freedom And How You Can Workaround It.",
//     content:
//       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
//     date: "27/05/22",
//     likes: 12,
//     comments: 7,
//     author: "samurai2099",
//     tags: ["#mentalpeace", "#ludens"],
//   },
//   {
//     id: 2,
//     title: "The Death of Democracy.",
//     content:
//       "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
//     date: "25/05/22",
//     likes: 8,
//     comments: 3,
//     author: "anonymous",
//     tags: ["#anarchy", "#silence"],
//   },
// ];

interface Post {
  id: number;
  user_id: number;
  title: string;
  content: string;
  status: string;
  visibility: string;
  created_at: string;
  updated_at: string;
}

onMounted(async () => {
  try {
    const response = await fetch(`http://localhost:8000/api/posts/${postId}`);
    if (!response.ok) {
      throw new Error("Post not found");
    }
    post.value = await response.json();
  } catch (err) {
    error.value = err instanceof Error ? err.message : "Une erreur est survenue.";
  } finally {
    isLoading.value = false;
  }
});

const cleanDate = (date: string) => {
  return date.replace(/(\.\d+|Z)$/, '').replace('T', ' ');
};
</script>

<template>
  <div class="max-w-3xl mx-auto px-4 pt-8 pb-16">
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
      <h1 class="text-2xl font-bold text-purple-600 mb-4">{{ post.title }}</h1>
      <p class="text-sm text-gray-600 mb-2">
        {{ cleanDate(post.created_at) }} — @{{ post.user_id }}
      </p>
      <p class="text-gray-800 leading-relaxed mb-4">{{ post.content }}</p>

      <div class="flex gap-4 text-purple-600">
        <span>♡ {{ post.likes || 0 }}</span>
        <span>💬 {{ post.comments || 0}}</span>
      </div>

      <div class="mt-4 flex flex-wrap gap-2">
        <span
          v-for="tag in post.tags"
          :key="tag"
          class="border border-purple-500 text-purple-600 px-2 py-1 text-sm rounded-full"
        >
          {{ tag }}
        </span>
      </div>
    </div>

    <div v-else>
      <p class="text-red-500">Post not found.</p>
    </div>
  </div>
</template>
