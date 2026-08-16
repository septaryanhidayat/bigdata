import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity,
  ScrollView,
  Alert,
  ActivityIndicator,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import GeofenceRadar from '../components/GeofenceRadar';
import CameraAttendanceModal from '../components/CameraAttendanceModal';
import StatusBadge from '../components/StatusBadge';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';
import { hrisApi } from '../api/hrisApi';

export default function AttendanceScreen({ navigation }) {
  const { unit, employee } = useAuth();
  const { colors } = useTheme();

  const [currentTime, setCurrentTime] = useState(new Date());
  const [distanceMeters, setDistanceMeters] = useState(38); // Jarak radius
  const [isMockDetected, setIsMockDetected] = useState(false);
  const [cameraModalVisible, setCameraModalVisible] = useState(false);
  const [attendanceMode, setAttendanceMode] = useState('check-in');
  const [isSubmitting, setIsSubmitting] = useState(false);
  const [lastResult, setLastResult] = useState(null);

  // Live Clock
  useEffect(() => {
    const timer = setInterval(() => setCurrentTime(new Date()), 1000);
    return () => clearInterval(timer);
  }, []);

  const schoolRadius = unit?.radius_meters || 150;
  const isWithinRadius = distanceMeters <= schoolRadius;

  const handleOpenFaceCamera = (mode) => {
    if (isMockDetected) {
      Alert.alert(
        'Presensi Ditolak',
        'Sistem mendeteksi Fake GPS / Mock Location pada perangkat Anda. Harap matikan aplikasi lokasi tiruan untuk melanjutkan.'
      );
      return;
    }

    setAttendanceMode(mode);
    setCameraModalVisible(true);
  };

  const handleCaptureFace = async (faceBase64, photoUri) => {
    setIsSubmitting(true);
    try {
      const payload = {
        latitude: isWithinRadius ? (location?.coords?.latitude || unit?.latitude) : (unit?.latitude || -3.22080000),
        longitude: isWithinRadius ? (location?.coords?.longitude || unit?.longitude) : (unit?.longitude || 104.65040000),
        is_mocked: isMockDetected,
        face_image: faceBase64 || photoUri,
      };

      const res =
        attendanceMode === 'check-in'
          ? await hrisApi.checkIn(payload)
          : await hrisApi.checkOut(payload);

      if (res?.status === 'success') {
        setLastResult(res);
        Alert.alert('Alhamdulillah! Presensi Berhasil', res.message || 'Presensi selfie Anda telah berhasil dicatat ke sistem database.');
      } else {
        Alert.alert('Informasi Presensi', res?.message || 'Presensi selfie Anda telah diproses.');
      }
    } catch (e) {
      const errorMsg = e.response?.data?.message || e.message || 'Terjadi kendala saat menghubungkan ke server presensi.';
      const isRejected = e.response?.status === 422 || e.response?.data?.status === 'error';
      Alert.alert(isRejected ? '⛔ Presensi Belum Masuk' : 'Kendala Koneksi', errorMsg);
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Presensi Wajah &amp; GPS" subtitle={unit?.name} />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Live Clock Card */}
        <View style={[styles.clockCard, { backgroundColor: colors.primary }]}>
          <Text style={styles.clockDate}>
            {currentTime.toLocaleDateString('id-ID', {
              weekday: 'long',
              day: 'numeric',
              month: 'long',
              year: 'numeric',
            })}
          </Text>
          <Text style={styles.clockTime}>
            {currentTime.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' })} WIB
          </Text>
          <View style={styles.clockScheduleRow}>
            <Text style={styles.clockScheduleText}>Jam Kerja: 06:45 - 15:30 WIB</Text>
            <Text style={styles.clockScheduleBadge}>Toleransi s/d 07:15</Text>
          </View>
        </View>

        {/* Live Distance Notification Banner */}
        <View
          style={{
            marginHorizontal: 16,
            marginBottom: 14,
            padding: 14,
            borderRadius: 16,
            backgroundColor: isWithinRadius ? '#ecfdf5' : '#fef2f2',
            borderWidth: 1.5,
            borderColor: isWithinRadius ? '#10b981' : '#ef4444',
            shadowColor: '#000',
            shadowOffset: { width: 0, height: 2 },
            shadowOpacity: 0.05,
            shadowRadius: 4,
            elevation: 2,
          }}
        >
          <View style={{ flexDirection: 'row', alignItems: 'center', gap: 8, marginBottom: 4 }}>
            <Text style={{ fontSize: 16 }}>{isWithinRadius ? '🎯' : '📍'}</Text>
            <Text
              style={{
                fontSize: 13,
                fontWeight: 'bold',
                color: isWithinRadius ? '#065f46' : '#991b1b',
              }}
            >
              {isWithinRadius
                ? `Jarak Anda: ${distanceMeters} Meter (Di Dalam Radius)`
                : `Jarak Anda: ${distanceMeters} Meter (Di Luar Radius)`}
            </Text>
          </View>
          <Text
            style={{
              fontSize: 11,
              lineHeight: 16,
              color: isWithinRadius ? '#047857' : '#b91c1c',
              fontWeight: '500',
            }}
          >
            {isWithinRadius
              ? `✓ Posisi Anda memenuhi syarat geofence (${distanceMeters}m dari batas maks ${schoolRadius}m di ${unit?.name || 'SIT Robbani'}). Presensi siap direkam.`
              : `⚠️ Anda berada ${distanceMeters} meter dari titik kampus. Batas maksimal yang diizinkan adalah ${schoolRadius} meter. Jika presensi ditolak, silakan mendekat ke lokasi sekolah.`}
          </Text>
        </View>

        {/* Radar Geofence */}
        <GeofenceRadar
          distanceMeters={distanceMeters}
          maxRadiusMeters={schoolRadius}
          isMockDetected={isMockDetected}
        />

        {/* Simulation Controls for Testing */}
        <View style={[styles.simBox, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.simTitle, { color: colors.textLight }]}>🧪 Kontrol Uji Coba Cepat (Simulator GPS):</Text>
          <View style={styles.simBtnRow}>
            <TouchableOpacity
              style={[styles.simBtn, { backgroundColor: isWithinRadius ? colors.primary : colors.surfaceSub }]}
              onPress={() => {
                setDistanceMeters(40);
                setIsMockDetected(false);
              }}
            >
              <Text style={[styles.simBtnText, { color: isWithinRadius ? '#fff' : colors.text }]}>
                ✓ Di Dalam (40m)
              </Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={[styles.simBtn, { backgroundColor: !isWithinRadius ? '#f59e0b' : colors.surfaceSub }]}
              onPress={() => {
                setDistanceMeters(250);
                setIsMockDetected(false);
              }}
            >
              <Text style={[styles.simBtnText, { color: !isWithinRadius ? '#fff' : colors.text }]}>
                ⚠️ Luar (250m)
              </Text>
            </TouchableOpacity>
            <TouchableOpacity
              style={[styles.simBtn, { backgroundColor: isMockDetected ? '#dc2626' : colors.surfaceSub }]}
              onPress={() => setIsMockDetected(!isMockDetected)}
            >
              <Text style={[styles.simBtnText, { color: isMockDetected ? '#fff' : colors.text }]}>
                🚫 Fake GPS
              </Text>
            </TouchableOpacity>
          </View>
        </View>

        {/* Action Buttons */}
        <View style={styles.actionSection}>
          <TouchableOpacity
            style={[
              styles.actionBtn,
              {
                backgroundColor: isWithinRadius && !isMockDetected ? colors.primary : '#94a3b8',
              },
            ]}
            onPress={() => handleOpenFaceCamera('check-in')}
            disabled={isSubmitting}
            activeOpacity={0.8}
          >
            {isSubmitting && attendanceMode === 'check-in' ? (
              <ActivityIndicator color="#fff" />
            ) : (
              <>
                <Text style={styles.actionBtnIcon}>📸</Text>
                <Text style={styles.actionBtnText}>Presensi Masuk (Selfie)</Text>
              </>
            )}
          </TouchableOpacity>

          <TouchableOpacity
            style={[
              styles.actionBtn,
              {
                backgroundColor: isWithinRadius && !isMockDetected ? colors.secondary : '#94a3b8',
              },
            ]}
            onPress={() => handleOpenFaceCamera('check-out')}
            disabled={isSubmitting}
            activeOpacity={0.8}
          >
            {isSubmitting && attendanceMode === 'check-out' ? (
              <ActivityIndicator color="#fff" />
            ) : (
              <>
                <Text style={styles.actionBtnIcon}>🚪</Text>
                <Text style={styles.actionBtnText}>Presensi Pulang (Selfie)</Text>
              </>
            )}
          </TouchableOpacity>
        </View>

        {/* Face Enrollment Quick Button */}
        <TouchableOpacity
          style={[styles.enrollShortcutBtn, { backgroundColor: colors.surface, borderColor: colors.border }]}
          onPress={() => navigation.navigate('FaceEnrollment')}
          activeOpacity={0.7}
        >
          <Text style={[styles.enrollShortcutText, { color: colors.primary }]}>
            👤 Belum Mendaftarkan Wajah? Klik di Sini untuk Perekaman Face ID ➔
          </Text>
        </TouchableOpacity>

        {/* Riwayat Tombol Cepat */}
        <TouchableOpacity
          style={[styles.historyBtn, { backgroundColor: colors.surface, borderColor: colors.border }]}
          onPress={() => navigation.navigate('History')}
          activeOpacity={0.7}
        >
          <Text style={[styles.historyBtnText, { color: colors.text }]}>
            📅 Lihat Rekap Presensi Bulanan Lengkap ➔
          </Text>
        </TouchableOpacity>

      </ScrollView>

      {/* Face Scanner Modal Live Camera */}
      <CameraAttendanceModal
        visible={cameraModalVisible}
        onClose={() => setCameraModalVisible(false)}
        onCapture={handleCaptureFace}
        title={attendanceMode === 'check-in' ? 'Presensi Masuk (Selfie)' : 'Presensi Pulang (Selfie)'}
        subtitle="Posisikan wajah Anda tepat di dalam lingkaran oval"
      />
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
  },
  scrollContent: {
    padding: 16,
    paddingBottom: 40,
  },
  clockCard: {
    borderRadius: 24,
    padding: 20,
    alignItems: 'center',
    marginBottom: 8,
    shadowColor: '#000',
    shadowOpacity: 0.15,
    shadowRadius: 10,
    elevation: 4,
  },
  clockDate: {
    color: '#c6f634',
    fontSize: 12,
    fontWeight: '800',
    textTransform: 'uppercase',
    letterSpacing: 0.5,
  },
  clockTime: {
    color: '#ffffff',
    fontSize: 32,
    fontWeight: '900',
    marginVertical: 4,
    letterSpacing: 1,
  },
  clockScheduleRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 8,
    marginTop: 4,
  },
  clockScheduleText: {
    color: 'rgba(255,255,255,0.9)',
    fontSize: 11,
    fontWeight: '600',
  },
  clockScheduleBadge: {
    backgroundColor: 'rgba(255,255,255,0.2)',
    color: '#ffffff',
    fontSize: 10,
    fontWeight: '800',
    paddingHorizontal: 6,
    paddingVertical: 2,
    borderRadius: 6,
  },
  simBox: {
    padding: 12,
    borderRadius: 16,
    borderWidth: 1,
    marginVertical: 8,
  },
  simTitle: {
    fontSize: 11,
    fontWeight: '600',
    marginBottom: 8,
  },
  simBtnRow: {
    flexDirection: 'row',
    gap: 6,
  },
  simBtn: {
    flex: 1,
    paddingVertical: 7,
    borderRadius: 10,
    alignItems: 'center',
  },
  simBtnText: {
    fontSize: 10,
    fontWeight: '800',
  },
  actionSection: {
    gap: 10,
    marginVertical: 12,
  },
  actionBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'center',
    paddingVertical: 16,
    borderRadius: 18,
    gap: 8,
    shadowColor: '#000',
    shadowOpacity: 0.12,
    shadowRadius: 8,
    elevation: 3,
  },
  actionBtnIcon: {
    fontSize: 18,
  },
  actionBtnText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: '900',
  },
  enrollShortcutBtn: {
    paddingVertical: 13,
    paddingHorizontal: 16,
    borderRadius: 16,
    borderWidth: 1,
    alignItems: 'center',
    marginTop: 4,
    marginBottom: 4,
  },
  enrollShortcutText: {
    fontSize: 11,
    fontWeight: '800',
    textAlign: 'center',
  },
  historyBtn: {
    paddingVertical: 14,
    borderRadius: 16,
    borderWidth: 1,
    alignItems: 'center',
    marginTop: 4,
  },
  historyBtnText: {
    fontSize: 12,
    fontWeight: '800',
  },
});
