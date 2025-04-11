<script setup lang="ts">
import PostCard from "@/components/PostCard.vue";
import BottomNav from "@/components/Navigation/BottomNav.vue";
import SideNav from "@/components/Navigation/SideNav.vue";
// import PostContent from "@/components/PostContent.vue"; // Pour vérification du composant

interface Post {
  id: number;
  title: string;
  content: string;
  date: string;
  likes: number;
  comments: number;
  author: string;
  tags: string[];
}

const posts: Post[] = [
  {
    id: 1,
    title: "15 Disadvantages Of Freedom And How You Can Workaround It.",
    content:
      "Ut tellus elementum sagittis vitae et leo. Cursus in hac habitasse platea dictumst quisque sagittis purus. Odio facilisis mauris sit amet. Quis vel eros donec ac odio. Orci a scelerisque purus semper. Amet justo donec enim diam vulputate ut pharetra. Arcu odio ut sem nulla pharetra diam sit amet nisl. Sapien eget mi proin sed libero enim. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Neque viverra justo nec ultrices dui sapien eget mi.",
    date: "27/05/22",
    likes: 12,
    comments: 7,
    author: "samurai2099",
    tags: ["#mentalpeace", "#ludens"],
  },
  {
    id: 2,
    title: "The Death of Democracy.",
    content:
      "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Luctus venenatis lectus magna fringilla urna. Aliquet porttitor lacus luctus accumsan tortor posuere ac ut. Eleifend quam adipiscing vitae proin sagittis nisl rhoncus. Faucibus ornare suspendisse sed nisi lacus sed viverra tellus. Urna molestie at elementum eu facilisis sed odio morbi. Eget mi proin sed libero enim. Quis varius quam quisque id diam vel quam. Duis at tellus at urna condimentum mattis pellentesque. Nulla facilisi cras fermentum odio eu feugiat pretium nibh. Ut tellus elementum sagittis vitae et leo. Cursus in hac habitasse platea dictumst quisque sagittis purus. Odio facilisis mauris sit amet. Quis vel eros donec ac odio. Orci a scelerisque purus semper. Amet justo donec enim diam vulputate ut pharetra. Arcu odio ut sem nulla pharetra diam sit amet nisl. Sapien eget mi proin sed libero enim. Nunc sed blandit libero volutpat sed cras ornare arcu dui. Neque viverra justo nec ultrices dui sapien eget mi.",
    date: "25/05/22",
    likes: 8,
    comments: 3,
    author: "anonymous",
    tags: ["#anarchy", "#silence"],
  },
];
</script>

<template>
  <div class="md:flex">
    <!-- SideNav (Desktop uniquement) -->
    <SideNav class="hidden md:block w-20 shrink-0" />

    <!-- Contenu principal -->
    <main class="w-full px-4 pt-6 pb-20 max-w-4xl mx-auto font-sans">
      <!-- Header -->
      <h2
        class="text-center text-xl font-semibold mb-6 font-sans relative text-black"
      >
        <span class="block w-4 h-1 bg-purple-600 mx-auto mb-1"></span>
        Latest
      </h2>

      <!-- Liste des posts -->
      <PostCard
        v-for="post in posts"
        :key="post.id"
        :post="{
          ...post,
          preview: post.content.slice(0, 200),
          postId: post.id,
        }"
      />
    </main>
  </div>

  <!-- BottomNav (Mobile uniquement) -->
  <BottomNav class="block md:hidden" />
</template>
