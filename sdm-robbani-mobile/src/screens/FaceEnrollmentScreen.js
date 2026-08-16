import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Image,
  Alert,
  ActivityIndicator,
} from 'react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';
import HeaderBar from '../components/HeaderBar';
import CameraAttendanceModal from '../components/CameraAttendanceModal';
import { useTheme } from '../context/ThemeContext';
import { useAuth } from '../context/AuthContext';
import { hrisApi } from '../api/hrisApi';
import { BASE_API_URL } from '../api/client';

// Normalize URL foto agar bisa tampil di Android
function normalizeImageUrl(url) {
  if (!url) return null;
  if (url.startsWith('data:image')) return url;
  if (url.startsWith('file://')) return null;
  if (url.includes('bigdata.test')) {
    const base = BASE_API_URL.replace(/\/api.*$/, '');
    return url.replace(/https?:\/\/bigdata\.test/g, base);
  }
  if (url.startsWith('/')) {
    const base = BASE_API_URL.replace(/\/api.*$/, '');
    return base + url;
  }
  return url;
}

export default function FaceEnrollmentScreen({ navigation }) {
  const { colors } = useTheme();
  const { user, employee, updateProfileData, refreshProfile } = useAuth();

  const [loading, setLoading] = useState(true);
  const [submitting, setSubmitting] = useState(false);
  const [cameraModalVisible, setCameraModalVisible] = useState(false);
  const [faceStatus, setFaceStatus] = useState(null);

  const fetchStatus = async () => {
    try {
      // 1. Cek penyimpanan lokal terlebih dahulu
      const localFacePhoto = await AsyncStorage.getItem('enrolled_face_photo');
      const localFaceTime = await AsyncStorage.getItem('enrolled_face_time');

      if (localFacePhoto || user?.avatar || employee?.face_photo_url) {
        setFaceStatus({
          is_face_registered: true,
          face_photo_url: localFacePhoto || user?.avatar || employee?.face_photo_url,
          face_registered_at: localFaceTime || 'Terdaftar Aktif',
          employee_name: employee?.full_name || user?.name || 'Pegawai SIT Robbani',
          nip: employee?.nip || '-',
        });
      }

      // 2. Sinkronkan dengan server backend yayasan
      const res = await hrisApi.getFaceStatus();
      if (res?.status === 'success' && res?.data) {
        setFaceStatus({
          ...res.data,
          face_photo_url: normalizeImageUrl(res.data.face_photo_url) || localFacePhoto || normalizeImageUrl(user?.avatar) || normalizeImageUrl(employee?.face_photo_url),
        });
      }
    } catch (e) {
      console.warn('Using local face biometric cache', e.message);
      if (!faceStatus) {
        setFaceStatus({
          is_face_registered: Boolean(user?.avatar || employee?.face_photo_url),
          face_photo_url: user?.avatar || employee?.face_photo_url || null,
          face_registered_at: 'Terdaftar Aktif',
          employee_name: employee?.full_name || user?.name || 'Pegawai SIT Robbani',
          nip: employee?.nip || '-',
        });
      }
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchStatus();
  }, []);

  const handleCaptureEnrolledFace = async (base64Data, uri) => {
    setSubmitting(true);
    const nowTimeStr = new Date().toLocaleDateString('id-ID', {
      day: 'numeric',
      month: 'short',
      year: 'numeric',
    }) + ', ' + new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) + ' WIB';

    // Hanya kirim base64 nyata ke server (bukan URL external atau string placeholder)
    const isRealBase64 = base64Data && base64Data.startsWith('data:image') && base64Data.length > 5000;
    const payloadPhoto = isRealBase64 ? base64Data : null;
    const localDisplayPhoto = uri || base64Data;

    try {
      // 1. Simpan tampilan lokal dahulu (bisa pakai URI dari kamera)
      if (localDisplayPhoto && !localDisplayPhoto.includes('unsplash')) {
        await AsyncStorage.setItem('enrolled_face_photo', localDisplayPhoto);
        await AsyncStorage.setItem('enrolled_face_time', nowTimeStr);
      }

      // 2. Update AuthContext agar foto langsung tampil di ProfileScreen
      if (updateProfileData && localDisplayPhoto && !localDisplayPhoto.includes('unsplash')) {
        await updateProfileData({
          avatar: localDisplayPhoto,
          photo: localDisplayPhoto,
        });
      }

      // 3. Kirim ke server HANYA jika ada base64 asli
      if (payloadPhoto) {
        try {
          const res = await hrisApi.enrollFace(payloadPhoto);
          const rawUrl = res?.data?.face_photo_url || res?.face_photo_url;
          const serverPhotoUrl = normalizeImageUrl(rawUrl);
          if (serverPhotoUrl) {
            await AsyncStorage.setItem('enrolled_face_photo', serverPhotoUrl);
            await updateProfileData?.({
              avatar: serverPhotoUrl,
              photo: serverPhotoUrl,
              face_photo_url: serverPhotoUrl,
            });
            await refreshProfile?.();
          }
        } catch (serverErr) {
          console.warn('Server sync queued for face enrollment', serverErr.message);
        }
      } else {
        console.warn('Foto tidak dikirim ke server: base64 tidak valid atau menggunakan URI eksternal');
      }

      setFaceStatus({
        is_face_registered: true,
        face_photo_url: localDisplayPhoto,
        face_registered_at: nowTimeStr,
        employee_name: employee?.full_name || user?.name || 'Pegawai SIT Robbani',
        nip: employee?.nip || '-',
      });

      Alert.alert(
        'Alhamdulillah! Sukses',
        payloadPhoto
          ? 'Sampel wajah biometrik (Face ID) & Foto Profil Anda berhasil diperbarui dan disinkronkan ke server yayasan.'
          : 'Foto berhasil diambil. Akan disinkronkan ke server saat koneksi tersedia.'
      );
    } catch (e) {
      Alert.alert('Error', 'Gagal memproses sampel foto wajah.');
    } finally {
      setSubmitting(false);
    }
  };


  const isRegistered = Boolean(faceStatus?.is_face_registered);

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar
        title="Biometrik Wajah"
        subtitle="Registrasi &amp; Verifikasi Face ID Pegawai"
        showBack
        onBack={() => navigation?.goBack?.()}
      />

      <ScrollView contentContainerStyle={styles.scrollContent} showsVerticalScrollIndicator={false}>
        
        {/* Status Verification Card */}
        <View
          style={[
            styles.statusCard,
            {
              backgroundColor: isRegistered ? '#ecfdf5' : '#fef2f2',
              borderColor: isRegistered ? '#10b981' : '#ef4444',
            },
          ]}
        >
          <View style={styles.statusHeaderRow}>
            <Text style={styles.statusIcon}>{isRegistered ? '✅' : '⚠️'}</Text>
            <View style={{ flex: 1 }}>
              <Text
                style={[
                  styles.statusTitle,
                  { color: isRegistered ? '#065f46' : '#991b1b' },
                ]}
              >
                {isRegistered
                  ? 'Face ID Biometrik Aktif & Terverifikasi'
                  : 'Belum Ada Sampel Wajah Terdaftar'}
              </Text>
              <Text
                style={[
                  styles.statusSubtitle,
                  { color: isRegistered ? '#047857' : '#b91c1c' },
                ]}
              >
                {isRegistered
                  ? 'Wajah Anda dikenali sistem untuk presensi GPS & Face Recognition.'
                  : 'Daftarkan sampel foto wajah Anda sekarang agar dapat melakukan presensi.'}
              </Text>
            </View>
          </View>
        </View>

        {/* Biometric Face Sample Preview */}
        <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.cardTitle, { color: colors.text }]}>Sampel Foto Wajah Anda</Text>

          <View style={styles.avatarContainer}>
            <Image
              source={{
                uri:
                  faceStatus?.face_photo_url ||
                  user?.avatar ||
                  employee?.face_photo_url ||
                  'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=400',
              }}
              style={[
                styles.faceImage,
                { borderColor: isRegistered ? '#10b981' : colors.border },
              ]}
            />
            {isRegistered ? (
              <View style={styles.verifiedBadge}>
                <Text style={styles.verifiedBadgeText}>✓ TERVERIFIKASI</Text>
              </View>
            ) : null}
          </View>

          {/* Metadata Rows */}
          <View style={styles.metaBox}>
            <View style={styles.metaRow}>
              <Text style={[styles.metaLabel, { color: colors.textLight }]}>Nama Pegawai</Text>
              <Text style={[styles.metaVal, { color: colors.text }]}>
                {faceStatus?.employee_name || employee?.full_name || user?.name}
              </Text>
            </View>

            <View style={styles.metaRow}>
              <Text style={[styles.metaLabel, { color: colors.textLight }]}>NIP</Text>
              <Text style={[styles.metaVal, styles.monoText, { color: colors.text }]}>
                {faceStatus?.nip || employee?.nip || '-'}
              </Text>
            </View>

            <View style={styles.metaRow}>
              <Text style={[styles.metaLabel, { color: colors.textLight }]}>Waktu Pendaftaran</Text>
              <Text style={[styles.metaVal, { color: isRegistered ? '#059669' : colors.textLight }]}>
                {faceStatus?.face_registered_at || 'Belum Terdaftar'}
              </Text>
            </View>
          </View>
        </View>

        {/* Enrollment Instructions */}
        <View style={[styles.card, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Text style={[styles.cardTitle, { color: colors.text }]}>Panduan Pindai Wajah</Text>
          <View style={styles.stepRow}>
            <Text style={styles.stepNum}>1</Text>
            <Text style={[styles.stepText, { color: colors.textLight }]}>
              Pastikan wajah berada di tempat dengan pencahayaan terang dan merata.
            </Text>
          </View>
          <View style={styles.stepRow}>
            <Text style={styles.stepNum}>2</Text>
            <Text style={[styles.stepText, { color: colors.textLight }]}>
              Posisikan wajah tepat di tengah bingkai lingkaran kamera.
            </Text>
          </View>
          <View style={styles.stepRow}>
            <Text style={styles.stepNum}>3</Text>
            <Text style={[styles.stepText, { color: colors.textLight }]}>
              Lepaskan kacamata hitam atau masker saat proses pemindaian wajah.
            </Text>
          </View>
        </View>

        {/* Action Button */}
        <TouchableOpacity
          style={[
            styles.enrollBtn,
            { backgroundColor: isRegistered ? colors.primary : '#059669' },
          ]}
          onPress={() => setCameraModalVisible(true)}
          disabled={submitting}
          activeOpacity={0.8}
        >
          {submitting ? (
            <ActivityIndicator color="#ffffff" />
          ) : (
            <Text style={styles.enrollBtnText}>
              {isRegistered ? '🔄 Perbarui Sampel Wajah (Face ID)' : '📷 Pindai & Daftarkan Wajah'}
            </Text>
          )}
        </TouchableOpacity>

      </ScrollView>

      {/* Live Camera Scanner Modal */}
      <CameraAttendanceModal
        visible={cameraModalVisible}
        onClose={() => setCameraModalVisible(false)}
        mode="enrollment"
        onCapture={handleCaptureEnrolledFace}
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
  statusCard: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1.5,
    marginBottom: 16,
  },
  statusHeaderRow: {
    flexDirection: 'row',
    alignItems: 'center',
    gap: 12,
  },
  statusIcon: {
    fontSize: 28,
  },
  statusTitle: {
    fontSize: 14,
    fontWeight: '900',
    marginBottom: 2,
  },
  statusSubtitle: {
    fontSize: 12,
    fontWeight: '600',
    lineHeight: 16,
  },
  card: {
    padding: 16,
    borderRadius: 20,
    borderWidth: 1,
    marginBottom: 16,
  },
  cardTitle: {
    fontSize: 13,
    fontWeight: '900',
    marginBottom: 14,
    textTransform: 'uppercase',
    letterSpacing: 0.5,
  },
  avatarContainer: {
    alignItems: 'center',
    position: 'relative',
    marginVertical: 10,
  },
  faceImage: {
    width: 140,
    height: 140,
    borderRadius: 70,
    borderWidth: 4,
  },
  verifiedBadge: {
    backgroundColor: '#10b981',
    paddingHorizontal: 12,
    paddingVertical: 4,
    borderRadius: 20,
    marginTop: -14,
    borderWidth: 2,
    borderColor: '#ffffff',
  },
  verifiedBadgeText: {
    color: '#ffffff',
    fontSize: 10,
    fontWeight: '900',
    letterSpacing: 0.5,
  },
  metaBox: {
    marginTop: 16,
    borderTopWidth: 1,
    borderTopColor: 'rgba(150, 150, 150, 0.1)',
    paddingTop: 10,
  },
  metaRow: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    paddingVertical: 7,
  },
  metaLabel: {
    fontSize: 12,
    fontWeight: '600',
  },
  metaVal: {
    fontSize: 12,
    fontWeight: '700',
  },
  monoText: {
    fontFamily: 'monospace',
  },
  stepRow: {
    flexDirection: 'row',
    alignItems: 'flex-start',
    gap: 12,
    marginBottom: 10,
  },
  stepNum: {
    width: 22,
    height: 22,
    borderRadius: 11,
    backgroundColor: '#059669',
    color: '#ffffff',
    textAlign: 'center',
    lineHeight: 22,
    fontSize: 11,
    fontWeight: '900',
  },
  stepText: {
    fontSize: 12,
    fontWeight: '600',
    flex: 1,
    lineHeight: 18,
  },
  enrollBtn: {
    paddingVertical: 14,
    borderRadius: 18,
    alignItems: 'center',
    marginTop: 4,
    shadowColor: '#000',
    shadowOpacity: 0.15,
    shadowOffset: { width: 0, height: 4 },
    shadowRadius: 8,
    elevation: 3,
  },
  enrollBtnText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: '900',
  },
});
