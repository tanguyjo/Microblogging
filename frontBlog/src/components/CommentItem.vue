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
  const d = new Date(dateString);
  const day = d.getDate().toString().padStart(2, "0");
  const month = (d.getMonth() + 1).toString().padStart(2, "0");
  const year = d.getFullYear();
  const hours = d.getHours().toString().padStart(2, "0");
  const minutes = d.getMinutes().toString().padStart(2, "0");

  return `${day}/${month}/${year} ${hours}:${minutes}`;
}
</script>
