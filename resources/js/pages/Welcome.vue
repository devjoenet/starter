<script lang="ts" setup>
  //
</script>
<template>
  <UApp>
    <UHeader :title="$page.props.name">
      <template #right>
        <UColorModeButton as="button" :disabled="false" color="neutral" variant="ghost" />
        <UButton to="https://github.com/devjoenet/starter" target="_blank" icon="simple-icons:github" aria-label="GitHub" color="neutral" variant="ghost" />
      </template>
    </UHeader>
    <UMain> </UMain>
  </UApp>
</template>
