<template>
  <div class="min-h-screen flex items-center justify-center bg-white px-6">
    <div class="w-full max-w-sm">
      <!-- Titre -->
      <h1 class="text-6xl font-title font-bold text-black text-center">
        Welcome
      </h1>
      <p class="text-gray-500 text-center mt-1">Let’s sign you up quickly</p>

      <!-- Formulaire -->
      <form class="mt-8 space-y-4">
        <input
          type="name"
          placeholder="Enter your name"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
        />
        <input
          type="email"
          placeholder="Enter your email"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
        />

        <input
          type="password"
          placeholder="Enter your password"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
        />
        <input
          type="confirm-password"
          placeholder="Confirm password"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
        />

        <button
          type="submit"
          class="w-full bg-darkviolet text-white font-bold py-3 rounded-sm hover:bg-purple-700 transition"
        >
          SUBMIT
        </button>
      </form>

      <!-- Lien d’inscription -->
      <p class="text-sm text-black text-center mt-6">
        Already have an account?
        <RouterLink
          to="/login"
          class="text-darkviolet font-medium hover:underline"
        >
          Log in
        </RouterLink>
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
// logique à ajouter plus tard
</script>
