<template>
  <div class="mb-6 border-b pb-4">
    <p class="text-sm text-gray-600 mb-1">
      <span class="font-semibold text-purple-600">{{ comment.author }}</span> —
      {{ formatDate(comment.created_at) }}
    </p>
    <p class="text-gray-800">{{ comment.content }}</p>
  </div>
</template>

<script setup>
defineProps({
  comment: {
    type: Object,
    required: true,
  },
});

function formatDate(dateString) {
  const date = new Date(dateString);
  return date.toLocaleDateString("fr-FR", {
    day: "2-digit",
    month: "long",
    year: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
}
</script>
