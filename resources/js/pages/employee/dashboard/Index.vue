<script setup>

import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { getQueryParams } from "@/helpers/utils";

const title = "Dashboard";
const showFilter = ref(true);
const selected_period = ref(getQueryParams()["period"] ?? "this_month");

const page = usePage();

const period_options = ref([
  { value: "today", label: "Hari Ini" },
  { value: "yesterday", label: "Kemarin" },
  { value: "this_week", label: "Minggu Ini" },
  { value: "last_week", label: "Minggu Lalu" },
  { value: "this_month", label: "Bulan Ini" },
  { value: "last_month", label: "Bulan Lalu" },
  { value: "this_year", label: "Tahun Ini" },
  { value: "last_year", label: "Tahun Lalu" },
  { value: "last_7_days", label: "7 Hari Terakhir" },
  { value: "last_30_days", label: "30 Hari Terakhir" },
  { value: "all_time", label: "Seluruh Waktu" },
]);
const onFilterChange = () => {
  router.visit(route("employee.dashboard", { period: selected_period.value }));
};
</script>

<template>
  <i-head :title="title" />
  <employee-layout>
    <template #title>{{ title }}</template>
    <template #right-button>
      <q-btn
        class="q-ml-sm"
        :icon="!showFilter ? 'filter_alt' : 'filter_alt_off'"
        color="grey"
        dense
        @click="showFilter = !showFilter"
      />
    </template>
    <template #header v-if="showFilter">
      <q-toolbar class="filter-bar">
        <div class="row q-col-gutter-xs items-center q-pa-sm full-width">
          <q-select
            class="custom-select col-12"
            style="min-width: 150px"
            v-model="selected_period"
            :options="period_options"
            label="Bulan"
            dense
            map-options
            emit-value
            outlined
            @update:model-value="onFilterChange"
          />
        </div>
      </q-toolbar>
    </template>
    <div class="q-pa-sm">
      <div>
        <div class="text-subtitle1 text-bold text-grey-8">Statistik Aktual</div>
        <p class="text-grey-8">Fitur belum tersedia!</p>
      </div>
      <div class="q-pt-md">
        <div class="text-subtitle1 text-bold text-grey-8">
          Statistik {{period_options.find((a) => a.value == selected_period).label}}
        </div>
        <p class="text-grey-8">Fitur belum tersedia!</p>
      </div>
      <div class="q-pt-sm">
        <div class="row q-col-gutter-sm">
          <div class="col-md-6 col-12">

          </div>
          <div class="col-md-6 col-12">

          </div>
        </div>
      </div>
      <div>

      </div>
    </div>
  </employee-layout>
</template>
