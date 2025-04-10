<template>
  <div class="min-h-screen flex items-center justify-center bg-white px-6">
    <div class="w-full max-w-sm">
      <!-- Titre -->
      <h1 class="text-6xl font-title font-bold text-black text-center mb-6">
        New post
      </h1>

      <!-- Formulaire -->
      <form class="space-y-4">
        <input
          type="text"
          placeholder="Title"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
        />
        <textarea
          rows="5"
          placeholder="Content"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet resize-none"
        ></textarea>
        <input
          type="text"
          placeholder="Hashtags"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
        />

        <!-- Boutons -->
        <div class="space-y-3 pt-2">
          <button
            type="submit"
            class="w-full bg-darkviolet text-white font-bold py-3 rounded-sm hover:bg-purple-700 transition"
          >
            SUBMIT
          </button>
          <button
            type="button"
            class="w-full border-2 border-darkviolet text-darkviolet font-bold py-3 rounded-sm hover:bg-purple-50 transition"
          >
            SAVE AS A DRAFT
          </button>
          <button
            type="button"
            class="w-full border-2 border-darkviolet text-darkviolet font-bold py-3 rounded-sm hover:bg-purple-50 transition"
          >
            CANCEL
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup lang="ts">
// logique à ajouter plus tard
</script>
