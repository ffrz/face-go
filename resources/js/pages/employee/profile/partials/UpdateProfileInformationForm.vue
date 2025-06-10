<script setup>
import { handleSubmit } from '@/helpers/client-req-handler';
import { scrollToFirstErrorField } from '@/helpers/utils';
import { useForm, usePage } from '@inertiajs/vue3';

const page = usePage();
const employee = page.props.auth.employee;
const form = useForm({
  nik: employee.nik,
  name: employee.name,
  phone: page.props.data.phone,
  address: page.props.data.address,
  role: 'Karyawan',
});

const submit = () =>
  handleSubmit({ form, url: route('employee.profile.update') });
</script>

<template>
  <q-form class="row" @submit.prevent="submit" @validation-error="scrollToFirstErrorField">
    <q-card square flat bordered class="col">
      <q-card-section>
        <div class="text-h6 q-my-xs text-subtitle1">Profil Saya</div>
        <p class="text-caption text-grey-9">Perbarui profil anda.</p>
        <q-input readonly v-model="form.nik" label="NIK" :disable="form.processing" />
        <q-input v-model.trim="form.name" label="Nama" :disable="form.processing" lazy-rules :error="!!form.errors.name"
          :error-message="form.errors.name" :rules="[]" readonly />
        <q-input v-model.trim="form.phone" type="text" label="No HP" lazy-rules :disable="form.processing"
          :error="!!form.errors.phone" :error-message="form.errors.phone" :rules="[]" />
        <q-input v-model.trim="form.address" type="textarea" autogrow counter maxlength="500" label="Alamat" lazy-rules
          :disable="form.processing" :error="!!form.errors.address" :error-message="form.address" :rules="[]" />
        <q-input readonly v-model="form.role" label="Hak Akses" :disable="form.processing" />
      </q-card-section>
      <q-card-section>
        <q-btn type="submit" color="primary" label="Perbarui Profil Saya" :disable="form.processing" icon="save" />
      </q-card-section>
    </q-card>
  </q-form>
</template>
