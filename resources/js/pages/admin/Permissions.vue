<script setup lang="ts">
  import AppLayout from "@/layouts/AppLayout.vue";
  import { index as adminPermissions, store as storePermission } from "@/routes/admin/permissions";
  import { type BreadcrumbItem } from "@/types";
  import { Form, Head } from "@inertiajs/vue3";
  import { ref } from "vue";

  import InputError from "@/components/InputError.vue";
  import { Badge } from "@/components/ui/badge";
  import { Button } from "@/components/ui/button";
  import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog";
  import { Input } from "@/components/ui/input";
  import { KeyRound, Plus } from "lucide-vue-next";

  interface PermissionListItem {
    id: number;
    name: string;
    guardName: string;
    rolesCount: number;
    createdAt: string;
  }

  interface Props {
    permissions: PermissionListItem[];
  }

  const props = defineProps<Props>();

  const breadcrumbs: BreadcrumbItem[] = [
    {
      title: "Permissions",
      href: adminPermissions().url,
    },
  ];

  const isDetailOpen = ref(false);
  const isCreateOpen = ref(false);
  const selectedPermission = ref<PermissionListItem | null>(null);

  const openDetail = (permission: PermissionListItem) => {
    selectedPermission.value = permission;
    isDetailOpen.value = true;
  };

  const closeCreateModal = () => {
    isCreateOpen.value = false;
  };
</script>

<template>
  <Head title="Permissions" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-1 flex-col gap-6 p-6">
      <div class="flex flex-wrap items-start justify-between gap-4">
        <div class="flex flex-col gap-1">
          <h1 class="text-2xl font-semibold text-foreground">Permissions</h1>
          <p class="text-sm text-muted-foreground">Fine-tune access for specific actions.</p>
        </div>

        <Button class="gap-2" @click="isCreateOpen = true">
          <Plus class="size-4" />
          Create permission
        </Button>
      </div>

      <div v-if="props.permissions.length" class="grid gap-4">
        <button
          v-for="permission in props.permissions"
          :key="permission.id"
          type="button"
          class="group flex w-full items-center justify-between gap-4 rounded-xl border border-border bg-card p-4 text-left shadow-xs transition hover:border-primary/50 hover:bg-accent/40"
          @click="openDetail(permission)"
        >
          <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-foreground">{{ permission.name }}</span>
            <span class="text-xs text-muted-foreground">Guard: {{ permission.guardName }}</span>
          </div>
          <div class="flex items-center gap-3 text-xs text-muted-foreground">
            <Badge variant="secondary">{{ permission.rolesCount }} roles</Badge>
            <span>Created {{ permission.createdAt }}</span>
          </div>
        </button>
      </div>

      <div v-else class="flex flex-col items-center justify-center gap-3 rounded-xl border border-dashed border-border bg-muted/30 p-10 text-center">
        <div class="flex size-12 items-center justify-center rounded-full bg-muted text-muted-foreground">
          <KeyRound class="size-5" />
        </div>
        <div class="flex flex-col gap-1">
          <p class="text-sm font-medium text-foreground">No permissions yet</p>
          <p class="text-xs text-muted-foreground">Create a permission to begin assigning access.</p>
        </div>
        <Button size="sm" class="gap-2" @click="isCreateOpen = true">
          <Plus class="size-4" />
          Create permission
        </Button>
      </div>
    </div>
  </AppLayout>

  <Dialog :open="isDetailOpen" @update:open="isDetailOpen = $event">
    <DialogContent class="sm:max-w-lg">
      <DialogHeader class="gap-2">
        <DialogTitle>Permission details</DialogTitle>
        <DialogDescription>Review how this permission is applied.</DialogDescription>
      </DialogHeader>

      <div v-if="selectedPermission" class="grid gap-4">
        <div class="rounded-lg border border-border p-4">
          <p class="text-base font-semibold text-foreground">{{ selectedPermission.name }}</p>
          <p class="text-sm text-muted-foreground">Guard: {{ selectedPermission.guardName }}</p>
        </div>
        <div class="grid gap-4 rounded-lg border border-border p-4 text-sm">
          <div class="flex items-center justify-between gap-4">
            <span class="text-muted-foreground">Roles using permission</span>
            <span class="font-medium text-foreground">{{ selectedPermission.rolesCount }}</span>
          </div>
          <div class="flex items-center justify-between gap-4">
            <span class="text-muted-foreground">Created</span>
            <span class="font-medium text-foreground">{{ selectedPermission.createdAt }}</span>
          </div>
        </div>
      </div>
    </DialogContent>
  </Dialog>

  <Dialog :open="isCreateOpen" @update:open="isCreateOpen = $event">
    <DialogContent class="sm:max-w-lg">
      <DialogHeader class="gap-2">
        <DialogTitle>Create permission</DialogTitle>
        <DialogDescription>Define a new action that roles can use.</DialogDescription>
      </DialogHeader>
      <Form
        v-bind="storePermission.form()"
        class="grid gap-4"
        reset-on-success
        :options="{ onSuccess: closeCreateModal }"
        v-slot="{ errors, processing }"
      >
        <Input id="create-permission-name" name="name" label="Permission name" variant="filled" required />
        <InputError :message="errors.name" />

        <div class="flex items-center justify-end gap-3 pt-2">
          <Button type="button" variant="ghost" @click="closeCreateModal">Cancel</Button>
          <Button type="submit" :disabled="processing">Create permission</Button>
        </div>
      </Form>
    </DialogContent>
  </Dialog>
</template>
