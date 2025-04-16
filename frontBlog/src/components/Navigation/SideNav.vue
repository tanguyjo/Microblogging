<script setup lang="ts">
import { RouterLink } from 'vue-router';
import { ref, onMounted } from 'vue';

const emit = defineEmits<{
  (e: 'search-click'): void;
}>();

const userProfile = ref({
  username: localStorage.getItem('username') || "",
  bio: "No bio yet",
  avatar: "",
  postsCount: 0,
  followersCount: 0,
  followingCount: 0,
});

async function fetchUserProfile() {
  const token = localStorage.getItem("token");
  if (!token) return;

  try {
    const response = await fetch("http://localhost:8000/api/user", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    
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
    }
  } catch (error) {
    console.error("Error fetching user profile:", error);
  }
}

onMounted(() => {
  fetchUserProfile();
});
</script>

<template>
  <aside
    class="hidden md:fixed md:inset-y-0 md:left-0 md:w-24 bg-white border-r border-darkviolet flex flex-col items-center py-6 space-y-6"
  >
  
    <!-- Avatar -->
    <RouterLink
      to="/profile"
      class="flex flex-col items-center gap-1 text-xs text-darkviolet bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <div
        class="w-10 h-10 rounded-full bg-darkviolet text-white font-title flex items-center justify-center font-bold text-lg"
      >
        {{ userProfile.username.charAt(0).toUpperCase() }}
      </div>
      <span>Profile</span>
    </RouterLink>

    <!-- Icône : Home -->
    <RouterLink
      to="/"
      class="flex flex-col items-center gap-1 text-xs text-darkviolet bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-6 h-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="1.5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
        />
      </svg>
      <span>Home</span>
    </RouterLink>

    <!-- Icône : Search -->
    <button
      @click="emit('search-click')"
      class="flex flex-col items-center gap-1 text-xs text-darkviolet bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent w-full"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-6 h-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="1.5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
        />
      </svg>
      <span>Search</span>
    </button>

    <!-- Icône : Create -->
    <RouterLink
      to="/newpost"
      class="flex flex-col items-center gap-1 text-xs text-darkviolet font-bold bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-6 h-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="1.5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
        />
      </svg>
      <span>Create</span>
    </RouterLink>

    <!-- Icône : For Me -->
    <button
      class="flex flex-col items-center gap-1 text-xs text-darkviolet bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-6 h-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="1.5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
        />
      </svg>
      <span>For me</span>
    </button>
  </aside>
</template>
