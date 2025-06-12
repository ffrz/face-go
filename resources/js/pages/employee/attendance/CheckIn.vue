<script setup>

import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { getQueryParams } from "@/helpers/utils";
import { handleSubmit } from "@/helpers/client-req-handler";
import { useForm } from "@inertiajs/vue3";

const title = "Check In";

let form = useForm({
  username: "2025001",
  password: "12345",
  remember: true,
});

const submit = () => handleSubmit({ form, url: route('employee.auth.login') });
const showPassword = ref(false);

</script>

<template>
  <i-head :title="title" />
  <employee-layout>
    <template #title>{{ title }}</template>
    <div class="q-pa-sm">
      <div>
        <div class="text-subtitle1 text-bold text-grey-8">Foto</div>
      </div>
    </div>
  </employee-layout>
</template>
