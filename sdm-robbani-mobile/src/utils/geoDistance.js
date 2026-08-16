/**
 * Menghitung jarak antara 2 koordinat (lat, lng) dalam meter menggunakan rumus Haversine
 */
export function calculateDistance(lat1, lon1, lat2, lon2) {
  const R = 6371000; // Radius bumi dalam meter
  const dLat = ((lat2 - lat1) * Math.PI) / 180;
  const dLon = ((lon2 - lon1) * Math.PI) / 180;
  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos((lat1 * Math.PI) / 180) *
      Math.cos((lat2 * Math.PI) / 180) *
      Math.sin(dLon / 2) *
      Math.sin(dLon / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return Math.round(R * c);
}

/**
 * Validasi apakah pegawai berada di dalam batas radius geofencing sekolah
 */
export function isWithinGeofence(userLat, userLng, schoolLat, schoolLng, maxRadiusMeters) {
  const distance = calculateDistance(userLat, userLng, schoolLat, schoolLng);
  return {
    isInside: distance <= maxRadiusMeters,
    distanceMeters: distance,
    allowedRadius: maxRadiusMeters,
    diffMeters: Math.max(0, distance - maxRadiusMeters)
  };
}
