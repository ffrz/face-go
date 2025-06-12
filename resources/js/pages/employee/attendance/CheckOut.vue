<script setup>
import AttendanceCamera from './partial/AttendanceCamera.vue'
</script>

<template>
  <AttendanceCamera title="Absen Keluar" submit-label="Absen Keluar" icon="logout"
    :submit-route="route('employee.attendance.check-out')" />
</template>
