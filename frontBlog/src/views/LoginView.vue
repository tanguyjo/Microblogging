<template>
  <div class="min-h-screen flex items-center justify-center bg-white px-6">
    <div class="w-full max-w-sm">
      <!-- Titre -->
      <h1 class="text-3xl font-bold text-black text-center">Welcome</h1>
      <p class="text-gray-500 text-center mt-1">Let’s log you in quickly</p>

      <!-- Formulaire -->
      <form class="mt-8 space-y-4">
        <input
          type="email"
          placeholder="Enter your email"
          class="w-full px-4 py-3 border border-purple-400 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500"
        />

        <input
          type="password"
          placeholder="Enter your password"
          class="w-full px-4 py-3 border border-purple-400 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500"
        />

        <button
          type="submit"
          class="w-full bg-purple-600 text-white font-bold py-3 rounded-sm hover:bg-purple-700 transition"
        >
          LOGIN
        </button>
      </form>

      <!-- Lien d’inscription -->
      <p class="text-sm text-black text-center mt-6">
        don’t have an account?
        <RouterLink
          to="/signup"
          class="text-purple-600 font-medium hover:underline"
        >
          sign-up
        </RouterLink>
      </p>
    </div>
  </div>
</template>

<script setup lang="ts">
// logique à ajouter plus tard
</script>
