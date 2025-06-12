<script setup>
import AttendanceCamera from './partial/AttendanceCamera.vue'
</script>

<template>
  <AttendanceCamera title="Absen Masuk" submit-label="Absen Masuk" icon="login"
    :submit-route="route('employee.attendance.check-in')" />
</template>
