<script setup lang="ts">
import { ref } from "vue";
import { useRouter } from "vue-router";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";
import PostCard from "@/components/PostCard.vue";
import axios from "axios";

const router = useRouter();
const activeTab = ref("posts");

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
    const token = localStorage.getItem('token');
    console.log('Token actuel:', token);

    if (!token) {
      console.error('Aucun token trouvé');
      return;
    }

    const response = await axios.post('/api/logout', {}, {
      headers: {
        'Authorization': `Bearer ${token}`
      }
    });
    
    console.log('Réponse de déconnexion:', response);
    
    // Supprimer le token et les informations utilisateur
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    
    console.log('Redirection vers la page de connexion...');
    router.push('/login');
  } catch (error) {
    console.error('Erreur lors de la déconnexion:', error);
    if (axios.isAxiosError(error)) {
      console.error('Détails de l\'erreur:', {
        status: error.response?.status,
        data: error.response?.data,
        headers: error.response?.headers
      });
    }
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
          S
        </div>

        <!-- Nom + bio -->
        <h1 class="text-xl font-bold mt-4">Somnath Das</h1>
        <p class="text-sm text-gray-600 mt-1">Live, Laugh, Love</p>

        <!-- Stats -->
        <div class="flex justify-center gap-6 mt-4 text-sm">
          <span><strong>356</strong> posts</span>
          <span><strong>1,222</strong> followers</span>
          <span><strong>342</strong> following</span>
        </div>

        <!-- Edit & Logout -->
        <div class="flex justify-center items-center gap-4 mt-4 text-sm">
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
