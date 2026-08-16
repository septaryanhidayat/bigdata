import React, { useState, useEffect } from 'react';
import {
  View,
  Text,
  StyleSheet,
  ScrollView,
  TouchableOpacity,
  Image,
  Alert,
  Switch,
  RefreshControl,
} from 'react-native';
import HeaderBar from '../components/HeaderBar';
import { useAuth } from '../context/AuthContext';
import { useTheme } from '../context/ThemeContext';

export default function ProfileScreen({ navigation }) {
  const { user, employee, unit, logout, refreshProfile } = useAuth();
  const { colors, isDarkMode, toggleDarkMode } = useTheme();
  const [refreshing, setRefreshing] = useState(false);

  useEffect(() => {
    // Auto sync from server whenever Profile tab is opened
    refreshProfile?.();
  }, []);

  const onRefresh = async () => {
    setRefreshing(true);
    try {
      await refreshProfile?.();
    } finally {
      setRefreshing(false);
    }
  };

  const handleLogout = () => {
    Alert.alert('Konfirmasi Keluar', 'Apakah Anda yakin ingin keluar dari aplikasi SDM SIT Robbani?', [
      { text: 'Batal', style: 'cancel' },
      { text: 'Keluar', style: 'destructive', onPress: logout },
    ]);
  };

  const attendanceLoc = employee?.active_attendance_location || {
    campus_name: unit?.name || 'Kampus Utama Yayasan SIT Robbani',
    latitude: unit?.latitude || -3.220800,
    longitude: unit?.longitude || 104.650400,
    radius_meters: unit?.radius_meters || 150,
    address: unit?.address || 'Jl. Lintas Timur KM 35 Indralaya, Ogan Ilir',
  };

  return (
    <View style={[styles.container, { backgroundColor: colors.bg }]}>
      <HeaderBar title="Profil & Informasi SDM" subtitle="Sinkronisasi Data Real SIT Robbani" />

      <ScrollView 
        contentContainerStyle={styles.scrollContent} 
        showsVerticalScrollIndicator={false}
        refreshControl={
          <RefreshControl
            refreshing={refreshing}
            onRefresh={onRefresh}
            tintColor={colors.primary}
            colors={[colors.primary]}
          />
        }
      >
        
        {/* Profile Hero Card */}
        <View style={[styles.profileCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <Image
            source={{ uri: user?.avatar || employee?.face_photo_url || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=200' }}
            style={[styles.avatarBig, { borderColor: colors.primary }]}
          />
          <Text style={[styles.name, { color: colors.text }]}>{employee?.full_name || user?.name || 'Pegawai SIT Robbani'}</Text>
          <Text style={[styles.position, { color: colors.primary }]}>{employee?.position || 'Tenaga Pendidik (Guru)'}</Text>
          <Text style={[styles.nipText, { color: colors.textLight }]}>NIP: {employee?.nip || '-'}</Text>

          <View style={[styles.unitPill, { backgroundColor: colors.surfaceSub, borderColor: colors.border }]}>
            <Text style={[styles.unitPillText, { color: colors.text }]}>🏫 {employee?.unit_name || unit?.name || 'Yayasan Generasi Robbani'}</Text>
          </View>
        </View>

        {/* 1. Informasi Kepegawaian */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>💼 Informasi Kepegawaian &amp; Tugas</Text>
        <View style={[styles.infoCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Jabatan Utama</Text>
            <Text style={[styles.infoVal, { color: colors.primary, fontWeight: '800' }]}>{employee?.position || 'Tenaga Pendidik (Guru)'}</Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Status Kepegawaian</Text>
            <View style={[styles.statusBadge, { backgroundColor: colors.primary + '18', borderColor: colors.primary }]}>
              <Text style={[styles.statusBadgeText, { color: colors.primary }]}>{employee?.employment_status || 'Guru Tetap Yayasan (GTY)'}</Text>
            </View>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Unit Penempatan</Text>
            <Text style={[styles.infoVal, { color: colors.text }]}>{employee?.unit_name || unit?.name || 'Yayasan Generasi Robbani'}</Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Nomor NIP</Text>
            <Text style={[styles.infoVal, styles.monoText, { color: colors.text }]}>{employee?.nip || '-'}</Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Nomor NIK KTP</Text>
            <Text style={[styles.infoVal, styles.monoText, { color: colors.text }]}>{employee?.nik || '-'}</Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Pendidikan Terakhir</Text>
            <Text style={[styles.infoVal, { color: colors.text }]}>{employee?.last_education || 'S1'} — {employee?.major || 'Pendidikan'}</Text>
          </View>
        </View>

        {/* 2. Informasi Kontak & Biodata Pribadi */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>👤 Kontak &amp; Biodata Pribadi</Text>
        <View style={[styles.infoCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Email Resmi Aktif</Text>
            <Text style={[styles.infoVal, { color: colors.primary, fontWeight: '700' }]}>{employee?.email || user?.email || '-'}</Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Nomor WhatsApp / HP</Text>
            <Text style={[styles.infoVal, styles.monoText, { color: colors.text }]}>{employee?.wa_number || employee?.phone || user?.phone || '-'}</Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Tempat, Tanggal Lahir</Text>
            <Text style={[styles.infoVal, { color: colors.text }]}>{employee?.birth_info || 'Palembang, 15 Mei 1990'}</Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Alamat Domisili</Text>
            <Text style={[styles.infoVal, { color: colors.text, maxWidth: '60%' }]}>{employee?.address || 'Indralaya, Kab. Ogan Ilir, Sumsel'}</Text>
          </View>
        </View>

        {/* 3. Lokasi Absen yang Aktif (Geofencing Detection) */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>📍 Lokasi Presensi yang Aktif (Geofence)</Text>
        <View style={[styles.infoCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Kampus Presensi</Text>
            <Text style={[styles.infoVal, { color: colors.primary, fontWeight: '800' }]}>{attendanceLoc.campus_name || attendanceLoc.name}</Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Titik Koordinat GPS</Text>
            <Text style={[styles.infoVal, styles.monoText, { color: colors.text, fontSize: 11 }]}>
              {Number(attendanceLoc.latitude).toFixed(6)}, {Number(attendanceLoc.longitude).toFixed(6)}
            </Text>
          </View>

          <View style={styles.infoRow}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Radius Maksimal</Text>
            <Text style={[styles.infoVal, { color: '#059669', fontWeight: '800' }]}>{attendanceLoc.radius_meters} Meter dari Titik Pusat</Text>
          </View>

          <View style={[styles.infoRow, { borderBottomWidth: 0, paddingBottom: 0 }]}>
            <Text style={[styles.infoLabel, { color: colors.textLight }]}>Alamat Kampus</Text>
            <Text style={[styles.infoVal, { color: colors.textLight, fontSize: 11, maxWidth: '60%' }]}>
              {attendanceLoc.address || 'Jl. Lintas Timur KM 35 Indralaya'}
            </Text>
          </View>
        </View>

        {/* 4. Pengaturan Aplikasi & Aksi */}
        <Text style={[styles.sectionTitle, { color: colors.text }]}>⚙️ Pengaturan &amp; Aksi Akun</Text>
        <View style={[styles.infoCard, { backgroundColor: colors.surface, borderColor: colors.border }]}>
          <View style={styles.settingRow}>
            <Text style={[styles.settingLabel, { color: colors.text }]}>Mode Gelap (Dark Theme)</Text>
            <Switch
              value={isDarkMode}
              onValueChange={toggleDarkMode}
              trackColor={{ false: '#cbd5e1', true: colors.primary }}
              thumbColor="#ffffff"
            />
          </View>

          <TouchableOpacity
            style={styles.settingBtn}
            onPress={() => navigation?.navigate?.('EditProfile')}
          >
            <Text style={[styles.settingBtnText, { color: colors.text }]}>✏️ Ubah Kontak &amp; Kata Sandi Akun</Text>
            <Text style={[styles.arrowText, { color: colors.primary }]}>➔</Text>
          </TouchableOpacity>

          <TouchableOpacity
            style={styles.settingBtn}
            onPress={() => navigation?.navigate?.('FaceEnrollment')}
          >
            <Text style={[styles.settingBtnText, { color: colors.text }]}>👤 Kelola Biometrik Wajah (Face ID)</Text>
            <Text style={[styles.arrowText, { color: colors.primary }]}>➔</Text>
          </TouchableOpacity>
        </View>

        {/* Logout Button */}
        <TouchableOpacity style={styles.logoutBtn} onPress={handleLogout} activeOpacity={0.8}>
          <Text style={styles.logoutBtnText}>🚪 Keluar dari Akun</Text>
        </TouchableOpacity>

        <Text style={[styles.versionText, { color: colors.textLight }]}>
          SDM SIT Robbani Mobile v1.0.0 • Database Real Terintegrasi
        </Text>

      </ScrollView>
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
  profileCard: {
    padding: 20,
    borderRadius: 24,
    borderWidth: 1,
    alignItems: 'center',
    marginBottom: 16,
  },
  avatarBig: {
    width: 84,
    height: 84,
    borderRadius: 42,
    borderWidth: 3,
    marginBottom: 12,
  },
  name: {
    fontSize: 17,
    fontWeight: '900',
    textAlign: 'center',
  },
  position: {
    fontSize: 13,
    fontWeight: '800',
    marginTop: 2,
  },
  nipText: {
    fontSize: 11,
    marginTop: 2,
    fontFamily: 'monospace',
  },
  unitPill: {
    paddingHorizontal: 12,
    paddingVertical: 5,
    borderRadius: 20,
    borderWidth: 1,
    marginTop: 10,
  },
  unitPillText: {
    fontSize: 11,
    fontWeight: '800',
  },
  sectionTitle: {
    fontSize: 12,
    fontWeight: '900',
    textTransform: 'uppercase',
    letterSpacing: 0.5,
    marginBottom: 8,
    marginTop: 8,
  },
  infoCard: {
    borderRadius: 20,
    borderWidth: 1,
    padding: 14,
    marginBottom: 16,
  },
  infoRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'between',
    paddingVertical: 9,
    borderBottomWidth: 1,
    borderBottomColor: 'rgba(150, 150, 150, 0.1)',
  },
  infoLabel: {
    fontSize: 12,
    fontWeight: '600',
    flex: 1,
  },
  infoVal: {
    fontSize: 12,
    fontWeight: '600',
    textAlign: 'right',
  },
  monoText: {
    fontFamily: 'monospace',
    fontWeight: '700',
  },
  statusBadge: {
    paddingHorizontal: 8,
    paddingVertical: 3,
    borderRadius: 8,
    borderWidth: 1,
  },
  statusBadgeText: {
    fontSize: 11,
    fontWeight: '800',
  },
  settingRow: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 8,
    borderBottomWidth: 1,
    borderBottomColor: 'rgba(150, 150, 150, 0.1)',
  },
  settingLabel: {
    fontSize: 13,
    fontWeight: '700',
  },
  settingBtn: {
    flexDirection: 'row',
    alignItems: 'center',
    justifyContent: 'space-between',
    paddingVertical: 12,
    borderBottomWidth: 1,
    borderBottomColor: 'rgba(150, 150, 150, 0.1)',
  },
  settingBtnText: {
    fontSize: 13,
    fontWeight: '700',
  },
  arrowText: {
    fontSize: 14,
    fontWeight: '900',
  },
  logoutBtn: {
    backgroundColor: '#ef4444',
    paddingVertical: 14,
    borderRadius: 18,
    alignItems: 'center',
    marginTop: 10,
    shadowColor: '#ef4444',
    shadowOpacity: 0.25,
    shadowOffset: { width: 0, height: 4 },
    shadowRadius: 8,
    elevation: 3,
  },
  logoutBtnText: {
    color: '#ffffff',
    fontSize: 14,
    fontWeight: '900',
  },
  versionText: {
    fontSize: 11,
    textAlign: 'center',
    marginTop: 16,
  },
});
