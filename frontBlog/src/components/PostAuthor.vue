<template>
  <div class="flex items-center text-sm mt-4 font-medium text-gray-800">
    <span>{{ formatDateTime(date) }}</span>

    <!-- Affiche l'auteur uniquement s'il est non vide -->
    <span v-if="author?.trim()" class="ml-auto text-gray-600">
      @{{ author }}
    </span>
  </div>
</template>

<script lang="ts" setup>
defineProps<{
  date: string;
  author?: string;
}>();

function formatDateTime(dateString: string): string {
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
