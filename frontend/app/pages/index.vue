<script setup lang="ts">
definePageMeta({
    layout: "home",
})

useHead({
    title: "Welcome"
})
</script>
<template>
  <div>
    <NuxtRouteAnnouncer />
    <NuxtWelcome />
  </div>
</template>
