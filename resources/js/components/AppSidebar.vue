<script setup lang="ts">
  import NavFooter from "@/components/NavFooter.vue";
  import NavMain from "@/components/NavMain.vue";
  import NavUser from "@/components/NavUser.vue";
  import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from "@/components/ui/sidebar";
  import { dashboard } from "@/routes";
  import { index as adminPermissions } from "@/routes/admin/permissions";
  import { index as adminRoles } from "@/routes/admin/roles";
  import { index as adminUsers } from "@/routes/admin/users";
  import { type NavItem } from "@/types";
  import { Link } from "@inertiajs/vue3";
  import { BookOpen, Folder, KeyRound, LayoutGrid, ShieldCheck, Users } from "lucide-vue-next";
  import AppLogo from "./AppLogo.vue";

  const mainNavItems: NavItem[] = [
    {
      title: "Dashboard",
      href: dashboard(),
      icon: LayoutGrid,
    },
  ];

  const adminNavItems: NavItem[] = [
    {
      title: "Users",
      href: adminUsers(),
      icon: Users,
    },
    {
      title: "Roles",
      href: adminRoles(),
      icon: ShieldCheck,
    },
    {
      title: "Permissions",
      href: adminPermissions(),
      icon: KeyRound,
    },
  ];

  const footerNavItems: NavItem[] = [
    {
      title: "Github Repo",
      href: "https://github.com/laravel/vue-starter-kit",
      icon: Folder,
    },
    {
      title: "Documentation",
      href: "https://laravel.com/docs/starter-kits#vue",
      icon: BookOpen,
    },
  ];
</script>

<template>
  <Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="dashboard()">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain :items="mainNavItems" />
      <NavMain :items="adminNavItems" label="Administration" />
    </SidebarContent>

    <SidebarFooter>
      <NavFooter :items="footerNavItems" />
      <NavUser />
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>
