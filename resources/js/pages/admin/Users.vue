<script setup lang="ts">
  import AppLayout from "@/layouts/AppLayout.vue";
  import { index as adminUsers, store as storeUser } from "@/routes/admin/users";
  import { type BreadcrumbItem } from "@/types";
  import { Form, Head } from "@inertiajs/vue3";
  import { computed, ref } from "vue";

  import InputError from "@/components/InputError.vue";
  import { Badge } from "@/components/ui/badge";
  import { Button } from "@/components/ui/button";
  import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog";
  import { Input } from "@/components/ui/input";
  import { Plus, UserRound } from "lucide-vue-next";

  interface UserListItem {
    id: number;
    name: string;
    email: string;
    emailVerifiedAt: string | null;
    createdAt: string;
  }

  interface Props {
    users: UserListItem[];
  }

  const props = defineProps<Props>();

  const breadcrumbs: BreadcrumbItem[] = [
    {
      title: "Users",
      href: adminUsers().url,
    },
  ];

  const isDetailOpen = ref(false);
  const isCreateOpen = ref(false);
  const selectedUser = ref<UserListItem | null>(null);

  const selectedUserInitials = computed(() => {
    if (!selectedUser.value) {
      return "";
    }

    return selectedUser.value.name
      .split(" ")
      .map((part) => part.charAt(0))
      .join("")
      .slice(0, 2)
      .toUpperCase();
  });

  const openDetail = (user: UserListItem) => {
    selectedUser.value = user;
    isDetailOpen.value = true;
  };

  const closeCreateModal = () => {
    isCreateOpen.value = false;
  };
</script>

<template>
  <Head title="Users" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex flex-1 flex-col gap-6 p-6">
      <div class="flex flex-wrap items-start justify-between gap-4">
        <div class="flex flex-col gap-1">
          <h1 class="text-2xl font-semibold text-foreground">Users</h1>
          <p class="text-sm text-muted-foreground">Manage the people who can access your workspace.</p>
        </div>

        <Button class="gap-2" @click="isCreateOpen = true">
          <Plus class="size-4" />
          Create user
        </Button>
      </div>

      <div v-if="props.users.length" class="grid gap-4">
        <button v-for="user in props.users" :key="user.id" type="button" class="group flex w-full items-center justify-between gap-4 rounded-xl border border-border bg-card p-4 text-left shadow-xs transition hover:border-primary/50 hover:bg-accent/40" @click="openDetail(user)">
          <div class="flex items-center gap-4">
            <div class="flex size-11 items-center justify-center rounded-full border border-border bg-muted text-sm font-semibold text-foreground">
              {{ user.name.charAt(0) }}
            </div>
            <div class="flex flex-col gap-1">
              <span class="text-sm font-medium text-foreground">{{ user.name }}</span>
              <span class="text-xs text-muted-foreground">{{ user.email }}</span>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <Badge :variant="user.emailVerifiedAt ? 'secondary' : 'outline'">
              {{ user.emailVerifiedAt ? "Verified" : "Unverified" }}
            </Badge>
            <span class="text-xs text-muted-foreground">Joined {{ user.createdAt }}</span>
          </div>
        </button>
      </div>

      <div v-else class="flex flex-col items-center justify-center gap-3 rounded-xl border border-dashed border-border bg-muted/30 p-10 text-center">
        <div class="flex size-12 items-center justify-center rounded-full bg-muted text-muted-foreground">
          <UserRound class="size-5" />
        </div>
        <div class="flex flex-col gap-1">
          <p class="text-sm font-medium text-foreground">No users yet</p>
          <p class="text-xs text-muted-foreground">Create the first user to get started.</p>
        </div>
        <Button size="sm" class="gap-2" @click="isCreateOpen = true">
          <Plus class="size-4" />
          Create user
        </Button>
      </div>
    </div>
  </AppLayout>

  <Dialog :open="isDetailOpen" @update:open="isDetailOpen = $event">
    <DialogContent class="sm:max-w-lg">
      <DialogHeader class="gap-2">
        <DialogTitle>User details</DialogTitle>
        <DialogDescription>Review profile and access information.</DialogDescription>
      </DialogHeader>

      <div v-if="selectedUser" class="flex flex-col gap-6">
        <div class="flex items-center gap-4">
          <div class="flex size-14 items-center justify-center rounded-full border border-border bg-muted text-lg font-semibold text-foreground">
            {{ selectedUserInitials }}
          </div>
          <div class="flex flex-col gap-1">
            <p class="text-base font-semibold text-foreground">{{ selectedUser.name }}</p>
            <p class="text-sm text-muted-foreground">{{ selectedUser.email }}</p>
          </div>
        </div>

        <div class="grid gap-4 rounded-lg border border-border p-4 text-sm">
          <div class="flex items-center justify-between gap-4">
            <span class="text-muted-foreground">Status</span>
            <Badge :variant="selectedUser.emailVerifiedAt ? 'secondary' : 'outline'">
              {{ selectedUser.emailVerifiedAt ? "Verified" : "Unverified" }}
            </Badge>
          </div>
          <div class="flex items-center justify-between gap-4">
            <span class="text-muted-foreground">Joined</span>
            <span class="font-medium text-foreground">{{ selectedUser.createdAt }}</span>
          </div>
        </div>
      </div>
    </DialogContent>
  </Dialog>

  <Dialog :open="isCreateOpen" @update:open="isCreateOpen = $event">
    <DialogContent class="sm:max-w-lg">
      <DialogHeader class="gap-2">
        <DialogTitle>Create user</DialogTitle>
        <DialogDescription>Invite a new teammate and assign their access.</DialogDescription>
      </DialogHeader>

      <Form v-bind="storeUser.form()" class="grid gap-4" reset-on-success :options="{ onSuccess: closeCreateModal }" v-slot="{ errors, processing }">
        <Input id="create-user-name" name="name" label="Full name" variant="filled" required />
        <InputError :message="errors.name" />

        <Input id="create-user-email" name="email" type="email" label="Email address" variant="filled" required />
        <InputError :message="errors.email" />

        <Input id="create-user-password" name="password" type="password" label="Password" variant="filled" required />
        <InputError :message="errors.password" />

        <Input id="create-user-password-confirmation" name="password_confirmation" type="password" label="Confirm password" variant="filled" required />
        <InputError :message="errors.password_confirmation" />

        <div class="flex items-center justify-end gap-3 pt-2">
          <Button type="button" variant="ghost" @click="closeCreateModal">Cancel</Button>
          <Button type="submit" :disabled="processing">Create user</Button>
        </div>
      </Form>
    </DialogContent>
  </Dialog>
</template>
