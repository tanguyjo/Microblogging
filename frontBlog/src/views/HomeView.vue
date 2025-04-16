<script setup lang="ts">
import PostCard from "@/components/PostCard.vue";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";
import SearchPopup from "@/components/SearchPopup.vue";

import { ref, onMounted, computed } from "vue";
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
  likes: number;
  comments: number;
  hashtags?: string[];
}

const posts = ref<Post[]>([]);
const selectedHashtag = ref<string | null>(null);
const availableHashtags = ref<string[]>([]);
const isSearchOpen = ref(false);
const showOnlyFollowing = ref(false);
const followingUsers = ref<string[]>([]);

// Récupérer la liste des utilisateurs suivis
async function fetchFollowingUsers() {
  const token = localStorage.getItem("token");
  if (!token) return;

  try {
    const response = await fetch("http://localhost:8000/api/users/following", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    if (response.ok) {
      const data = await response.json();
      followingUsers.value = data.map((user: any) => user.username);
    }
  } catch (error) {
    console.error("Erreur lors de la récupération des abonnements:", error);
  }
}

// Récupération des posts depuis l'API
onMounted(async () => {
  await fetchFollowingUsers();
  try {
    console.log("Tentative de récupération des posts...");
    const response = await fetch("http://localhost:8000/api/posts");
    console.log("Réponse reçue:", response);

    const data = await response.json();
    console.log("Données reçues:", data);

    // Transformer les données pour correspondre au format attendu par PostCard
    posts.value = data.map((post: Post) => {
      console.log("Traitement du post:", post);
      return {
        id: post.id,
        title: post.title,
        content: post.content,
        created_at: post.created_at,
        likes: post.likes,
        comments: post.comments,
        author: post.author || "",
        hashtags: post.hashtags || [],
      };
    });

    // Extraire tous les hashtags uniques
    const allHashtags = new Set<string>();
    posts.value.forEach(post => {
      if (post.hashtags) {
        post.hashtags.forEach(tag => allHashtags.add(tag));
      }
    });
    availableHashtags.value = Array.from(allHashtags);

    console.log("Posts transformés:", posts.value);
  } catch (error) {
    console.error("Erreur de chargement :", error);
  }
});

// Filtrer les posts par hashtag et par abonnements
const filteredPosts = computed(() => {
  let filtered = posts.value;
  
  // Filtrer par hashtag si sélectionné
  if (selectedHashtag.value) {
    filtered = filtered.filter(post => 
      post.hashtags?.includes(selectedHashtag.value!)
    );
  }
  
  // Filtrer par abonnements si activé
  if (showOnlyFollowing.value) {
    console.log('Filtering by following users...');
    filtered = filtered.filter(post => {
      const isFollowing = followingUsers.value.includes(post.author);
      console.log(`Post author: ${post.author}, Is following: ${isFollowing}`);
      return isFollowing;
    });
  }
  
  console.log('Filtered posts count:', filtered.length);
  return filtered;
});

function handleHashtagSelect(hashtag: string | null) {
  selectedHashtag.value = hashtag;
  isSearchOpen.value = false;
}

function toggleFollowingPosts() {
  console.log('Toggle following posts, current state:', showOnlyFollowing.value);
  showOnlyFollowing.value = !showOnlyFollowing.value;
  console.log('New state:', showOnlyFollowing.value);
  console.log('Following users:', followingUsers.value);
}

function formatDateTime(dateString: string, mode: "full" | "short" = "full"): string {
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
    <SideNav 
      class="hidden md:block w-20 shrink-0"
      @search-click="isSearchOpen = true"
      @for-me-click="toggleFollowingPosts"
    />

    <!-- Contenu principal -->
    <main class="w-full px-4 pt-6 pb-20 max-w-4xl mx-auto font-sans">
      <!-- Header -->
      <h2 class="text-center text-xl font-semibold mb-6 font-sans relative text-black">
        <span class="block w-4 h-1 bg-purple-600 mx-auto mb-1"></span>
        <span v-if="showOnlyFollowing">Following Feed</span>
        <span v-else>{{ selectedHashtag ? `#${selectedHashtag}` : 'Latest' }}</span>
      </h2>

      <!-- Liste des posts -->
      <PostCard v-for="post in filteredPosts" :key="post.id" :post="post" />
    </main>
  </div>

  <!-- BottomNav (Mobile uniquement) -->
  <BottomNav 
    class="block md:hidden"
    @search-click="isSearchOpen = true"
    @for-me-click="toggleFollowingPosts"
  />

  <!-- Search Popup -->
  <SearchPopup
    :is-open="isSearchOpen"
    :selected-hashtag="selectedHashtag"
    :available-hashtags="availableHashtags"
    @close="isSearchOpen = false"
    @select="handleHashtagSelect"
  />
</template>
