<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";
import PostCard from "@/components/PostCard.vue";
import axios from "axios";

const router = useRouter();
const route = useRoute();
const activeTab = ref("posts");
const isOwnProfile = ref(true);
const isFollowing = ref(false);
const userProfile = ref({
  username: "",
  bio: "",
  avatar: "",
  postsCount: 0,
  followersCount: 0,
  followingCount: 0,
});

function getUsernameFromParams(params: any): string | null {
  if (typeof params.username === 'string') {
    return params.username;
  }
  if (Array.isArray(params.username) && params.username.length > 0) {
    return params.username[0];
  }
  return null;
}

async function checkFollowStatus(username: string | string[]) {
  try {
    const token = localStorage.getItem('token');
    if (!token) return;

    const usernameStr = Array.isArray(username) ? username[0] : username;
    if (!usernameStr) return;

    const response = await fetch(`http://localhost:8000/api/users/${usernameStr}/follow-status`, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    
    if (response.ok) {
      const data = await response.json();
      isFollowing.value = data.is_following;
    }
  } catch (error) {
    console.error("Error checking follow status:", error);
  }
}

async function toggleFollow() {
  try {
    const token = localStorage.getItem('token');
    if (!token) {
      router.push('/login');
      return;
    }

    const username = getUsernameFromParams(route.params);
    if (!username) return;
    
    const method = isFollowing.value ? 'DELETE' : 'POST';
    
    const response = await fetch(`http://localhost:8000/api/users/${username}/follow`, {
      method,
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });

    if (response.ok) {
      isFollowing.value = !isFollowing.value;
      // Mettre à jour le nombre de followers
      userProfile.value.followersCount += isFollowing.value ? 1 : -1;
    }
  } catch (error) {
    console.error("Error toggling follow status:", error);
  }
}

onMounted(async () => {
  const username = route.params.username;
  if (username) {
    isOwnProfile.value = false;
    try {
      const response = await fetch(`http://localhost:8000/api/users/${username}`);
      if (response.ok) {
        const data = await response.json();
        userProfile.value = {
          username: data.username,
          bio: data.bio || "No bio yet",
          avatar: data.avatar_url || "",
          postsCount: data.posts_count || 0,
          followersCount: data.followers_count || 0,
          followingCount: data.following_count || 0,
        };
        await checkFollowStatus(username);
      }
    } catch (error) {
      console.error("Error fetching user profile:", error);
    }
  } else {
    // Si pas de username dans l'URL, c'est le profil de l'utilisateur connecté
    const currentUsername = localStorage.getItem("username");
    if (currentUsername) {
      userProfile.value.username = currentUsername;
    }
  }
});

const posts = [
  {
    id: 1,
    title: "15 Disadvantages Of Freedom And How You Can Workaround It.",
    content:
      "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua...",
    date: "2022-05-27T00:00:00.000000Z",
    likes: 352,
    comments: 288,
    author: "",
    tags: ["#mentalpeace", "#ludens"],
  },
  {
    id: 2,
    title: "Another Reflection On Digital Minimalism.",
    content:
      "Digital minimalism is a philosophy of technology use. Lorem ipsum dolor sit amet, consectetur adipiscing elit...",
    date: "2022-05-26T00:00:00.000000Z",
    likes: 198,
    comments: 63,
    author: "",
    tags: ["#focus", "#mindfulness"],
  },
];

async function logout() {
  try {
    console.log('Début de la déconnexion...');
    const token = localStorage.getItem('token');
    console.log('Token actuel:', token);

    if (!token) {
      console.error('Aucun token trouvé');
      // Même sans token, on redirige vers la page de login
      localStorage.clear(); // On nettoie tout le localStorage par sécurité
      router.push('/login');
      return;
    }

    try {
      console.log('Envoi de la requête de déconnexion...');
      const response = await axios.post('/api/logout', {}, {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        }
      });
      
      console.log('Réponse de déconnexion:', response);
    } catch (apiError) {
      console.error('Erreur API lors de la déconnexion:', apiError);
      // On continue le processus même si l'API échoue
    }
    
    // Dans tous les cas, on nettoie le localStorage et on redirige
    console.log('Nettoyage du localStorage...');
    localStorage.clear(); // On nettoie tout le localStorage
    
    console.log('Redirection vers la page de connexion...');
    await router.push('/login');
  } catch (error) {
    console.error('Erreur globale lors de la déconnexion:', error);
    if (axios.isAxiosError(error)) {
      console.error('Détails de l\'erreur:', {
        status: error.response?.status,
        data: error.response?.data,
        headers: error.response?.headers
      });
    }
    // Même en cas d'erreur, on essaie de rediriger
    localStorage.clear();
    router.push('/login');
  }
}
</script>

<template>
  <div class="md:flex">
    <!-- SideNav -->
    <SideNav class="hidden md:block w-20 shrink-0" />

    <!-- Main content -->
    <main class="w-full px-4 pt-6 pb-20 max-w-4xl mx-auto font-sans relative">
      <!-- Profile Header -->
      <section class="text-center mb-4">
        <!-- Avatar -->
        <div
          class="w-24 h-24 mx-auto rounded-full bg-darkviolet text-white font-title flex items-center justify-center text-3xl font-bold"
        >
          {{ userProfile.username.charAt(0).toUpperCase() }}
        </div>

        <!-- Nom + bio -->
        <h1 class="text-xl font-bold mt-4">{{ userProfile.username }}</h1>
        <p class="text-sm text-gray-600 mt-1">{{ userProfile.bio }}</p>

        <!-- Stats -->
        <div class="flex justify-center gap-6 mt-4 text-sm">
          <span><strong>{{ userProfile.postsCount }}</strong> posts</span>
          <span><strong>{{ userProfile.followersCount }}</strong> followers</span>
          <span><strong>{{ userProfile.followingCount }}</strong> following</span>
        </div>

        <!-- Edit & Logout (uniquement sur son propre profil) -->
        <div v-if="isOwnProfile" class="flex justify-center items-center gap-4 mt-4 text-sm">
          <RouterLink
            to="/edit-profile"
            class="text-darkviolet font-medium hover:underline"
          >
            Edit Profile
          </RouterLink>
          <button
            @click="logout"
            class="text-red-500 font-medium hover:underline bg-transparent border-none p-0"
          >
            Log out
          </button>
        </div>

        <!-- Follow/Unfollow button (uniquement sur le profil des autres) -->
        <div v-else class="flex justify-center mt-4">
          <button
            @click="toggleFollow"
            class="px-4 py-2 rounded-full text-sm font-medium"
            :class="isFollowing ? 'bg-gray-200 text-gray-800' : 'bg-darkviolet text-white'"
          >
            {{ isFollowing ? 'Unfollow' : 'Follow' }}
          </button>
        </div>
      </section>

      <!-- Onglets -->
      <div class="sticky top-0 bg-white z-10">
        <div class="border-t border-black"></div>

        <div class="relative h-12">
          <div
            class="flex justify-around text-xs font-bold tracking-wide h-full bg-transparent"
          >
            <button
              @click="activeTab = 'posts'"
              class="flex flex-col items-center min-w-[90px] text-center bg-transparent"
            >
              <div
                class="w-2.5 h-2.5 rounded-full bg-darkviolet mb-2 -mt-3.5 transition-opacity duration-200"
                :class="{
                  'opacity-100': activeTab === 'posts',
                  'opacity-0': activeTab !== 'posts',
                }"
              ></div>
              <span
                class="text-sm"
                :class="activeTab === 'posts' ? 'text-black' : 'text-gray-500'"
              >
                POSTS
              </span>
            </button>

            <button
              @click="activeTab = 'followers'"
              class="flex flex-col items-center min-w-[90px] text-center bg-transparent"
            >
              <div
                class="w-2.5 h-2.5 rounded-full bg-darkviolet mb-2 -mt-3.5 transition-opacity duration-200"
                :class="{
                  'opacity-100': activeTab === 'followers',
                  'opacity-0': activeTab !== 'followers',
                }"
              ></div>
              <span
                class="text-sm"
                :class="
                  activeTab === 'followers' ? 'text-black' : 'text-gray-500'
                "
              >
                FOLLOWERS
              </span>
            </button>

            <button
              @click="activeTab = 'following'"
              class="flex flex-col items-center min-w-[90px] text-center bg-transparent"
            >
              <div
                class="w-2.5 h-2.5 rounded-full bg-darkviolet mb-2 -mt-3.5 transition-opacity duration-200"
                :class="{
                  'opacity-100': activeTab === 'following',
                  'opacity-0': activeTab !== 'following',
                }"
              ></div>
              <span
                class="text-sm"
                :class="
                  activeTab === 'following' ? 'text-black' : 'text-gray-500'
                "
              >
                FOLLOWING
              </span>
            </button>
          </div>
        </div>
      </div>

      <!-- Onglet actif -->
      <section class="mt-6">
        <div v-if="activeTab === 'posts'" class="space-y-8">
          <PostCard v-for="post in posts" :key="post.id" :post="post" />
        </div>

        <div
          v-else-if="activeTab === 'followers'"
          class="text-center text-gray-500 py-12"
        >
          <p>You have no followers yet.</p>
        </div>

        <div
          v-else-if="activeTab === 'following'"
          class="text-center text-gray-500 py-12"
        >
          <p>You're not following anyone yet.</p>
        </div>
      </section>
    </main>
  </div>

  <!-- BottomNav -->
  <BottomNav class="block md:hidden" />
</template>
