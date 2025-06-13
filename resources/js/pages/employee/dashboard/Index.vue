<script setup>

import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { getQueryParams } from "@/helpers/utils";

const title = "Dashboard";
const page = usePage();

const handleCheckIn = () => {
  router.visit(route('employee.attendance.check-in'))
}

const handleCheckOut = () => {
  router.visit(route('employee.attendance.check-out'))
}


</script>

<template>
  <i-head :title="title" />
  <employee-layout>
    <template #title>Hi, {{ page.props.auth.employee.name }}</template>
    <template #right-button>

    </template>
    <template #header>

    </template>
    <div class="q-pa-sm">
      <div class="row q-col-gutter-sm ">
        <div class="col-sm-6 col-xs-12">
          <q-item :style="`background-color: #888`" class="q-pa-none" clickable @click="handleCheckIn">
            <q-item-section side :style="`background-color: #666`" class="q-pa-sm q-mr-none text-white">
              <q-img
                :src="page.props.data.today_attendance?.check_in_photo ? '/' + page.props.data.today_attendance.check_in_photo : '/assets/img/no-image.png'"
                spinner-color="white" style="width: 64px; height: 64px; border-radius: 25%" />
            </q-item-section>
            <q-item-section class=" q-pa-md q-ml-none  text-white">
              <q-item-label>Masuk</q-item-label>
              <q-item-label class="text-white text-weight-bolder">
                {{ page.props.data.today_attendance?.check_in_time ?
                  $dayjs(page.props.data.today_attendance?.check_in_time).format('HH:mm:ss') : 'Belum Absen' }}
              </q-item-label>
            </q-item-section>
          </q-item>
        </div>
        <div class="col-sm-6 col-xs-12">
          <q-item :style="`background-color: #888`" class="q-pa-none" clickable @click="handleCheckOut">
            <q-item-section side :style="`background-color: #666`" class="q-pa-sm q-mr-none text-white">
              <q-img
                :src="page.props.data.today_attendance?.check_out_photo ? '/' + page.props.data.today_attendance.check_out_photo : '/assets/img/no-image.png'"
                spinner-color="white" style="width: 64px; height: 64px; border-radius: 25%" />
            </q-item-section>
            <q-item-section class=" q-pa-md q-ml-none  text-white">
              <q-item-label>Pulang</q-item-label>
              <q-item-label class="text-white text-weight-bolder">
                {{ page.props.data.today_attendance?.check_out_time ?
                  $dayjs(page.props.data.today_attendance.check_out_time).format('HH:mm:ss') : 'Belum Absen' }}
              </q-item-label>
            </q-item-section>
          </q-item>
        </div>
      </div>
    </div>
  </employee-layout>
</template>
