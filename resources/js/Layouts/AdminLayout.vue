<script setup>
import { onMounted, ref } from 'vue'
import Header from '@/Components/Layout/Header.vue'
import Sidebar from '@/Components/Layout/Sidebar.vue'
// Sidebar toggle state
const sidebarOpen = ref(false)



// Run jQuery admin theme scripts after Vue mounts
onMounted(() => {
  // Give DOM time to render then init admin script
  setTimeout(() => {
    if (window.YashAdmin && typeof window.YashAdmin.init === 'function') {
      window.YashAdmin.init()
    }
  }, 200)
})
</script>

<template>
  <div id="main-wrapper">

    <!-- Top logo bar / toggle -->
    

    <Header />
    <Sidebar />

    <!-- Page content -->
    <div class="content-body">
      <div class="container-fluid">
        <slot />
      </div>
    </div>

  </div>
</template>
