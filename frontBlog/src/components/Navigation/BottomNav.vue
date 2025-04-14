<template>
  <nav
    class="fixed bottom-4 left-4 right-4 mx-auto max-w-md bg-white border border-darkviolet px-4 py-2 flex justify-around items-center shadow-lg"
  >
    <!-- Icône : Compte -->
    <RouterLink
      to="/profile"
      aria-label="Account"
      class="p-1 bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <div
        class="w-8 h-8 rounded-full bg-darkviolet text-white font-title flex items-center justify-center font-bold text-lg"
      >
        S
      </div>
    </RouterLink>

    <!-- Icône : accueil -->
    <RouterLink
      to="/"
      aria-label="Home"
      class="p-2 bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-7 h-7 text-darkviolet"
        fill="none"
        viewBox="0 0 24 24"
        stroke="darkviolet"
        stroke-width="1.5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
        />
      </svg>
    </RouterLink>

    <!-- Icône : recherche -->
    <button
      aria-label="Search"
      class="p-2 bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-7 h-7 text-darkviolet"
        fill="none"
        viewBox="0 0 24 24"
        stroke="darkviolet"
        stroke-width="1.5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"
        />
      </svg>
    </button>

    <!-- Icône : Créer -->
    <RouterLink
      to="/newpost"
      aria-label="Create"
      class="p-2 bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-7 h-7 text-darkviolet"
        fill="none"
        viewBox="0 0 24 24"
        stroke="darkviolet"
        stroke-width="1.5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
        />
      </svg>
    </RouterLink>

    <!-- Icône : Pour moi -->
    <button
      aria-label="For me"
      class="p-2 bg-transparent hover:bg-transparent focus:bg-transparent active:bg-transparent"
    >
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="w-7 h-7 text-darkviolet"
        fill="none"
        viewBox="0 0 24 24"
        stroke="darkviolet"
        stroke-width="1.5"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"
        />
      </svg>
    </button>
  </nav>
</template>

<script setup lang="ts">
import { RouterLink } from 'vue-router';
</script>
