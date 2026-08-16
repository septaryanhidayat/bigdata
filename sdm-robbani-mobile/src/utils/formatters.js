/**
 * Format angka ke mata uang Rupiah
 */
export function formatRupiah(amount) {
  if (isNaN(amount)) return 'Rp 0';
  return 'Rp ' + Number(amount).toLocaleString('id-ID');
}

/**
 * Sapaan otomatis waktu Indonesia (Pagi, Siang, Sore, Malam)
 */
export function getGreetingIndonesia() {
  const hour = new Date().getHours();
  if (hour >= 3 && hour < 11) return 'Selamat Pagi';
  if (hour >= 11 && hour < 15) return 'Selamat Siang';
  if (hour >= 15 && hour < 18) return 'Selamat Sore';
  return 'Selamat Malam';
}

/**
 * Format tanggal YYYY-MM-DD ke teks Bahasa Indonesia
 */
export function formatDateIndonesia(dateString) {
  if (!dateString) return '-';
  const date = new Date(dateString);
  const months = [
    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];
  const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

  return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
}

/**
 * Format waktu HH:mm
 */
export function formatTime(timeString) {
  if (!timeString) return '--:--';
  return timeString.substring(0, 5) + ' WIB';
}
