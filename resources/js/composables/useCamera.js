import { ref, onMounted, onBeforeUnmount } from 'vue'

export function useCamera() {
  const video = ref(null)
  const canvas = ref(null)
  const photoData = ref(null)
  let stream = null

  const startCamera = async () => {
    try {
      stream = await navigator.mediaDevices.getUserMedia({ video: true })
      if (video.value) {
        video.value.srcObject = stream
        await video.value.play()
      }
    } catch (err) {
      alert('Gagal mengakses webcam: ' + err.message)
    }
  }

  const stopCamera = () => {
    if (stream) {
      stream.getTracks().forEach(track => track.stop())
    }
  }

  const takePhoto = () => {
    if (!video.value || !canvas.value) return null

    const width = video.value.videoWidth
    const height = video.value.videoHeight

    canvas.value.width = width
    canvas.value.height = height
    const ctx = canvas.value.getContext('2d')
    ctx.drawImage(video.value, 0, 0, width, height)
    photoData.value = canvas.value.toDataURL('image/jpeg')

    return photoData.value
  }

  onMounted(startCamera)
  onBeforeUnmount(stopCamera)

  return {
    video,
    canvas,
    photoData,
    startCamera,
    stopCamera,
    takePhoto,
  }
}
