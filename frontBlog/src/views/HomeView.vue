<script setup lang="ts">
import PostCard from "@/components/PostCard.vue";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";

import { ref, onMounted } from "vue";
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
  author: string;
  
}
const posts = ref<Post[]>([]);

// Récupération des posts depuis l'API
onMounted(async () => {
  try {
    console.log('Tentative de récupération des posts...');
    const response = await fetch("http://localhost:8000/api/posts");
    console.log('Réponse reçue:', response);
    
    const data = await response.json();
    console.log('Données reçues:', data);
    
    // Transformer les données pour correspondre au format attendu par PostCard
    posts.value = data.map((post: Post) => {
      console.log('Traitement du post:', post);
      return {
        id: post.id,
        title: post.title,
        content: post.content,
        date: formatDateTime(post.created_at, 'short'),
        likes: 0,
        comments: 0,
        author: post.author || '',
        tags: [],
      };
    });
    
    console.log('Posts transformés:', posts.value);
  } catch (error) {
    console.error("Erreur de chargement :", error);
  }
});

console.log(posts); // Vérification de la récupération des posts

function formatDateTime(dateString: string, mode: 'full' | 'short' = 'full'): string {
  const date = new Date(dateString);

  if (isNaN(date.getTime())) {
    console.error('Date invalide:', dateString);
    return 'Date invalide';
  }

  return new Intl.DateTimeFormat('fr-FR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: false,
  }).format(date);
}

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
        :post="post"
      />
    </main>
  </div>

  <!-- BottomNav (Mobile uniquement) -->
  <BottomNav class="block md:hidden" />
</template>
