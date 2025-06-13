<script setup>
import { computed, defineComponent, onMounted, ref, watch } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { useQuasar } from "quasar";

defineComponent({
  name: "EmployeeLayout",
});

const activeTab = ref(null);
const LEFT_DRAWER_STORAGE_KEY = "face-go.employee.layout.left-drawer-open";
const $q = useQuasar();
const page = usePage();
const leftDrawerOpen = ref(
  JSON.parse(localStorage.getItem(LEFT_DRAWER_STORAGE_KEY))
);
const isDropdownOpen = ref(false);
const toggleLeftDrawer = () => (leftDrawerOpen.value = !leftDrawerOpen.value);

watch(leftDrawerOpen, (newValue) => {
  localStorage.setItem(LEFT_DRAWER_STORAGE_KEY, newValue);
});

onMounted(() => {
  leftDrawerOpen.value = JSON.parse(
    localStorage.getItem(LEFT_DRAWER_STORAGE_KEY)
  );

  if ($q.screen.lt.md) {
    leftDrawerOpen.value = false;
  }
});
</script>

<template>
  <q-layout view="lHh LpR lFf">
    <q-header>
      <q-toolbar class="bg-grey-1 text-black toolbar-scrolled">
        <!-- <q-btn v-if="!leftDrawerOpen" flat dense aria-label="Menu" @click="toggleLeftDrawer">
          <q-icon class="material-symbols-outlined">dock_to_right</q-icon>
        </q-btn> -->
        <slot name="left-button"></slot>
        <q-toolbar-title :class="{ 'q-ml-sm': leftDrawerOpen }" style="font-size: 18px">
          <slot name="title">{{ $config.APP_NAME }}</slot>
        </q-toolbar-title>
        <slot name="right-button"></slot>
      </q-toolbar>
      <slot name="header"></slot>
    </q-header>
    <!-- <q-drawer :breakpoint="768" v-model="leftDrawerOpen" bordered class="bg-grey-2" style="color: #444">
      <div class="absolute-top" style="
          height: 50px;
          border-bottom: 1px solid #ddd;
          align-items: center;
          justify-content: center;
        ">
        <div style="
            width: 100%;
            padding: 8px;
            display: flex;
            justify-content: space-between;
          ">
          <q-btn-dropdown v-model="isDropdownOpen" class="profile-btn text-bold" flat :label="page.props.company.name"
            style="
              justify-content: space-between;
              flex-grow: 1;
              overflow: hidden;
            " :class="{ 'profile-btn-active': isDropdownOpen }">
            <q-list id="profile-btn-popup" style="color: #444">
              <q-item>
                <q-avatar style="margin-left: -15px"><q-icon name="person" /></q-avatar>
                <q-item-section>
                  <q-item-label>
                    <div class="text-bold">NIK: {{ page.props.auth.employee.nik }}</div>
                    <div>{{ page.props.auth.employee.name }}</div>
                  </q-item-label>
                </q-item-section>
              </q-item>

              <q-separator />
              <q-item v-close-popup class="subnav" clickable v-ripple
                :active="$page.url.startsWith('/employee/profile')" @click="router.get(route('employee.profile.edit'))">
                <q-item-section>
                  <q-item-label><q-icon name="manage_accounts" class="q-mr-sm" />Profil Saya</q-item-label>
                </q-item-section>
              </q-item>
              <q-separator />
              <q-item clickable v-close-popup v-ripple style="color: inherit" :href="route('employee.auth.logout')">
                <q-item-section>
                  <q-item-label><q-icon name="logout" class="q-mr-sm" />Logout</q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
          <q-btn v-if="leftDrawerOpen" flat dense aria-label="Menu" @click="toggleLeftDrawer">
            <q-icon name="dock_to_right" />
          </q-btn>
        </div>
      </div>
      <q-scroll-area style="height: calc(100% - 50px); margin-top: 50px">
        <q-list id="main-nav" style="margin-bottom: 50px">
          <q-item clickable v-ripple :active="$page.url.startsWith('/employee/dashboard')"
            @click="router.get(route('employee.dashboard.index'))">
            <q-item-section avatar>
              <q-icon name="dashboard" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Dashboard</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple :active="$page.url.startsWith('/employee/attenndance/check-in')"
            @click="router.get(route('employee.attendance.check-in'))">
            <q-item-section avatar>
              <q-icon name="login" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Check In</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple :active="$page.url.startsWith('/employee/attenndance/check-out')"
            @click="router.get(route('employee.attendance.check-out'))">
            <q-item-section avatar>
              <q-icon name="logout" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Check Out</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-ripple :active="$page.url.startsWith('/employee/attendance/history')"
            @click="router.get(route('employee.attendance.history'))">
            <q-item-section avatar>
              <q-icon name="history" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Riwayat Absensi</q-item-label>
            </q-item-section>
          </q-item>
          <q-separator />
          <q-item clickable v-ripple :active="$page.url.startsWith('/employee/profile')"
            @click="router.get(route('employee.profile.edit'))">
            <q-item-section avatar>
              <q-icon name="manage_accounts" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Profil Saya</q-item-label>
            </q-item-section>
          </q-item>
          <q-item clickable v-close-popup v-ripple style="color: inherit" :href="route('employee.auth.logout')">
            <q-item-section avatar>
              <q-icon name="logout" />
            </q-item-section>
            <q-item-section>
              <q-item-label>Logout</q-item-label>
            </q-item-section>
          </q-item>
          <div class="absolute-bottom text-grey-6 q-pa-md">
            &copy; 2025 -
            {{ $config.APP_NAME + " v" + $config.APP_VERSION_STR }}
          </div>
        </q-list>
      </q-scroll-area>
    </q-drawer> -->
    <q-page-container class="bg-grey-1">
      <q-page>
        <slot></slot>
      </q-page>
    </q-page-container>
    <q-footer>
      <q-tabs v-model="activeTab" indicator-color="yellow" class="bg-primary text-white shadow-2" align="justify" dense>
        <q-tab name="dashboard" icon="home" label="Beranda" @click="router.get(route('employee.dashboard.index'))"
          :class="$page.url.startsWith('/employee/dashboard') ? 'active' : ''" />
        <!-- <q-tab name="calendar" icon="event" label="Kalender" @click="router.get(route('employee.attendance.index'))"
          :class="$page.url.startsWith('/employee/history') ? 'active' : ''" /> -->
        <q-tab name="attendance" icon="photo_camera" label="Absen" @click="router.get(route('employee.attendance.index'))"
          :class="$page.url.startsWith('/employee/attendance') ? 'active' : ''" />
        <!-- <q-tab name="history" icon="history" label="Riwayat" @click="router.get(route('employee.attendance.index'))"
          :class="$page.url.startsWith('/employee/history') ? 'active' : ''" /> -->
        <q-tab name="profile" icon="settings" label="Pengaturan" @click="router.get(route('employee.profile.edit'))"
          :class="$page.url.startsWith('/employee/profile') ? 'active' : ''" />
      </q-tabs>
    </q-footer>
  </q-layout>
</template>

<style>
.q-tabs .q-tab {
  width: 33.33%;
}

.q-tabs .q-tab__label {
  font-weight: normal;
  text-transform: none;
  font-size: 10px;
  color: white;
}

.q-tabs .q-tab__icon {
  font-size: 20px;
  font-weight: normal;
}

.q-tabs .q-tab__icon,
.q-tabs .q-tab__label {
  opacity: 80%;
}

.q-tabs .active .q-tab__icon,
.q-tabs .active .q-tab__label,
.q-tabs .active .q-tab__indicator {
  opacity: 100%;
  color: white;
}

.q-tabs .active .q-tab__icon {
  font-size: 22px;
}

.q-tabs .active .q-tab__label {
  font-size: 11px;
}

.q-tabs .active * {
  color: white !important;
}

.q-tab {
  flex: 1 1 auto;
  /* Ensures all tabs take equal space */
  text-align: center;
}

.profile-btn span.block {
  text-align: left !important;
  width: 100% !important;
  margin-left: 10px !important;
}
</style>
<style scoped>
/* @media screen and (min-width: 768px) {
  .q-footer {
    display: none;
  }
} */

/* .q-toolbar {
  border-bottom: 1px solid transparent;
} */

.toolbar-scrolled {
  /*box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05); */
  border-bottom: 1px solid #ddd;
}

.profile-btn-active {
  background-color: #ddd !important;
}

#profile-btn-popup .q-item--active {
  color: inherit !important;
}
</style>