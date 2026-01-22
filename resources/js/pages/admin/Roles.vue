<script setup lang="ts">
  import AppLayout from "@/layouts/AppLayout.vue";
  import { index as adminRoles, store as storeRole } from "@/routes/admin/roles";
  import { type BreadcrumbItem } from "@/types";
  import { Form, Head } from "@inertiajs/vue3";
  import { ref } from "vue";

  import InputError from "@/components/InputError.vue";
  import { Badge } from "@/components/ui/badge";
  import { Button } from "@/components/ui/button";
  import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog";
  import { Input } from "@/components/ui/input";
  import { Plus, ShieldCheck } from "lucide-vue-next";

  interface RoleListItem {
    id: number;
    name: string;
    guardName: string;
    permissionsCount: number;
    usersCount: number;
    createdAt: string;
  }

  interface Props {
    roles: RoleListItem[];
  }

  const props = defineProps<Props>();

  const breadcrumbs: BreadcrumbItem[] = [
    {
      title: "Roles",
      href: adminRoles().url,
    },
  ];

  const isDetailOpen = ref(false);
  const isCreateOpen = ref(false);
  const selectedRole = ref<RoleListItem | null>(null);

  const openDetail = (role: RoleListItem) => {
    selectedRole.value = role;
    isDetailOpen.value = true;
  };

  const closeCreateModal = () => {
    isCreateOpen.value = false;
  };
</script>

<template>
  <Head title="Roles" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-1 flex-col gap-6 p-6">
      <div class="flex flex-wrap items-start justify-between gap-4">
        <div class="flex flex-col gap-1">
          <h1 class="text-2xl font-semibold text-foreground">Roles</h1>
          <p class="text-sm text-muted-foreground">Define access levels for teams and projects.</p>
        </div>

        <Button class="gap-2" @click="isCreateOpen = true">
          <Plus class="size-4" />
          Create role
        </Button>
      </div>

      <div v-if="props.roles.length" class="grid gap-4">
        <button
          v-for="role in props.roles"
          :key="role.id"
          type="button"
          class="group flex w-full items-center justify-between gap-4 rounded-xl border border-border bg-card p-4 text-left shadow-xs transition hover:border-primary/50 hover:bg-accent/40"
          @click="openDetail(role)"
        >
          <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-foreground">{{ role.name }}</span>
            <span class="text-xs text-muted-foreground">Guard: {{ role.guardName }}</span>
          </div>
          <div class="flex items-center gap-3 text-xs text-muted-foreground">
            <Badge variant="secondary">{{ role.permissionsCount }} permissions</Badge>
            <Badge variant="outline">{{ role.usersCount }} users</Badge>
            <span>Created {{ role.createdAt }}</span>
          </div>
        </button>
      </div>

      <div v-else class="flex flex-col items-center justify-center gap-3 rounded-xl border border-dashed border-border bg-muted/30 p-10 text-center">
        <div class="flex size-12 items-center justify-center rounded-full bg-muted text-muted-foreground">
          <ShieldCheck class="size-5" />
        </div>
        <div class="flex flex-col gap-1">
          <p class="text-sm font-medium text-foreground">No roles yet</p>
          <p class="text-xs text-muted-foreground">Create a role to begin assigning access.</p>
        </div>
        <Button size="sm" class="gap-2" @click="isCreateOpen = true">
          <Plus class="size-4" />
          Create role
        </Button>
      </div>
    </div>
  </AppLayout>

  <Dialog :open="isDetailOpen" @update:open="isDetailOpen = $event">
    <DialogContent class="sm:max-w-lg">
      <DialogHeader class="gap-2">
        <DialogTitle>Role details</DialogTitle>
        <DialogDescription>Understand the access this role provides.</DialogDescription>
      </DialogHeader>

      <div v-if="selectedRole" class="grid gap-4">
        <div class="rounded-lg border border-border p-4">
          <p class="text-base font-semibold text-foreground">{{ selectedRole.name }}</p>
          <p class="text-sm text-muted-foreground">Guard: {{ selectedRole.guardName }}</p>
        </div>
        <div class="grid gap-4 rounded-lg border border-border p-4 text-sm">
          <div class="flex items-center justify-between gap-4">
            <span class="text-muted-foreground">Permissions</span>
            <span class="font-medium text-foreground">{{ selectedRole.permissionsCount }}</span>
          </div>
          <div class="flex items-center justify-between gap-4">
            <span class="text-muted-foreground">Users with role</span>
            <span class="font-medium text-foreground">{{ selectedRole.usersCount }}</span>
          </div>
          <div class="flex items-center justify-between gap-4">
            <span class="text-muted-foreground">Created</span>
            <span class="font-medium text-foreground">{{ selectedRole.createdAt }}</span>
          </div>
        </div>
      </div>
    </DialogContent>
  </Dialog>

  <Dialog :open="isCreateOpen" @update:open="isCreateOpen = $event">
    <DialogContent class="sm:max-w-lg">
      <DialogHeader class="gap-2">
        <DialogTitle>Create role</DialogTitle>
        <DialogDescription>Set up a new access level for your team.</DialogDescription>
      </DialogHeader>
      <Form
        v-bind="storeRole.form()"
        class="grid gap-4"
        reset-on-success
        :options="{ onSuccess: closeCreateModal }"
        v-slot="{ errors, processing }"
      >
        <Input id="create-role-name" name="name" label="Role name" variant="filled" required />
        <InputError :message="errors.name" />

        <div class="flex items-center justify-end gap-3 pt-2">
          <Button type="button" variant="ghost" @click="closeCreateModal">Cancel</Button>
          <Button type="submit" :disabled="processing">Create role</Button>
        </div>
      </Form>
    </DialogContent>
  </Dialog>
</template>
