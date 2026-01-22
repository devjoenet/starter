<script setup lang="ts">
  import AppLayout from "@/layouts/AppLayout.vue";
  import { index as adminUsers, store as storeUser, update as updateUser } from "@/routes/admin/users";
  import { type BreadcrumbItem } from "@/types";
  import { Form, Head } from "@inertiajs/vue3";
  import { computed, ref, watch } from "vue";

  import InputError from "@/components/InputError.vue";
  import { Badge } from "@/components/ui/badge";
  import { Button } from "@/components/ui/button";
  import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from "@/components/ui/dialog";
  import { DropdownMenu, DropdownMenuContent, DropdownMenuRadioGroup, DropdownMenuRadioItem, DropdownMenuTrigger } from "@/components/ui/dropdown-menu";
  import { Input } from "@/components/ui/input";
  import { Label } from "@/components/ui/label";
  import { ChevronDown, Plus, UserRound } from "lucide-vue-next";

  interface UserListItem {
    id: number;
    name: string;
    email: string;
    emailVerifiedAt: string | null;
    createdAt: string;
    roleId: number | null;
    roleName: string | null;
  }

  interface RoleOption {
    id: number;
    name: string;
  }

  interface Props {
    users: UserListItem[];
    roles: RoleOption[];
    canEditUsers: boolean;
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
  const selectedRoleId = ref<number | null>(null);
  const selectedCreateRoleId = ref<string | null>(null);

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

  const canSubmitUpdate = computed(() => {
    if (!props.canEditUsers || !selectedUser.value) {
      return false;
    }

    return selectedRoleId.value !== null && selectedRoleId.value !== selectedUser.value.roleId;
  });

  const selectedCreateRoleLabel = computed(() => {
    if (!selectedCreateRoleId.value) {
      return "Select a role";
    }

    return props.roles.find((role) => String(role.id) === selectedCreateRoleId.value)?.name ?? "Select a role";
  });

  watch(
    selectedUser,
    (user) => {
      selectedRoleId.value = user?.roleId ?? null;
    },
    { immediate: true },
  );

  watch(isCreateOpen, (open) => {
    if (!open) {
      selectedCreateRoleId.value = null;
    }
  });
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

      <Form v-if="selectedUser" v-bind="updateUser.form(selectedUser.id)" class="flex flex-col gap-6" v-slot="{ processing }">
        <input type="hidden" name="name" :value="selectedUser.name" />
        <input type="hidden" name="email" :value="selectedUser.email" />

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
          <div class="flex items-center justify-between gap-4">
            <span class="text-muted-foreground">Role</span>
            <div v-if="props.canEditUsers" class="w-56">
              <div class="group relative flex w-full items-center gap-2 rounded-xl border border-input bg-transparent px-3 py-2 text-sm text-foreground shadow-xs transition focus-within:ring-2 focus-within:ring-ring/40">
                <select id="detail-user-role" v-model="selectedRoleId" name="role_id" class="w-full bg-transparent text-sm text-foreground outline-none disabled:cursor-not-allowed disabled:opacity-50" :disabled="!props.roles.length" required>
                  <option :value="null" disabled>Select a role</option>
                  <option v-for="role in props.roles" :key="role.id" :value="role.id">
                    {{ role.name }}
                  </option>
                </select>
              </div>
            </div>
            <span v-else class="font-medium text-foreground">
              {{ selectedUser.roleName ?? "No role assigned" }}
            </span>
          </div>
        </div>

        <div class="flex items-center justify-end gap-3">
          <Button type="button" variant="ghost" @click="isDetailOpen = false">Close</Button>
          <Button type="submit" :disabled="!canSubmitUpdate || processing">Update user</Button>
        </div>
      </Form>
    </DialogContent>
  </Dialog>

  <Dialog :open="isCreateOpen" @update:open="isCreateOpen = $event">
    <DialogContent class="sm:max-w-lg">
      <DialogHeader class="gap-2">
        <DialogTitle>Create user</DialogTitle>
        <DialogDescription>Invite a new teammate and assign their access.</DialogDescription>
      </DialogHeader>

      <Form v-bind="storeUser.form()" class="grid gap-4" reset-on-success :options="{ onSuccess: closeCreateModal }" autocomplete="off" v-slot="{ errors, processing }">
        <Input id="create-user-name" name="name" label="Full name" variant="filled" autocomplete="off" required />
        <InputError :message="errors.name" />

        <Input id="create-user-email" name="email" type="email" label="Email address" variant="filled" autocomplete="off" required />
        <InputError :message="errors.email" />

        <Input id="create-user-password" name="password" type="password" label="Password" variant="filled" autocomplete="new-password" required />
        <InputError :message="errors.password" />

        <Input id="create-user-password-confirmation" name="password_confirmation" type="password" label="Confirm password" variant="filled" autocomplete="new-password" required />
        <InputError :message="errors.password_confirmation" />

        <div class="grid gap-1.5">
          <Label for="create-user-role">Role</Label>
          <input type="hidden" name="role_id" :value="selectedCreateRoleId ?? ''" />
          <DropdownMenu>
            <DropdownMenuTrigger as-child>
              <button
                id="create-user-role"
                type="button"
                class="group flex w-full items-center justify-between gap-2 rounded-xl border border-input bg-transparent px-3 py-3 text-base shadow-xs transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring/40 disabled:cursor-not-allowed disabled:opacity-50"
                :disabled="!props.roles.length"
              >
                <span :class="selectedCreateRoleId ? 'text-foreground' : 'text-muted-foreground'">{{ selectedCreateRoleLabel }}</span>
                <ChevronDown class="size-4 text-muted-foreground transition group-data-[state=open]:rotate-180" />
              </button>
            </DropdownMenuTrigger>
            <DropdownMenuContent class="w-(--reka-dropdown-menu-trigger-width) min-w-56 rounded-lg" align="start">
              <DropdownMenuRadioGroup v-model="selectedCreateRoleId">
                <DropdownMenuRadioItem v-for="role in props.roles" :key="role.id" :value="String(role.id)">
                  {{ role.name }}
                </DropdownMenuRadioItem>
              </DropdownMenuRadioGroup>
            </DropdownMenuContent>
          </DropdownMenu>
        </div>
        <InputError :message="errors.role_id" />

        <div class="flex items-center justify-end gap-3 pt-2">
          <Button type="button" variant="ghost" @click="closeCreateModal">Cancel</Button>
          <Button type="submit" :disabled="processing">Create user</Button>
        </div>
      </Form>
    </DialogContent>
  </Dialog>
</template>
