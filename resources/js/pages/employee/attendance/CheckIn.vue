<script setup>
import { useCamera } from '@/composables/useCamera'
import useLocation from '@/composables/useLocation';
import { useApiForm } from '@/helpers/useApiForm';
import { ref, onMounted } from 'vue';
import { handleSubmit } from "@/helpers/client-req-handler";

let form = useApiForm({
  photo: null,
  location: null,
});

const {
  video,
  canvas,
  photoData,
  takePhoto,
} = useCamera()

const photoTaken = ref(false)

const { getLocation } = useLocation()

onMounted(async () => {
  const { latitude, longitude } = await getLocation();
  form.location = `${latitude},${longitude}`;
})

const submit = async () => {
  try {
    const blob = await (await fetch(photoData.value)).blob()
    form.photo = blob;

    handleSubmit({
      form, url: route('employee.attendance.check-in'), onSuccess: () => {
        // redirect atau tampilkan sukses
        alert('Berhasil absen.')
        window.location.href = '/employee/dashboard'
      }
    })

  } catch (err) {
    alert('Terjadi kesalahan: ' + err.message)
  }
};

const previewPhoto = () => {
  takePhoto()
  photoTaken.value = true
}

const removePhoto = () => {
  photoTaken.value = false
}
</script>

<template>
  <employee-layout>
    <template #title>Absen Masuk</template>
    <template #right-button>
      <q-btn label="Absen" color="primary" icon="login" @click="submit" :disable="!photoTaken" />
    </template>
    <div class="q-pa-sm">
      <div class="row">
        <div class="col-md-6 col">
          <video ref="video" autoplay class="rounded" style="width: 100%;" v-show="!photoTaken" />
          <canvas ref="canvas" v-show="photoTaken" style="width: 100%;" />
          <div class="q-gutter-sm text-center">
            <q-btn label="Ambil Foto" color="primary" icon="photo" :disable="photoTaken" @click="previewPhoto" />
            <q-btn label="Buang" icon="delete" color="red" :disable="!photoTaken" @click="removePhoto" />
          </div>
          <iframe v-if="form.location"
            :src="`https://www.google.com/maps?q=${encodeURIComponent(form.location)}&output=embed`"
            width="100%" height="300" style="border:1px solid #ddd; margin-top: 10px" allowfullscreen loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
      </div>
    </div>
  </employee-layout>
</template>