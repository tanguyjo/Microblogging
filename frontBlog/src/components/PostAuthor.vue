<template>
  <div class="flex items-center text-sm mt-4 font-medium text-gray-800">
    <span>{{ formatDateTime(created_at) }}</span>

    <!-- Affiche l'auteur uniquement s'il est non vide -->
    <span v-if="author?.trim()" class="ml-auto text-gray-600">
      <button 
        @click="goToProfile(author)" 
        class="bg-transparent border-none p-0"
      >
        @{{ author }}
      </button>
    </span>
  </div>
</template>

<script lang="ts" setup>
import { useRouter } from "vue-router";

const router = useRouter();

defineProps<{
  created_at: string;
  author?: string;
}>();

function formatDateTime(dateString: string): string {
  if (!dateString?.trim()) {
    console.log('Date string is empty or undefined');
    return 'Date non disponible';
  }

  console.log('Received date string:', dateString);
  const date = new Date(dateString);
  console.log('Parsed date object:', date);

  if (isNaN(date.getTime())) {
    console.error('Invalid date string format:', dateString);
    return 'Date invalide';
  }

  const day = date.getDate().toString().padStart(2, '0');
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const year = date.getFullYear();
  const hours = date.getHours().toString().padStart(2, '0');
  const minutes = date.getMinutes().toString().padStart(2, '0');

  return `${day}/${month}/${year} ${hours}:${minutes}`;
}

function goToProfile(username: string) {
  const currentUsername = localStorage.getItem('username');
  if (username === currentUsername) {
    router.push('/profile');
  } else {
    router.push(`/user/${username}`);
  }
}
</script>
