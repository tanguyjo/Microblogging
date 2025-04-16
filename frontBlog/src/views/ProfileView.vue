<script setup lang="ts">
import { ref,onMounted } from "vue";
import { useRouter,useRoute } from "vue-router";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";
import PostCard from "@/components/PostCard.vue";
import axios from "axios";

const router = useRouter();
const route = useRoute();
const activeTab = ref("posts");
const isOwnProfile = ref(true);

const user = ref<any>(null); // Utilisateur connecté
const followers = ref([]);
const following = ref([]);

async function logout() {
  try {
    const username = route.params.username;
  if (username) {
    
    isOwnProfile.value = false;
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
}
const posts = ref<Post[]>([]);

onMounted(async () => {
  try {
    // Étape 1 : Récupérer l'utilisateur connecté
    const userResponse = await fetch("http://localhost:8000/api/user", {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });

    if (!userResponse.ok) throw new Error("Utilisateur non connecté");

    const userData = await userResponse.json();
    const userId = userData.id;

    console.log("Utilisateur connecté ID :", userId);

    // Étape 2 : Récupérer uniquement ses posts
    const postsResponse = await fetch(`http://localhost:8000/api/users/${userId}/posts`, {
      method: "GET",
      headers: {
        "Content-Type": "application/json",
        Accept: "application/json",
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });

    if (!postsResponse.ok) throw new Error("Erreur de récupération des posts");

    const data = await postsResponse.json();
    console.log("Posts récupérés:", data);

    posts.value = data.map((post: Post) => ({
      id: post.id,
      title: post.title,
      content: post.content,
      date: post.created_at,
      likes: post.likes || 0,
      comments: post.comments.length || 0,
      author: post.user.username || "",
      tags: [],
    }));
  } catch (error) {
    console.error("Erreur lors du chargement des posts utilisateur:", error);
  }
});

onMounted(async () => {
  try {
    const token = localStorage.getItem("token");
    const userResponse = await fetch("http://localhost:8000/api/user", {
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    });

    if (!userResponse.ok) throw new Error("Non authentifié");
    const userData = await userResponse.json();

    const fullResponse = await fetch(`http://localhost:8000/api/users/${userData.id}`, {
      headers: {
        Authorization: `Bearer ${token}`,
        "Content-Type": "application/json",
        Accept: "application/json",
      },
    });

    if (!fullResponse.ok) throw new Error("Erreur récupération utilisateur complet");

    const fullUser = await fullResponse.json();
    user.value = fullUser;
    posts.value = fullUser.posts || [];
    console.log("Utilisateur complet récupéré:", fullUser);
    followers.value = fullUser.followers || [];
    following.value = fullUser.following || [];
  } catch (err) {
    console.error("Erreur de récupération de l'utilisateur :", err);
  }
});

console.log(posts); // Vérification de la récupération des posts
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
          <span>{{ user.username.charAt(0).toUpperCase() }}</span>
        </div>

        <!-- Nom + bio -->
        <h1 class="text-xl font-bold mt-4">{{ user.username }}</h1>
        <p class="text-sm text-gray-600 mt-1">{{ user.bio }}</p>

        <!-- Stats -->
        <div class="flex justify-center gap-6 mt-4 text-sm">
          <span><strong>{{ posts.length }}</strong> posts</span>
          <span><strong>{{ followers.length }}</strong> followers</span>
          <span><strong>{{ following.length }}</strong> following</span>
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
