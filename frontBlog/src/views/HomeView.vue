<script setup lang="ts">
import PostCard from "@/components/PostCard.vue";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";

import { ref, onMounted } from "vue";
import PostContent from "@/components/PostContent.vue"; // Pour vérification du composant

// import PostContent from "@/components/PostContent.vue"; // Pour vérification du composant

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
const posts = ref<Post[]>([]);

// Récupération des posts depuis l'API
onMounted(async () => {
  try {
    const response = await fetch("http://localhost:8000/api/posts");
    posts.value = await response.json();
  } catch (error) {
    console.error("Erreur de chargement :", error);
  }
});

console.log(posts); // Vérification de la récupération des posts

</script>

<template>
  

  <div class="md:flex">
    <!-- SideNav (Desktop uniquement) -->
    <SideNav class="hidden md:block w-20 shrink-0" />

    <!-- Contenu principal -->
    <main class="w-full px-4 pt-6 pb-20 max-w-4xl mx-auto font-sans">
      <!-- Header -->
      <h2
        class="text-center text-xl font-semibold mb-6 font-sans relative text-black"
      >
        <span class="block w-4 h-1 bg-purple-600 mx-auto mb-1"></span>
        Latest
      </h2>

      <!-- Liste des posts -->
      <PostCard
        v-for="post in posts"
        :key="post.id"
        :post="{
          id: post.id,
          title: post.title,
          content: post.content,
          date: post.created_at,
          likes: 0,
          comments: 0,
          author: post.user_id,
          tags: [],
        }"
      />
    </main>
  </div>

  <!-- BottomNav (Mobile uniquement) -->
  <BottomNav class="block md:hidden" />
</template>
