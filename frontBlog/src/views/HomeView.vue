<script setup lang="ts">
import PostCard from "@/components/PostCard.vue";
import BottomNav from "@/components/Navigation/BottomNav.vue";

interface Post {
  id: number;
  title: string;
  content: string;
  date: string;
  likes: number;
  comments: number;
  author: string;
  tags: string[];
}

const posts: Post[] = [
  {
    id: 1,
    title: "15 Disadvantages Of Freedom And How You Can Workaround It.",
    content:
      "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
    date: "27 MAY 2022",
    likes: 12,
    comments: 7,
    author: "@samurai2099",
    tags: ["#mentalpeace", "#ludens"],
  },
  {
    id: 2,
    title: "The Death of Democracy.",
    content:
      "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
    date: "25 MAY 2022",
    likes: 8,
    comments: 3,
    author: "@anonymous",
    tags: [],
  },
];
</script>

<template>
  <div class="home px-4 pt-6 pb-20 max-w-md mx-auto font-sans">
    <!-- Header -->
    <h2 class="text-center text-xl font-semibold mb-6 font-sans relative">
      <span class="block w-4 h-1 bg-purple-600 mx-auto mb-1"></span>
      Latest
    </h2>

    <!-- Liste des posts -->
    <PostCard v-for="post in posts" :key="post.id" :post="post" />

    <!-- Barre de navigation mobile -->
    <BottomNav />
  </div>
</template>
