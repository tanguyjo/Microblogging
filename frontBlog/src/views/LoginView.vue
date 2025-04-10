<template>
  <div class="min-h-screen flex items-center justify-center bg-white px-6">
    <div class="w-full max-w-sm">
      <!-- Titre -->
      <h1 class="text-3xl font-bold text-black text-center">Welcome</h1>
      <p class="text-gray-500 text-center mt-1">Let's log you in quickly</p>

      <!-- Message d'erreur -->
      <div v-if="error" class="mt-4 p-3 bg-red-100 text-red-700 rounded-sm">
        {{ error }}
      </div>

      <!-- Formulaire -->
      <form @submit.prevent="handleLogin" class="mt-8 space-y-4">
        <input
          v-model="form.email"
          type="email"
          placeholder="Enter your email"
          class="w-full px-4 py-3 border border-purple-400 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500"
          required
        />

        <input
          v-model="form.password"
          type="password"
          placeholder="Enter your password"
          class="w-full px-4 py-3 border border-purple-400 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500"
          required
        />

        <button
          type="submit"
          class="w-full bg-purple-600 text-white font-bold py-3 rounded-sm hover:bg-purple-700 transition disabled:opacity-50"
          :disabled="loading"
        >
          {{ loading ? 'Loading...' : 'LOGIN' }}
        </button>
      </form>

      <!-- Lien d'inscription -->
      <p class="text-sm text-black text-center mt-6">
        don't have an account?
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
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const loading = ref(false)
const error = ref('')

const form = ref({
  email: '',
  password: ''
})

const handleLogin = async () => {
  try {
    loading.value = true
    error.value = ''

    const response = await axios.post('http://localhost:8000/api/login', form.value)
    
    // Stocker le token dans le localStorage
    localStorage.setItem('token', response.data.token)
    
    // Rediriger vers la page d'accueil
    router.push('/')
  } catch (err: any) {
    error.value = err.response?.data?.message || 'An error occurred during login'
  } finally {
    loading.value = false
  }
}
</script>
