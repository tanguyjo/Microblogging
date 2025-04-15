<template>
  <div class="min-h-screen flex items-center justify-center bg-white px-6">
    <div class="w-full max-w-sm">
      <h1 class="text-6xl font-title font-bold text-black text-center mb-6">
        New post
      </h1>

      <form @submit.prevent="submitPost" class="space-y-4">
        <input
          v-model="title"
          type="text"
          placeholder="Title"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
        />
        <textarea
          v-model="content"
          rows="5"
          placeholder="Content"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet resize-none"
        ></textarea>
        <input
          v-model="hashtags"
          type="text"
          placeholder="Hashtags (comma separated)"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-darkviolet"
        />  

        <select
          v-model="visibility"
          class="w-full px-4 py-3 border border-darkviolet rounded-sm focus:outline-none focus:ring-2 focus:ring-darkviolet"
        >
          <option value="public">Public</option>
          <option value="private">Private</option>
          <option value="followers">Followers only</option>
        </select>

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
            @click="saveAsDraft"
            class="w-full border-2 border-darkviolet text-darkviolet font-bold py-3 rounded-sm hover:bg-purple-50 transition"
          >
            SAVE AS A DRAFT
          </button>
          <button
            type="button"
            @click="cancel"
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
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const title = ref('')
const content = ref('')
const visibility = ref('public')
const hashtags = ref('')


// Fonction pour récupérer le token depuis localStorage
const getToken = (): string | null => {
  return localStorage.getItem('token')
}

// Fonction principale pour envoyer un post
const submitPost = async () => {
  await sendPost('published')
}

// Brouillon
const saveAsDraft = async () => {
  await sendPost('draft')
}

// Annuler
const cancel = () => {
  title.value = ''
  content.value = ''
  visibility.value = 'public'
  router.push('/') // redirige où tu veux
}

// Envoi vers l'API
const sendPost = async (status: string) => {
  const token = getToken() // On récupère le token depuis localStorage

  if (!token) {
    console.error('Aucun token trouvé dans le localStorage')
    return
  }

  try {
    const response = await fetch('http://localhost:8000/api/posts', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${token}`, // Le token est ajouté ici dans l'en-tête
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify({
        title: title.value,
        content: content.value,
        status: status,
        hashtags: hashtags.value.split(',').map(tag => tag.trim()), // On transforme les hashtags en tableau
        visibility: visibility.value,

      }),
      credentials: 'include', // Pour envoyer les cookies si nécessaire
    })

    if (!response.ok) {
      const error = await response.json()
      console.error('Erreur API :', error)
      return
    }

    const newPost = await response.json()
    console.log('Post créé :', newPost)
    router.push('/') // ou vers un post en particulier
  } catch (err) {
    console.error('Erreur réseau :', err)
  }
}
</script>
