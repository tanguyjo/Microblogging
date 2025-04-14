<template>
  <div class="flex items-center text-sm mt-4 font-medium text-gray-800">
    <span>{{ date }}</span>

    <!-- Affiche l’auteur uniquement s’il est non vide -->
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
</script>
