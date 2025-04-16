<script setup lang="ts">
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";
import PostCard from "@/components/PostCard.vue";
import axios from "axios";
import { useAsyncQueue } from "@vueuse/core";

const router = useRouter();
const route = useRoute();

const activeTab = ref("posts");
const isOwnProfile = ref(true);
const isFollowing = ref(false);
const loading = ref(true);

const userProfile = ref({
  username: "",
  bio: "No bio yet",
  avatar: "",
  postsCount: 0,
  followersCount: 0,
  followingCount: 0,
});

interface Post {
  id: number;
  title: string;
  content: string;
  created_at: string;
  likes: number;
  comments: number;
  author: string;
}

const posts = ref<Post[]>([]);

async function fetchCurrentUserId(): Promise<string | null> {
  const token = localStorage.getItem("token");
  if (!token) return null;

  try {
    const response = await fetch("http://localhost:8000/api/user", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    if (response.ok) {
      const data = await response.json();
      return data.id;
    }
  } catch (error) {
    console.error("Failed to fetch current user ID:", error);
  }
  return null;
}

async function fetchUserProfile(userIdOrUsername: string, isId = false) {
  try {
    const endpoint = isId
      ? `http://localhost:8000/api/users/${userIdOrUsername}`
      : `http://localhost:8000/api/users/${userIdOrUsername}`;

    const response = await fetch(endpoint);
    if (response.ok) {
      const data = await response.json();
      userProfile.value = {
        username: data.username,
        bio: data.bio || "No bio yet",
        avatar: data.avatar_url || "",
        postsCount: data.posts || 0,
        followersCount: data.followers || 0,
        followingCount: data.following || 0,
      };
      console.log("User Profile:", userProfile.value);
      console.log("Posts:", posts.value);
      return data;
    }
  } catch (error) {
    console.error("Error fetching user profile:", error);
  }
}
async function fetchUserPosts(userId: string) {
  try {
    const response = await fetch(`http://localhost:8000/api/users/${userId}/posts`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });

    if (!response.ok) throw new Error("Failed to load posts");
    const data = await response.json();

    posts.value = await Promise.all(
  data.map(async (post: any) => {
    const likesList = await fetchpostlikes(post.id); // liste des likes
    return {
      id: post.id,
      title: post.title,
      content: post.content,
      created_at: post.created_at,
      likes: likesList?.length ?? 0,
      comments: post.comments?.length ?? 0,
      author: post.user?.username ?? "",
    };
  })
);
  } catch (error) {
    console.error("Error fetching posts:", error);
  }
}
async function fetchpostlikes(postId: number) {
  try {
    const response = await fetch(`http://localhost:8000/api/posts/${postId}/likes`, {
      headers: {
        Authorization: `Bearer ${localStorage.getItem("token")}`,
      },
    });
    if (response.ok) {
      const data = await response.json();
      console.log("Post Likes:", data.length);
      return data;
    }
  } catch (error) {
    console.error("Error fetching post likes:", error);
  }
}
async function checkFollowStatus(userId: string) {
  const token = localStorage.getItem("token");
  if (!token) return;
  try {
    const response = await fetch(
      `http://localhost:8000/api/users/${userId}/follow-status`,
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );
    if (response.ok) {
      const data = await response.json();
      isFollowing.value = data.is_following;
    }
  } catch (error) {
    console.error("Error checking follow status:", error);
  }
}

async function toggleFollow() {
  const token = localStorage.getItem("token");
  if (!token) return router.push("/login");

  const profileId = route.params.username as string;
  const method = isFollowing.value ? "DELETE" : "POST";

  try {
    const response = await fetch(
      `http://localhost:8000/api/users/${profileId}/follow`,
      {
        method,
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    );
    if (response.ok) {
      isFollowing.value = !isFollowing.value;
      userProfile.value.followersCount += isFollowing.value ? 1 : -1;
    }
  } catch (error) {
    console.error("Error toggling follow:", error);
  }
}

async function logout() {
  const token = localStorage.getItem("token");
  if (!token) {
    localStorage.clear();
    return router.push("/login");
  }

  try {
    await axios.post("/api/logout", {}, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
  } catch (err) {
    console.error("Logout failed:", err);
  }

  localStorage.clear();
  router.push("/login");
}

onMounted(async () => {
  loading.value = true;
  const currentUserId = await fetchCurrentUserId();
  const username = route.params.username as string;

  if (!username || username === userProfile.value.username) {
    isOwnProfile.value = true;
    if (currentUserId) {
      await Promise.all([
        fetchUserProfile(currentUserId, true),
        fetchUserPosts(currentUserId)
      ]);
    }
  } else {
    isOwnProfile.value = false;
    const userData = await fetchUserProfile(username);
    if (userData?.id) {
      await Promise.all([
        fetchUserPosts(userData.id),
        checkFollowStatus(userData.id)
      ]);
    }
  }

  loading.value = false;
});



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

          <span><strong>{{ userProfile.postsCount.length }}</strong> posts</span>
          <span><strong>{{ userProfile.followersCount.length }}</strong> followers</span>
          <span><strong>{{ userProfile.followingCount.length }}</strong> following</span>
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