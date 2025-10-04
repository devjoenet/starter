<script setup lang="ts">
  import { getCopyright } from "@/composables/useCopyright";
</script>

<template>
  <UApp>
    <UHeader :title="$page.props.name">
      <template #right>
        <UColorModeButton as="button" :disabled="false" color="neutral" variant="ghost" />
        <UButton to="https://github.com/devjoenet/starter" target="_blank" icon="simple-icons:github" aria-label="GitHub - devjoenet" color="neutral" variant="ghost" />
      </template>
    </UHeader>

    <UMain>
      <slot />
    </UMain>

    <UFooter>
      <template #left>
        <p class="text-muted text-sm">{{ getCopyright() }}</p>
      </template>

      <template #right>
        <UButton to="https://github.com/devjoenet/starter" target="_blank" icon="simple-icons:github" aria-label="GitHub - devjoenet" color="neutral" variant="ghost" />
      </template>
    </UFooter>
  </UApp>
</template>
